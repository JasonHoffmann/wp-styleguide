<?php
/**
 * 
 */
class Styleguide_API_Sections extends Styleguide_API {
	
	/**
	 * Register Routes for the styles endpoint
	 *
	 * @return array an array of all rest endpoints
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, 'sections', array(
			array(
				'methods' 								=> WP_REST_Server::READABLE,
				'callback' 								=> array( $this, 'get_sections' ),
				'permission_callback' 		=> array( $this, 'permissions_check' )
			),
			array(
				'methods'									=> WP_REST_Server::CREATABLE,
				'callback'								=> array( $this, 'create_section' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			)
		));
		
		register_rest_route( $this->namespace, '/sections' . '/(?P<id>[\d]+)', array(
			array(
				'methods'									=> WP_REST_Server::READABLE,
				'callback'								=> array( $this, 'get_section' ),
				'permission_callback'			=> array( $this, 'permissions_check' )
			),
			array(
				'methods'									=> WP_REST_Server::EDITABLE,
				'callback'								=> array( $this, 'update_section' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			),
			array(
				'methods'									=> WP_REST_Server::DELETABLE,
				'callback'								=> array( $this, 'delete_section' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			)
		));
	}
	
	/**
	 * Callback for getting a list of sections
	 *
	 * @param  array $request The array from our request.
	 *
	 * @return object          Prepared post object
	 */
	public function get_sections( $request ) {
		$terms = $this->sections_query();
		$response = array();
		foreach( $terms as $term ) {
			$response[] = $this->prepare_section( $term, $request );
		}
		
		return $response;
	}
	
	/**
	 * Callback for creating a new section
	 *
	 * @param  array $request The array from our request.
	 *
	 * @return object          Newly created post object
	 */
	public function create_section( $request ) {
		$prepared_term = $this->extract_section( $request );
		
		$term = wp_insert_term( $prepared_term->name, $this->taxonomy, $prepared_term );
		$order = $this->update_term_order( $request, $term['term_id'] );
		$term = get_term( $term['term_id'], $this->taxonomy );
		
		$response = $this->prepare_section( $term, $request );
		$response = rest_ensure_response( $response );
		return $response;
	}
	
	/**
	 * Get an individual section, which includes a list of attached styles.
	 *
	 * @param  array $request  The array from our request.
	 *
	 * @return object          Full term object with styles
	 */
	public function get_section( $request ) {
		$id = (int) $request['id'];
		if ( empty( $id ) ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'No Term ID provided.' ), array( 'status' => 400 ) );
		}
		
		$term = get_term( $id, $this->taxonomy );
		$response = $this->prepare_section( $term, $request );
		
		$args = array( 
			'tax_query' => array(
				'taxonomy'	=> $this->taxonomy,
				'field'			=> 'term_id',
				'terms'			=> $id
			)
		);
		$styles_query = Styleguide_API_Styles::styles_query( $args );
		$styles = array();
		foreach( $styles_query as $style ) {
			$style = Styleguide_API_Styles::prepare_style( $style );
			$styles[] = $style;
		}
		$response['styles'] = $styles;
		
		$response = rest_ensure_response( $response );
		return $response;
	}
	
	/**
	 * Update an existing style
	 *
	 * Requires an ID to be passed or else we can't update
	 *
	 * @param  array $request The request array.
	 *
	 * @return request          Full updated post object
	 */
	public function update_section( $request ) {
		$id = (int) $request['id'];
		
		if ( empty( $id ) ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Term id is invalid.' ), array( 'status' => 400 ) );
		}
		
		$term = $this->extract_section( $request, $id );
		
		if( isset( $term->name ) ) {
			$term = wp_update_term( $id, $this->taxonomy, (array) $term );
			if ( is_wp_error( $term ) ) {
				if ( in_array( $term->get_error_code(), array( 'db_update_error' ) ) ) {
					$term->add_data( array( 'status' => 500 ) );
				} else {
					$term->add_data( array( 'status' => 400 ) );
				}
				return $term;
			}
			$term_id = $term['term_id'];
		} else {
			$term_id = $id;
		}
		
		$update_order = $this->update_term_order( $request, $id );
		
		$term = get_term( $term_id, $this->taxonomy );
		$response = $this->prepare_section( $term, $request );
		$response = rest_ensure_response( $term );
		return $term;
	}
	
	/**
	 * Delete existing section AND all associated posts
	 *
	 * Requires an ID. Trashed permanently.
	 * 
	 * @param  array $request  The request array.
	 *
	 * @return object          The full object of the deleted post
	 */
	public function delete_section( $request ) {
		$id = absint($request['id']);
		if ( empty( $id ) ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Invalid Term ID.' ), array( 'status' => 404 ) );
		}
		
		$args = array( 
			'tax_query' => array(
				array(
					'taxonomy'	=> $this->taxonomy,
					'field'			=> 'term_id',
					'terms'			=> array( $id )
				)

			)
		);
		$styles = Styleguide_API_Styles::styles_query( $args );
	
		foreach( $styles as $style ) {
			$result = wp_delete_post( $style->ID, true );
		}
		
		$term = get_term( $id, $this->taxonomy );
		$response = $this->prepare_section( $term, $request );
		$result = wp_delete_term( $id, $this->taxonomy );
		if ( ! $result ) {
			return new WP_Error( 'rest_cannot_delete', __( 'The section cannot be deleted.' ), array( 'status' => 500 ) );
		}
		return $response;
	}
	
	/**
	 * Helper to perpare a style for being returned via JSON
	 *
	 * @param  object $post    Post object.
	 * @param  array $request request array
	 *
	 * @return array          Full array to be returned.
	 */
	public function prepare_section( $term, $request ) {
		$data = array();
		$data['id'] = (int) $term->term_id;
		$data['title'] = $term->name;
		$data['slug'] = $term->slug;
		
		return $data;
	}
	
	/**
	 * Pull out items from a request and apply them to section.
	 *
	 * Useful for sorting through a request for updating or creating posts.
	 *
	 * @param  array $request The full request.
	 * @param  int $id      Optional post ID for existing posts.
	 *
	 * @return object          Prepared object for use with wp_update_post or wp_insert_post
	 */
	public function extract_section( $request ) {
		$prepared_section = new stdClass;

		if( isset( $request['title'] ) && is_string( $request['title'] ) ) {
			$prepared_section->name = wp_filter_post_kses( $request['title'] );
			$slug = sanitize_title( $request['title'] );
			$slug = strtolower( $slug );
			$prepared_section->slug = $slug;
		}
		
		return $prepared_section;
	}
	
	public function update_term_order( $request, $id ) {
		if( !$request['order'] ) {
			return;
		}
		
		$current_order = get_term_meta( $id, 'order', true );
		if( $request['order'] && $request['order'] === $current_order ) {
			return;
		}
		
		if( $request['order'] ) {
			$order = absint( $request['order'] );
		} else {
			$terms = get_terms( $this->taxonomy );
			$order = count( $terms ) + 1;
		}
		$term = update_term_meta( $id, 'order', $order );
		return $term;
	}
	
	/**
	 * Basic query for styles
	 *
	 * @param  array  $options optional parameters.
	 *
	 * @return object          Query result.
	 */
	public function sections_query( $options = array() ) {
		$defaults = array(
			'hide_empty' 			=> 0,
			'posts_per_page' 	=> -1,
			'meta_key'				=> 'order',
			'orderby'					=> 'meta_value_num',
			'order'						=> 'ASC'
		);
		
		$args = wp_parse_args( $options, $defaults );

		$query_result = get_terms( $this->taxonomy, $args );
		
		return $query_result;
	}
}

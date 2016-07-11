<?php
/**
 * 
 */
class Styleguide_API_Styles extends Styleguide_API {
	
	/**
	 * Register Routes for the styles endpoint
	 *
	 * @return array an array of all rest endpoints
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, 'styles', array(
			array(
				'methods' 								=> WP_REST_Server::READABLE,
				'callback' 								=> array( $this, 'get_styles' ),
				'permission_callback' 		=> array( $this, 'permissions_check' )
			),
			array(
				'methods'									=> WP_REST_Server::CREATABLE,
				'callback'								=> array( $this, 'create_style' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			)
		));
		
		register_rest_route( $this->namespace, '/styles' . '/(?P<id>[\d]+)', array(
			array(
				'methods'									=> WP_REST_Server::EDITABLE,
				'callback'								=> array( $this, 'update_style' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			),
			array(
				'methods'									=> WP_REST_Server::DELETABLE,
				'callback'								=> array( $this, 'delete_style' ),
				'permission_callback'			=> array( $this, 'permissions_check' ),
				'args'										=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
			)
		));
	}
	
	/**
	 * Callback for getting a list of styles
	 *
	 * @param  array $request The array from our request.
	 *
	 * @return object          Prepared post object
	 */
	public function get_styles( $request ) {
		$query_result = $this->styles_query();
		$posts = array();

		foreach( $query_result as $result ) {
			$data = $this->prepare_style( $result, $request );
			$posts[] = $data;
		}

		$total = $styles_query->found_posts;
		
		$response = rest_ensure_response( $posts );
		$response->header( 'X-WP-Total', (int) $total );
		return $response;
	}
	
	/**
	 * Callback for creating a new style
	 * 
	 * Requires a section ID to be passed, since no style can be created
	 * that isn't attached to an exisitng section
	 *
	 * @param  array $request The array from our request
	 *
	 * @return object          Newly created post object
	 */
	public function create_style( $request ) {
		if ( ! empty( $request['id'] ) ) {
			return new WP_Error( 'rest_post_exists', __( 'Cannot create existing style.' ), array( 'status' => 400 ) );
		}
		
		if ( empty( $request['section_id'] ) ) {
			return new WP_Error( 'rest_post_exists', __( 'Cannot create style without attached section.' ), array( 'status' => 400 ) );
		}
		
		
		
		$section_id = absint( $request['section_id'] );
		$post = $this->extract_style( $request );
		$post_id = wp_insert_post( (array) $post, true );
		wp_set_object_terms( $post_id, $section_id, $this->taxonomy);

		if ( is_wp_error( $post_id ) ) {
			if ( in_array( $post_id->get_error_code(), array( 'db_insert_error' ) ) ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}
			return $post_id;
		}

		$post = get_post( $post_id );
		$response = $this->prepare_style( $post, $request );
		$response = rest_ensure_response( $response );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, 'style', $post_id ) ) );
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
	public function update_style( $request ) {
		$id = (int) $request['id'];
		$post = get_post( $id );
		
		if ( empty( $id ) || empty( $post->ID ) ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Post id is invalid.' ), array( 'status' => 400 ) );
		}
		
		$post = $this->extract_style( $request, $id );
		$post_id = wp_update_post( (array) $post, true );
		
		if ( is_wp_error( $post_id ) ) {
			if ( in_array( $post_id->get_error_code(), array( 'db_update_error' ) ) ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}
			return $post_id;
		}
		
		$response = $this->prepare_style( $post, $request );
		return rest_ensure_response( $response );	
	}
	
	/**
	 * Delete existing style
	 *
	 * Requires an ID. Trashed permanently.
	 * 
	 * @param  array $request  The request array.
	 *
	 * @return object          The full object of the deleted post
	 */
	public function delete_style( $request ) {
		$id = (int) $request['id'];

		$post = get_post( $id );
		if ( empty( $id ) || empty( $post->ID ) || $this->post_type !== $post->post_type ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Invalid post id.' ), array( 'status' => 404 ) );
		}

		$response = $this->prepare_style( $post, $request );
		$result = wp_delete_post( $id, true );
		if ( ! $result ) {
			return new WP_Error( 'rest_cannot_delete', __( 'The post cannot be deleted.' ), array( 'status' => 500 ) );
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
	public function prepare_style( $post, $request ) {
		setup_postdata( $post );

		$data = array( 
			'id' => $post->ID,
			'slug' => $post->post_name,
			'date' => $post->date,
			'title' => get_the_title( $post->ID ),
			'html' => $post->post_content,
			'description' => apply_filters( 'the_content', $post->post_content ),
		);

		$sections = get_the_terms( $post, 'style_sections' );
		$section_name = $sections ? wp_list_pluck( $sections, 'name' ) : array();
		$section_slug = $sections ? wp_list_pluck( $sections, 'slug' ) : array();
		$data['section_name'] = $section_name[0];
		$data['section_slug'] = $section_slug[0];

		return $data;
	}
	
	/**
	 * Pull out items from a request and apply them to post.
	 *
	 * Useful for sorting through a request for updating or creating posts.
	 *
	 * @param  array $request The full request.
	 * @param  int $id      Optional post ID for existing posts.
	 *
	 * @return object          Prepared object for use with wp_update_post or wp_insert_post
	 */
	public function extract_style( $request, $id = null ) {
		$prepared_post = new stdClass;
		
		if( isset( $post['id'] ) ) {
			$prepared_post->ID = absint( $request['id'] );
		}
		
		if( isset( $id ) ) {
			$prepared_post->ID = absint( $id );
		}

		if( isset( $request['title'] ) && is_string( $request['title'] ) ) {
			$prepared_post->post_title = wp_filter_post_kses( $request['title'] );
		}

		if( isset( $request['html'] ) && is_string( $request['html'] ) ) {
			$prepared_post->post_content = wp_filter_post_kses( $request['html'] );
		}

		if ( isset( $request['slug'] ) ) {
			$prepared_post->post_name = $request['slug'];
		}
		
		$prepared_post->post_type 	= $this->post_type;
		$prepared_post->post_status = 'publish';

		return $prepared_post;
	}
	
	/**
	 * Basic query for styles
	 *
	 * @param  array  $options optional parameters.
	 *
	 * @return object          Query result.
	 */
	public function styles_query( $options = array() ) {
		$defaults = array(
			'post_type' => $this->post_type,
			'posts_per_page' => -1,
			'order'	=> 'ASC'
		);
		
		$args = wp_parse_args( $options, $defaults );
		
		$query = new WP_Query();
		$query_result = $query->query( $args );
		
		return $query_result;
	}
}

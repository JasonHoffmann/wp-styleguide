<?php

class Styleguide_Endpoints {

	protected $post_type;

	public function __construct() {
		$this->post_type = 'styles';
		$this->namespace = 'styleguide';
	}

	public function register_routes() {
		register_rest_route( $this->namespace, '/style', array(
			array(
				'methods' 				=> WP_REST_Server::READABLE,
				'callback' 				=> array( $this, 'get_items' ),
				'permission_callback' 	=> array( $this, 'general_permissions_check' )
			),
			array( 
				'methods' 				=> WP_REST_Server::CREATABLE,
				'callback' 				=> array( $this, 'create_item' ),
				'permission_callback' 	=> array( $this, 'general_permissions_check' )
			)
		));

		register_rest_route( $this->namespace, '/style' . '/(?P<id>[\d]+)', array(
			array(
				'methods' 				=> WP_REST_Server::EDITABLE,
				'callback' 				=> array( $this, 'update_item' ),
				'permission_callback' 	=> array( $this, 'general_permissions_check' )
			),
			array( 
				'methods' 				=> WP_REST_Server::DELETABLE,
				'callback' 				=> array( $this, 'delete_item' ),
				'permission_callback' 	=> array( $this, 'general_permissions_check' )
			)
		));
		
		register_rest_route( $this->namespace, '/section', array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_sections' )
			),
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array( $this, 'create_section'),
				'permission_callback' => array( $this, 'general_permissions_check' )
			)
		));
		
		register_rest_route( $this->namespace, '/section/(?P<id>[\d]+)', array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_section_posts' )
			),
			array(
				'methods'				=> WP_REST_Server::EDITABLE,
				'callback' 			=> array( $this, 'update_section'),
				'permission_callback' => array( $this, 'general_permissions_check')
			)
		));
	}
	
	public function get_sections( $request ) {
		$terms = get_terms( 'style_sections', array( 'hide_empty' => 0, 'meta_key' => 'order', 'orderby' => 'meta_value_num', 'order' => 'ASC' ) );
		$response = array();
		foreach( $terms as $term ) {
			$data = array();
			$data['id'] = (int) $term->term_id;
			$data['name'] = $term->name;
			$data['slug'] = $term->slug;
			// $data = rest_ensure_response( $data );
			$response[] = $data;
		}
		
		return $response;
		
		
	}
	
	public function get_section_posts( $request ) {
		$term = get_term( intval( $request['id'] ), 'style_sections' );
		$response = array();
		$response['id'] = (int) $term->term_id;
		$response['name'] = $term->name;
		$response['slug'] = $term->slug;
			// $data = rest_ensure_response( $data );
		
		$id = intval( $request['id'] );
		wp_reset_postdata();
		$query_args = array(
			'post_type' => $this->post_type,
			'order' => 'ASC',
			'tax_query' => array(
					array(
							'taxonomy' => 'style_sections', 
							'field' => 'term_id', 
							'terms' => $id 
			) ) 
		);
			
		$styles_query = new WP_Query();
		$query_result = $styles_query->query( $query_args );
			
		$posts = array();

		foreach( $query_result as $result ) {
				
				$data = $this->prepare_item_for_response( $result, $request );
				$posts[] = $data;
			}
			
			$response['posts'] = $posts;

		
		return $response;
		
	}
	
	public function general_permissions_check( $request ) {
		// TODO : SET UP PROPER PERMISSIONS CHECK
		// if ( !current_user_can( $post_type->cap->edit_posts ) ) {
		// 	return false;
		// }

		return true;
	}

	public function get_items( $request ) {
		$styles_query = new WP_Query();

		$query_result = $styles_query->query( array( 'post_type' => $this->post_type, 'posts_per_page' => -1 ) );

		$posts = array();

		foreach( $query_result as $result ) {
			$data = $this->prepare_item_for_response( $result, $request );
			$posts[] = $data;
		}

		$total = $styles_query->found_posts;

		$response = rest_ensure_response( $posts );
		$response->header( 'X-WP-Total', (int) $total );

		return $response;
	}

	public function prepare_item_for_response( $post, $request ) {
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

		// $response = rest_ensure_response( $data );

		return $data;
	}

	public function create_item( $request ) {
		if ( ! empty( $request['id'] ) ) {
			return new WP_Error( 'rest_post_exists', __( 'Cannot create existing post.' ), array( 'status' => 400 ) );
		}
		$section_id = isset( $request['section_id'] ) ? intval( $request['section_id'] ) : '';

		$post = $this->prepare_item_for_database( $request );

		$post->post_type = $this->post_type;
		$post->post_status = 'publish';
		$post_id = wp_insert_post( $post, true );
		wp_set_object_terms( $post_id, $section_id, 'style_sections');

		if ( is_wp_error( $post_id ) ) {
			if ( in_array( $post_id->get_error_code(), array( 'db_insert_error' ) ) ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}
			return $post_id;
		}

		$post = get_post( $post_id );
		$response = $this->prepare_item_for_response( $post, $request );
		$response = rest_ensure_response( $response );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, 'style', $post_id ) ) );
		return $response;
	}
	
	public function create_section( $request ) {
		$section_title = isset( $request['title'] ) ? esc_html( $request['title'] ) : 'New Title';
		$order = isset( $request['order'] ) ? absint( $request['order'] ) : false;
		$slug = sanitize_title( $section_title );
		$slug = strtolower( $slug );
		
		if( !$order ) {
			$terms = get_terms('style_sections');
			$order = count( $terms ) + 1;
		}
		
		$id = wp_insert_term( $section_title, 'style_sections', array( 'slug' => $slug ) );
		update_term_meta( $id['term_id'], 'order', $order );
		$response = array(
			'id' => $id,
			'slug' => $slug
		);
		$response = rest_ensure_response( $response );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, 'style', $id ) ) );
		return $response;
	}

	public function update_item( $request ) {
		$id = (int) $request['id'];
		$post = get_post( $id );
		$title = isset( $request['title'] ) ? $request['title'] : null;
		$html = isset( $request['html'] ) ? $request['html'] : null;

		if ( empty( $id ) || empty( $post->ID ) ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Post id is invalid.' ), array( 'status' => 400 ) );
		}

		$post = $this->prepare_item_for_database( array( 
							'id' => $id,
							'title' => $title,
							'html' => $html
 		) );

		$post_id = wp_update_post( (array) $post, true );
		
		if ( is_wp_error( $post_id ) ) {
			if ( in_array( $post_id->get_error_code(), array( 'db_update_error' ) ) ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}
			return $post_id;
		}

		$response = $this->prepare_item_for_response( $post, $request );
		return rest_ensure_response( $response );
	}
	
	public function update_section( $request ) {
		$id = (int) $request['id'];
		$title = isset( $request['title'] ) ? $request['title'] : null;
		if( !$title ) {
			return new WP_Error( 'rest_cannot_update', __( 'The section cannot be updated.' ), array( 'status' => 500 ) );
		}
		$slug = sanitize_title_with_dashes( $title );
		$term = wp_update_term( $id, 'style_sections', array( 'name' => $title, 'slug' => $slug ) );
		
		if ( is_wp_error( $term ) ) {
			if ( in_array( $term->get_error_code(), array( 'db_update_error' ) ) ) {
				$term->add_data( array( 'status' => 500 ) );
			} else {
				$term->add_data( array( 'status' => 400 ) );
			}
			return $term;
		}
		
		return rest_ensure_response( $term );
	}

	public function delete_item( $request ) {
		$id = (int) $request['id'];

		$post = get_post( $id );
		if ( empty( $id ) || empty( $post->ID ) || $this->post_type !== $post->post_type ) {
			return new WP_Error( 'rest_post_invalid_id', __( 'Invalid post id.' ), array( 'status' => 404 ) );
		}

		$response = $this->prepare_item_for_response( $post, $request );
		$result = wp_delete_post( $id, true );
		
		if ( ! $result ) {
			return new WP_Error( 'rest_cannot_delete', __( 'The post cannot be deleted.' ), array( 'status' => 500 ) );
		}

		return $response;
	}

	public function prepare_item_for_database( $post ) {
		$prepared_post = new stdClass;
		
		if( isset( $post['id'] ) ) {
			$prepared_post->ID = absint( $post['id'] );
		}

		if( isset( $post['title'] ) && is_string( $post['title'] ) ) {
			$prepared_post->post_title = wp_filter_post_kses( $post['title'] );
		}

		if( isset( $post['html'] ) && is_string( $post['html'] ) ) {
			$prepared_post->post_content = wp_filter_post_kses( $post['html'] );
		}


		$prepared_post->post_type = $this->post_type;

		if ( ! empty( $post['date'] ) ) {
			$date_data = rest_get_date_with_gmt( $post['date'] );
			if ( ! empty( $date_data ) ) {
				list( $prepared_post->post_date, $prepared_post->post_date_gmt ) = $date_data;
			}
		}

		if ( isset( $post['slug'] ) ) {
			$prepared_post->post_name = $post['slug'];
		}

		return $prepared_post;
	}

	public function handle_sections( $post_id, $request ) {
		if( isset( $request['section'] ) ) {
			$result = wp_set_object_terms( $post_id, $request['section'], 'styles_section' );
			if( is_wp_error( $result ) ) {
				return $result;
			}
		}
	}

}
<?php
/**
 * 
 */
class Styleguide_API_Data extends Styleguide_API {
	
	/**
	 * Register routes for big data endpoint
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, 'data', array(
			array(
					'methods'							=> WP_REST_Server::READABLE,
					'callback'						=> array( $this, 'get_data' ),
					'permission_callback' => array( $this, 'permissions_check' )
			)
		));
	}
	
	/**
	 * Get all data
	 *
	 * @return object JSON response with all data
	 */
	public function get_data( $request ) {
		$response = array();
		
		$section_class = new Styleguide_API_Sections;
		
		
		$sections = $section_class->sections_query();
		$section_array = array();

		foreach( $sections as $i => $section ) {
			$section_array[] = $section_class->prepare_section( $section, $request );
			
			$args = array( 
				'tax_query' => array(
					array( 
						'taxonomy'	=> $this->taxonomy,
						'field'			=> 'term_id',
						'terms'			=> $section->term_id
					)
				)
			);
			
			$style_class = new Styleguide_API_Styles;
			$styles_query = $style_class->styles_query( $args );
			if( $styles_query ) {
				$styles = array();
				foreach( $styles_query as $style ) {
					$style = $style_class->prepare_style( $style, $section );
					$styles[] = $style;
				}
				$section_array[$i]['styles'] = $styles;
			} else {
				$section_array[$i]['styles'] = [];
			}

		}
		$response['sections'] = $section_array;
		
		$settings_class = new Styleguide_API_Settings;
		$settings = $settings_class->get_settings();
		$response['settings'] = $settings->data;
		return $response;
	}
}
<?php
/**
* Loader Class for back-end and front-end
* 
* Loads up the proper templates and endpoints needed
* for the front-end to work properly
*
* @since 0.0.1
*/

class Styleguide_Loader {

	static $instance = false;
	
	/**
	 * Initialize Class with a new instance
	 * 
	 * @since 0.0.1
	 * 
	 * @global boolean $instance
	 * 
	 */
	public static function init() {
		if ( ! self::$instance ) {
			self::$instance = new Styleguide_Loader;
		}
		return self::$instance;
	}

	/**
	 * Class Constructer for Styleguide Loader.
	 * 
	 * Sets up everything for the class, loads modules.
	 * Uses WordPress hooks to add styles / scripts and rewrite rules.
	 * 
	 * @since 0.0.1
	 * 
	 */
	private function __construct() {
		add_action('plugins_loaded', array( $this, 'load_styleguide_template') );
		add_action('rest_api_init', array( $this, 'load_rest_endpoints' ) );

		Styleguide_Data::init();
	}

	public function load_styleguide_template() {
		Styleguide_Front::init();
	}

	public function load_rest_endpoints() {
		$api = new Styleguide_Endpoints;
		$api->register_routes();
	}


}
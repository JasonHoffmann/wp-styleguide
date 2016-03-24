<?php
/**
 * Loader Class for front-end template and scripts
 *
 * Adds a simple front-end template which lets the client side take
 * take care of everything and enqueues the scripts needed
 * to get this thing to kick-off.
 *
 * @since 0.0.1
 */

class Styleguide_Front {

	static $instance = false;

	/**
	 * Initialize the class with a new instance
	 *
	 * @return bool|Styleguide_Front
	 */
	public static function init() {
		if ( ! self::$instance ) {
			self::$instance = new Styleguide_Front;
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
		add_filter('template_include', array($this, 'load_template'));
		add_action( 'wp_enqueue_scripts', array( $this, 'load_all_scripts' ) );
	}


	/**
	 * Add a blank template which basically just holds
	 * a root element for our client-side templates and Vue code
	 * 
	 * @since 0.0.1
	 * 
	 */
	public function load_template() {
    	return STYLEGUIDE__PLUGIN_DIR . 'front/template.php';
	}

	public function load_all_scripts() {
		// TODO: Add in the proper scripts here, basically everything depends on this.
	}


}
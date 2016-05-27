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
		add_action( 'wp-routes/register_routes', array($this, 'load_template' ) );
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
		respond('/styleguide', function() {
			require_once( STYLEGUIDE__PLUGIN_DIR . 'front/template.php' );
			die();
		});
	}

	public function load_all_scripts() {
		// TODO: Add in the proper scripts here, basically everything depends on this.
		
		wp_enqueue_script('app', STYLEGUIDE__PLUGIN_URL . 'front/app/build/app.js', array(), '1.0.0', true);
		// Localize the script with new data
		$site_options = array(
			'url' => site_url(),
		);
		wp_localize_script( 'app', 'styleguide_options', $site_options );
		// Enqueued script with localized data.
		wp_enqueue_script( 'styleguide_options' );
		wp_enqueue_style( 'app', STYLEGUIDE__PLUGIN_URL . 'front/style.css' );
	}


}
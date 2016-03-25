<?php

/**
 * Data class
 *
 * Sets up post type and any other data types needed by the API
 *
 * @since 0.0.1
 */

class Styleguide_Data {

	static $instance = false;

	/**
	 * Initialize the class with a new instance
	 *
	 * @return bool|Styleguide_Data
	 */
	public static function init() {
		if ( ! self::$instance ) {
			self::$instance = new Styleguide_Data;
		}
		return self::$instance;
	}

	/**
	 * Styleguide_Data constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_styles_posttype' ) );
	}

	/**
	 * Register styles post type
	 * - Used as the main data type for style components
	 */
	public function add_styles_posttype() {
		register_post_type( 'styles', array(
			'label' => 'STYLE',
			// TODO: Set public to false and remove label
			// This is only here to add data on the back-end while we're testing
			'public' => true,
			'supports' => array( 'title', 'editor', 'date' )
		));
	}

}
<?php
/**
* Class for plugin initialization and deactivation
*
* @since 0.0.1
*/

class Styleguide_Activate {
	static $instance = false;

	/**
	 * Initialize Styleguide_Activate Class with a new instance
	 * 
	 * @since 0.0.1
	 * 
	 * @global boolean $instance
	 * 
	 */
	static function init() {
		if ( ! self::$instance ) {
			self::$instance = new Styleguide_Activate;
		}

		return self::$instance;
	}

	/**
	 * Plugin Activation hook.
	 * 
	 * Sets up the /me route and flushes rewrite rules
	 * 
	 * @since 0.1.0
	 * 
	 */
	public static function plugin_activation() {
		update_option( 'sg_styleguide_settings', array(
			'private' => true,
			'endpoint' => 'styleguide',
			'onboarded' => false
		), false );
		flush_rewrite_rules();
	}

	/**
	 * Plugin Deactivation hook.
	 * 
	 * Let's make sure to flush rewrite rules when the plugin is deactivated
	 * 
	 * @since 0.1.0
	 * 
	 */
	public static function plugin_deactivation() {
		flush_rewrite_rules();
	}
}
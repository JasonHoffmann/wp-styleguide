<?php
/*
 * Plugin Name: WP Styleguide
 * Plugin URI: 
 * Description: Create a componenet based styleguide / pattern library
 * Author: 
 * Version: 0.0.1
 * Author URI: 
 * License: GPL2+
 * Text Domain: me
 * Domain Path: /languages/
 */
define( 'STYLEGUIDE__VERSION',            '0.0.1' );
define( 'STYLEGUIDE__PLUGIN_DIR',         plugin_dir_path( __FILE__ ) );
define( 'STYLEGUIDE__PLUGIN_URL',         plugin_dir_url( __FILE__ ) );
define( 'STYLEGUIDE__PLUGIN_BASE',         plugin_basename( __FILE__ ) );
define( 'STYLEGUIDE__PLUGIN_FILE',        __FILE__ );

require_once( STYLEGUIDE__PLUGIN_DIR . 'lib/wp-routes/wp-routes.php' );
require_once( STYLEGUIDE__PLUGIN_DIR . 'back/class.styleguide.front.php' );
require_once( STYLEGUIDE__PLUGIN_DIR . 'back/class.styleguide.data.php' );
require_once( STYLEGUIDE__PLUGIN_DIR . 'back/class.styleguide.api.php' );
require_once( STYLEGUIDE__PLUGIN_DIR . 'back/class.styleguide.loader.php' );
require_once( STYLEGUIDE__PLUGIN_DIR . 'back/class.styleguide.activate.php' );

/**
 * Begins execution of the plugin.
 *
 * Going to initialize the plugin and kick off execution
 *
 * @since    0.1.0
 */
register_activation_hook( __FILE__, array( 'Styleguide_Activate', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Styleguide_Activate', 'plugin_deactivation' ) );

Styleguide_Loader::init();
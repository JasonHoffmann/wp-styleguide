<?php

class Styleguide_API_Settings extends Styleguide_API {
  protected $settings = 'sg_styleguide_settings';
  
  public function register_routes() {
    register_rest_route( $this->namespace, 'settings', array(
      array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => array( $this, 'get_settings' ),
        'permission_callback' => array( $this, 'permissions_check' )
      ),
      array(
        'methods'             => WP_REST_Server::EDITABLE,
        'callback'            => array( $this, 'update_settings' ),
        'permission_callback' => array( $this, 'permissions_check' ),
				'args'								=> array( 'context' => 
																								array( 'default' => 'edit') 
																			)
      )
    ));
  }
  
  public function get_settings() {
    $settings = get_option( $this->settings );
    if( $settings ) {
      $settings = rest_ensure_response( $settings );
      return $settings;
    }
    return false;
  }
  
  public function update_settings( $request ) {
    $original_settings = get_option( $this->settings );
    $settings = $this->prepare_settings_for_database( $original_settings, $request );
    update_option( $this->settings, $settings, false );
    if( $original_settings['endpoint'] !== $settings['endpoint'] ) {
      $settings['redirect'] = true;
    }
    
    return $settings;
  }
  
  public function prepare_settings_for_database( $settings, $request ) {
    if( isset( $request['private'] ) 
        && is_bool( $request['private'] ) 
        && $request['private'] !== $settings['private']
    ) {
      $settings['private'] = $request['private'];
    }
    
    if( isset( $request['endpoint'] ) 
        && is_string( $request['endpoint'] )
        && $request['endpoint'] !== $settings['endpoint']
    ) {
      $settings['endpoint'] = $request['endpoint'];
    }
    
    if( isset( $request['onboarded'] ) 
        && is_bool( $request['onboarded'] )
        && $request['onboarded'] !== $settings['onboarded']
    ) {
      $settings['onboarded'] = $request['onboarded'];
    }
    
    return $settings;
  }
}
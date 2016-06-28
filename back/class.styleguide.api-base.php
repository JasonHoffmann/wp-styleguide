<?php

class Styleguide_API {
		protected $post_type = 'styles';
		protected $taxonomy = 'style_sections';
		
		protected $namespace = 'styleguide';
		
		public function permissions_check( $request ) {
			return true;
			$post_type = get_post_type_object( $this->post_type );
			if ( 'edit' === $request['context'] && ! current_user_can( $post_type->cap->edit_posts ) ) {
				return new WP_Error( 'rest_forbidden_context', __( 'Sorry, you are not allowed to edit styles' ), array( 'status' => rest_authorization_required_code() ) );
			}
			return true;
		}
}
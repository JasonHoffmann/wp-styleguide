<?php

class Styleguide_API {
		protected $post_type = 'styles';
		protected $taxonomy = 'style_sections';
		
		protected $namespace = 'styleguide';
		
		public function permissions_check( $request ) {
			// TODO : SET UP PROPER PERMISSIONS CHECK
			// if ( !current_user_can( $post_type->cap->edit_posts ) ) {
			// 	return false;
			// }

			return true;
		}
}
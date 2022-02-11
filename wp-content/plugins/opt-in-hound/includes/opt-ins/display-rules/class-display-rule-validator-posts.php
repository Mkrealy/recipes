<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Display_Rule_Validator_Posts extends OIH_Display_Rule_Validator_Abstract implements OIH_Display_Rule_Validator_Interface {

	public function is_displayable() {

		// If not enabled, do not display
		if( empty( $this->_args ) || empty( $this->_args['enabled'] ) )
			return false;

		// If this is not a single post, do not display
		if( ! is_singular( 'post' ) )
			return false;

		global $post;

		// Type of inclusion / exclusion
		$explicit_type  = ( ! empty( $this->_args['explicit_type'] ) ? $this->_args['explicit_type'] : 'exclude' );

		// Grab post ids declared explicit
		$explicit_posts = ( ! empty( $this->_args['explicit'] ) && ( is_string( $this->_args['explicit'] ) || is_int( $this->_args['explicit'] ) ) ? array_map( 'trim', explode( ',', $this->_args['explicit'] ) ) : array() );
	
		// If the post is on the explicit black list, do not display
		if( $explicit_type == 'exclude' ) {

			if( in_array( $post->ID , $explicit_posts ) )
				return false;

		}

		// If the post is on the explicit white list, display only it
		if( $explicit_type == 'include' ) {

			if( ! in_array( $post->ID , $explicit_posts ) )
				return false;

		}
		
		return true;

	}

}
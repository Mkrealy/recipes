<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Display_Rule_Validator_Factory {

	public static function build( $rule_slug = '', $args = array() ) {

		$class_name = 'OIH_Display_Rule_Validator_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $rule_slug ) ) );

		if( class_exists( $class_name ) )
			return new $class_name($args);
		else
			return null;

	}

}
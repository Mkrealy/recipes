<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Returns the needed opt-in outputter
 *
 */
Class OIH_Opt_In_Outputter_Factory {

	public static function build( OIH_Opt_In $opt_in ) {

		$opt_in_type = $opt_in->get('type');
		$class_name  = 'OIH_Opt_In_Outputter_Type_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $opt_in_type ) ) );

		if( class_exists( $class_name ) )
			return new $class_name( $opt_in );
		else
			return new OIH_Opt_In_Outputter_Base( $opt_in );

	}

}
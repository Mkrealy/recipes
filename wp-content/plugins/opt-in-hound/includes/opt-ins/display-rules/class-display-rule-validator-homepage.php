<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Display_Rule_Validator_Homepage extends OIH_Display_Rule_Validator_Abstract implements OIH_Display_Rule_Validator_Interface {

	public function is_displayable() {

		// If not enabled, do not display
		if( empty( $this->_args ) || empty( $this->_args['enabled'] ) )
			return false;

		// Check if is homepage
		if( ! is_front_page() )
			return false;

		return true;

	}

}
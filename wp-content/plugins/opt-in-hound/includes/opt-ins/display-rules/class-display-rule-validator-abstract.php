<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

abstract Class OIH_Display_Rule_Validator_Abstract {

	/**
	 * Array of arguments to build the rule from
	 *
	 * @var array
	 * @access protected
	 *
	 */
	protected $_args;

	/**
	 * Constructor
	 *
	 */
	public function __construct( $args = array() ) {

		$this->_args = $args;

	}


	/**
	 * Determines if the rule should validate in an "any" valid rules situation
	 * or an "all" valid rules situation
	 *
	 */
	public function is_strict() {

		return false;

	}

}
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


Class OIH_Opt_In {

	protected $id;

	protected $type;

	protected $name;

	protected $test_mode;

	protected $options;

	protected $active;


	/**
	 * Constructor
	 *
	 * @param array $data
	 *
	 */
	public function __construct( $data = array() ) {

		foreach( get_object_vars( $this ) as $key => $value ) {
			if( isset( $data[$key] ) )
				$this->set( $key, $data[$key] );
		}

	}


	/**
	 * Getter
	 *
	 * @param string $property
	 *
	 */
	public function get( $property = '' ) {

		if( method_exists( $this, 'get_' . $property ) )
			return $this->{'get_' . $property}();
		else
			return $this->$property;

	}


	/**
	 * Setter
	 *
	 * @param string $property
	 * @param mixed $value
	 *
	 */
	public function set( $property = '', $value = '' ) {

		if( method_exists( $this, 'set_' . $property ) )
			$this->$property = $this->{'set_' . $property}( $value );
		else
			$this->$property = $value;

	}


	/**
	 * Returns the object attributes and their values as an array 
	 *
	 */
	public function to_array() {

		return get_object_vars( $this );

	}

}
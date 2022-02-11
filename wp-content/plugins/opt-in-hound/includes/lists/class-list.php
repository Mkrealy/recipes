<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


Class OIH_List {

	/**
	 * The unique id of the list
	 *
	 * @access protected
	 * @var int
	 *
	 */
	protected $id;

	/**
	 * The name of the list, to easily distinguish it
	 *
	 * @access protected
	 * @var string
	 *
	 */
	protected $name;

	/**
	 * The description of the list, to help users remember what the
	 * list was created for
	 *
	 * @access protected
	 * @var string
	 *
	 */
	protected $description;

	/**
	 * The date at which the list was added to the database
	 *
	 * @access protected
	 * @var datetime
	 *
	 */
	protected $date;


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
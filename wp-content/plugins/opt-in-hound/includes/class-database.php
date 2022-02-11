<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The plugins database class
 *
 */
Class OIH_Database {

	/**
	 * WordPress's db object
	 *
	 * @var wpdb
	 * @access private
	 *
	 */
	protected $_wpdb;


	/**
	 * Our own prefix
	 *
	 * @var string
	 * @access private
	 *
	 */
	protected $prefix = 'oih_';


	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		global $wpdb;

		$this->_wpdb = $wpdb;

	}


	/**
	 * Updates the plugin's database tables 
	 *
	 * @return void
	 *
	 */
	public function update_tables() {

		if( ! current_user_can( 'manage_options' ) )
			return;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$schema = $this->get_schema();

		if( ! empty( $schema ) )
			dbDelta( $schema );

	}


	/**
	 * Drops all custom tables created by the plugin
	 *
	 * @return void
	 *
	 */
	public function drop_tables() {

		if( ! current_user_can( 'manage_options' ) )
			return;

		$tables = $this->get_custom_tables();

		foreach( $tables as $table )
			$this->_wpdb->query( "DROP TABLE IF EXISTS {$this->_wpdb->prefix}{$this->prefix}{$table}" );

	}


	/**
	 * Returns the custom database tables schema needed for the plugin
	 *
	 * @return string
	 *
	 */
	protected function get_schema() {

		/**
		 * Filter to dynamically add tables to the db schema
		 *
		 * @param string $prefix
		 * @param string $charset
		 *
		 */
		$schema = apply_filters( 'oih_database_schema', '', $this->_wpdb->prefix . $this->prefix, $this->_wpdb->get_charset_collate() );

		return $schema;

	}


	/**
	 * Returns an array with the custom tables registered by the plugin
	 *
	 * @return array
	 *
	 */
	protected function get_custom_tables() {

		$tables = apply_filters( 'oih_database_custom_tables', array() );

		return $tables;

	}


	/**
	 * Returns the plugins own database prefix
	 *
	 * @return string
	 *
	 */
	public function get_prefix() {

		return $this->prefix;

	}

}
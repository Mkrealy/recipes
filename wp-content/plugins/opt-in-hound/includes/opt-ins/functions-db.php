<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register the custom tables needed for the opt-ins
 *
 * @param array $tables
 *
 * @return array
 *
 */
function oih_register_database_table_opt_ins( $tables = array() ) {

	$tables[] = 'opt_ins';

	return $tables;

}
add_filter( 'oih_database_custom_tables', 'oih_register_database_table_opt_ins' );


/**
 * Add the db schema for the opt-ins to the plugins db schema string
 *
 * @param string $schema
 * @param string $prefix
 * @param string $charset
 *
 * @return string
 *
 */
function oih_add_database_schema_opt_ins( $schema = '', $prefix = '', $charset = '' ) {

	if( empty( $prefix ) || empty( $charset ) )
		return '';

	$schema .= "
		CREATE TABLE {$prefix}opt_ins (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			name text NOT NULL,
			type text NOT NULL,
			options longtext NOT NULL,
			test_mode tinyint(1),
			active tinyint(1),
			UNIQUE KEY id (id)
		) {$charset};
	";

	return $schema;

}
add_filter( 'oih_database_schema', 'oih_add_database_schema_opt_ins', 10, 3 );


/**
 * Returns an array with OIH_Opt_In objects from the db by the given arguments
 *
 * @param array $args
 *
 * @return array
 *
 */
function oih_get_opt_ins( $args = array() ) {

	$defaults = array(
		'order'		  => 'DESC',
		'orderby'     => 'id',
		'number' 	  => 0,
		'offset'	  => 0,
		'type'		  => '',
		'include'	  => array(),
		'test_mode'	  => '',
        'active'      => ''
	);

	$args = array_merge( $defaults, $args );

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'opt_ins';

	// Start query string
	$query_string  = "SELECT * FROM {$table} ";
	$query_string .= "WHERE 1=%d ";

	// Select only by given type
	if( ! empty( $args['type'] ) ) {
		$query_string .= "AND type = '{$args['type']}' ";
	}
	
	// Narrow to only certain id's
	if( ! empty( $args['include'] ) ) {
		$include = implode( ', ', $args['include'] );
		$query_string .= "AND id IN ({$include}) ";
	}
    
    // Select only by active
	if( ! empty( $args['active'] ) ) {
		$query_string .= "AND active = '{$args['active']}' ";
	}

	// Select only by test_mode
	if( ! empty( $args['test_mode'] ) ) {
		$query_string .= "AND test_mode = '{$args['test_mode']}' ";
	}

	// Narrow to only registered opt-in types
	$opt_in_types_slugs = array_keys( oih_get_opt_in_types() );
	
	if( ! empty( $opt_in_types_slugs ) ) {
		$opt_in_types_slugs = "'" . implode( "', '", $opt_in_types_slugs ) . "'";
		$query_string .= "AND type IN ({$opt_in_types_slugs}) ";
	}

	// Order by
	$query_string .= "ORDER BY {$args['orderby']} {$args['order']} ";

	// Limit number of opt-ins returned
	if( ! empty( $args['number'] ) && $args['number'] >= 0 )
		$query_string .= "LIMIT {$args['number']} ";

	// Offset for the returned opt-ins
	if( ! empty( $args['offset'] ) && $args['offset'] >= 0 )
		$query_string .= "OFFSET {$args['offset']} ";


	$results = $wpdb->get_results( $wpdb->prepare( $query_string, 1 ), ARRAY_A );

	if( ! empty( $results ) ) {

		foreach( $results as $key => $result )
			$results[$key] = new OIH_Opt_In( _oih_json_decode_array( $result ) );
	
		return $results;

	} else
		return array();

}


/**
 * Returns OIH_Opt_In object from the db coresponding to the given id
 *
 * @param int $opt_in_id
 *
 * @return mixed 	- OIH_Opt_In if found, null if not found
 *
 */
function oih_get_opt_in( $opt_in_id = 0 ) {

	if( empty( $opt_in_id ) )
		return null;

	global $wpdb;

	$db 	   = new OIH_Database();
	$table     = $wpdb->prefix . $db->get_prefix() . 'opt_ins';
	$opt_in_id = (int)$opt_in_id;

	$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE id = {$opt_in_id}" , ARRAY_A );

	if( $result )
		return new OIH_Opt_In( _oih_json_decode_array( $result ) );
	else
		return null;

}


/**
 * Inserts an opt-in into the db
 *
 * @param array
 *
 * @return int
 *
 */
function oih_insert_opt_in( $data = array() ) {

	if( empty( $data ) )
		return 0;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'opt_ins';

	// If options are sent as array make them json
	if( isset( $data['options'] ) && is_array( $data['options'] ) )
		$data['options'] = json_encode( $data['options'] );

	if( $wpdb->insert( $table, $data ) )
		return $wpdb->insert_id;
	else
		return 0;

}


/**
 * Updates data for an opt-in
 *
 * @param int $opt_in_id
 * @param array $data
 *
 * @return bool
 *
 */
function oih_update_opt_in( $opt_in_id = 0, $data = array() ) {

	if( empty( $opt_in_id ) || empty( $data ) )
		return false;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'opt_ins';

	// If options are sent as array make them json
	if( isset( $data['options'] ) && is_array( $data['options'] ) )
		$data['options'] = json_encode( $data['options'] );

	$updated = $wpdb->update( $table, $data, array( 'id' => (int)$opt_in_id ) );

	if( false === $updated )
		return false;
	else
		return true;

}


/**
 * Removes an opt-in from the dabatase
 *
 * @param int $opt_in_id
 *
 * @return bool
 *
 */
function oih_delete_opt_in( $opt_in_id = 0 ) {

	if( empty( $opt_in_id ) )
		return false;

	global $wpdb;
	
	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'opt_ins';

	$deleted = $wpdb->delete( $table, array( 'id' => (int)$opt_in_id ) );

	if( false === $deleted )
		return false;
	else
		return true;

}
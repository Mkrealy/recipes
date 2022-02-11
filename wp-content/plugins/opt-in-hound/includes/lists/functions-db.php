<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register the custom tables needed for the lists
 *
 * @param array $tables
 *
 * @return array
 *
 */
function oih_register_database_table_lists( $tables = array() ) {

	$tables[] = 'lists';

	return $tables;

}
add_filter( 'oih_database_custom_tables', 'oih_register_database_table_lists' );


/**
 * Add the db schema for the lists to the plugins db schema string
 *
 * @param string $schema
 * @param string $prefix
 * @param string $charset
 *
 * @return string
 *
 */
function oih_add_database_schema_lists( $schema = '', $prefix = '', $charset = '' ) {

	if( empty( $prefix ) || empty( $charset ) )
		return '';

	$schema .= "
		CREATE TABLE {$prefix}lists (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			name text NOT NULL,
			description longtext NOT NULL,
			date datetime NOT NULL,
			UNIQUE KEY id (id)
		) {$charset};
	";

	return $schema;

}
add_filter( 'oih_database_schema', 'oih_add_database_schema_lists', 10, 3 );


/**
 * Returns an array with OIH_List objects from the db by the given arguments
 *
 * @param array $args
 *
 * @return array
 *
 */
function oih_get_lists( $args = array() ) {

	$defaults = array(
		'order'		  => 'DESC',
		'orderby'     => 'id',
		'number' 	  => 0,
		'offset'	  => 0,
		'include'	  => array(),
		'search'	  => ''
	);

	$args = array_merge( $defaults, $args );

	global $wpdb;
	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'lists';

	// Start query string
	$query_string  = "SELECT * FROM {$table} ";
	$query_string .= "WHERE 1=%d ";

	// Add search query
    if( ! empty( $args['search'] ) ) {
        $search_term   = sanitize_text_field( $args['search'] );
        $query_string .= " AND " . " ( name LIKE '%%%s%%' OR description LIKE '%%%s%%' ) " . " ";
    }
	
	// Narrow to only certain id's
	if( !empty( $args['include'] ) ) {
		$include = implode( ', ', $args['include'] );
		$query_string .= "AND id IN ({$include}) ";
	}
    
	// Order by
	$query_string .= "ORDER BY {$args['orderby']} {$args['order']} ";

	// Limit number of subscribers returned
	if( !empty( $args['number'] ) && $args['number'] >= 0 )
		$query_string .= "LIMIT {$args['number']} ";

	// Offset
	if( !empty( $args['offset'] ) && $args['offset'] >= 0 )
		$query_string .= "OFFSET {$args['offset']} ";

	// Return results
    if ( ! empty( $search_term ) )
        $results = $wpdb->get_results( $wpdb->prepare( $query_string, 1, $wpdb->esc_like( $search_term ), $wpdb->esc_like( $search_term ) ), ARRAY_A );
    else
        $results = $wpdb->get_results( $wpdb->prepare( $query_string, 1 ), ARRAY_A );


	if( ! empty( $results ) ) {

		foreach( $results as $key => $result )
			$results[$key] = new OIH_List( _oih_json_decode_array( $result ) );
	
		return $results;

	} else
		return array();

}


/**
 * Returns OIH_List object from the db coresponding to the given id
 *
 * @param int $list_id
 *
 * @return mixed 	- OIH_List if found, null if not found
 *
 */
function oih_get_list( $list_id = 0 ) {

	if( empty( $list_id ) )
		return null;

	global $wpdb;

	$db 	 = new OIH_Database();
	$table   = $wpdb->prefix . $db->get_prefix() . 'lists';
	$list_id = (int)$list_id;

	$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE id = {$list_id}" , ARRAY_A );

	if( $result )
		return new OIH_List( _oih_json_decode_array( $result ) );
	else
		return null;

}


/**
 * Inserts a list into the db
 *
 * @param array
 *
 * @return int
 *
 */
function oih_insert_list( $data = array() ) {

	if( empty( $data ) )
		return 0;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'lists';

	if( $wpdb->insert( $table, $data ) )
		return $wpdb->insert_id;
	else
		return 0;

}


/**
 * Updates data for a list
 *
 * @param int 	$list_id
 * @param array $data
 *
 * @return bool
 *
 */
function oih_update_list( $list_id = 0, $data = array() ) {

	if( empty( $list_id ) || empty( $data ) )
		return false;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'lists';

	$updated = $wpdb->update( $table, $data, array( 'id' => (int)$list_id ) );

	if( false === $updated )
		return false;
	else
		return true;

}


/**
 * Removes a list from the dabatase
 *
 * @param int $list_id
 *
 * @return bool
 *
 */
function oih_delete_list( $list_id = 0 ) {

	if( empty( $list_id ) )
		return false;

	global $wpdb;
	
	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'lists';

	$deleted = $wpdb->delete( $table, array( 'id' => (int)$list_id ) );

	if( false === $deleted )
		return false;
	else
		return true;

}
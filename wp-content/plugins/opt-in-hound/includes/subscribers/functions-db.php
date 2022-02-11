<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register the custom tables needed for the subscribers
 *
 * @param array $tables
 *
 * @return array
 *
 */
function oih_register_database_table_subscribers( $tables = array() ) {

	$tables[] = 'subscribers';

	return $tables;

}
add_filter( 'oih_database_custom_tables', 'oih_register_database_table_subscribers' );


/**
 * Add the db schema for the subscribers to the plugins db schema string
 *
 * @param string $schema
 * @param string $prefix
 * @param string $charset
 *
 * @return string
 *
 */
function oih_add_database_schema_subscribers( $schema = '', $prefix = '', $charset = '' ) {

	if( empty( $prefix ) || empty( $charset ) )
		return '';

	$schema .= "
		CREATE TABLE {$prefix}subscribers (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			list_id bigint(20) NOT NULL,
			email text NOT NULL,
			first_name text NOT NULL,
			last_name text NOT NULL,
			ip_address text NOT NULL,
			date datetime NOT NULL,
			source text NOT NULL,
			UNIQUE KEY id (id)
		) {$charset};
	";

	return $schema;

}
add_filter( 'oih_database_schema', 'oih_add_database_schema_subscribers', 10, 3 );


/**
 * Returns OIH_Subscriber object from the db coresponding to the given id
 *
 * @param int $id
 *
 * @return mixed 	- OIH_Subscriber if found, null if not found
 *
 */
function oih_get_subscriber_by_id( $id = 0 ) {

	if( empty( $id ) )
		return null;

	global $wpdb;

	$db    		   = new OIH_Database();
	$table 		   = $wpdb->prefix . $db->get_prefix() . 'subscribers';
	$id 		   = (int)$id;

	$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE id = {$id}", ARRAY_A );

	if( $result )
		return new OIH_Subscriber( $result );
	else
		return null;

}


/**
 * Returns OIH_Subscriber object from the db coresponding to the given email
 *
 * @param int 	 $list_id
 * @param string $email_address
 *
 * @return mixed 	- OIH_Subscriber if found, null if not found
 *
 */
function oih_get_subscriber_by_email( $list_id = 0, $email_address = '' ) {

	if( empty( $list_id ) )
		return null;

	if( empty( $email_address ) )
		return null;

	if( ! is_email( $email_address ) )
		return null;

	global $wpdb;

	$db    		   = new OIH_Database();
	$table 		   = $wpdb->prefix . $db->get_prefix() . 'subscribers';
	$email_address = sanitize_email( $email_address );
	$list_id	   = (int)$list_id;

	$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE email = '{$email_address}' AND list_id = '{$list_id}'", ARRAY_A );

	if( $result )
		return new OIH_Subscriber( $result );
	else
		return null;

}


/**
 * Returns an array with OIH_Subscriber objects from the db by the given arguments
 *
 * @param array $args
 *
 * @return array
 *
 */
function oih_get_subscribers( $args = array() ) {

	$defaults = array(
		'order'		  => 'DESC',
		'orderby'     => 'id',
		'number' 	  => 0,
		'offset'	  => 0,
		'list_id'	  => 0,
		'email'		  => '',
		'source'      => '',
		'include'	  => array(),
		'search'	  => ''
	);

	$args = array_merge( $defaults, $args );

	global $wpdb;
	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'subscribers';

	// Start query string
	$query_string  = "SELECT * FROM {$table} ";
	$query_string .= "WHERE 1=%d ";

	// Filter by list_id
	if( ! empty( $args['list_id'] ) ) {
		$query_string .= "AND list_id = '{$args['list_id']}' ";
	}

	// Add search query
    if( ! empty( $args['search'] ) ) {
        $search_term   = sanitize_text_field( $args['search'] );
        $query_string .= " AND " . " ( email LIKE '%%%s%%' OR first_name LIKE '%%%s%%' OR last_name LIKE '%%%s%%' ) " . " ";
    }

	// Select only by given email address
	if( ! empty( $args['email'] ) ) {
		$query_string .= "AND email = '{$args['email']}' ";
	}

	// Select only by given source
	if( ! empty( $args['source'] ) ) {
		$query_string .= "AND source = '{$args['source']}' ";
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
        $results = $wpdb->get_results( $wpdb->prepare( $query_string, 1, $wpdb->esc_like( $search_term ) , $wpdb->esc_like( $search_term ), $wpdb->esc_like( $search_term ) ), ARRAY_A );
    else
        $results = $wpdb->get_results( $wpdb->prepare( $query_string, 1 ), ARRAY_A );


	if( ! empty( $results ) ) {

		foreach( $results as $key => $result )
			$results[$key] = new OIH_Subscriber( _oih_json_decode_array( $result ) );
	
		return $results;

	} else
		return array();

}


/**
 * Inserts a subscriber in multiple lists at once
 * If subscriber is already in a list the list is skipped
 *
 * @param array $list_ids
 * @param array $data
 *
 * @return array 		  - array with new subscriber_ids
 *
 */
function oih_insert_subscriber_in_lists( $list_ids = array(), $data = array() ) {

	if( empty( $data ) )
		return array();

	if( empty( $data['email'] ) )
		return array();

	if( empty( $list_ids ) || ! is_array( $list_ids ) )
		return array();


	/**
	 * Hook for extra action just before inserting the subscriber in the database
	 * in each list
	 *
	 * @param array $list_ids
	 * @param array $data
	 *
	 */
	do_action( 'oih_before_insert_subscriber_in_lists', $list_ids, $data );


	$insert_ids = array();

	// Go through each list and insert the subscriber
	foreach( $list_ids as $list_id ) {

		$list_id = (int)$list_id;

		if( empty( $list_id ) )
			continue;

		// Set subscriber data as received
		$subscriber_data = $data;

		// Check if list exists
		$list = oih_get_list( $list_id );

		if( is_null( $list ) )
			continue;

		// Check if email is already subscribed to the list
		$subscriber = oih_get_subscriber_by_email( $list_id, $subscriber_data['email'] );

		if( ! is_null( $subscriber ) )
			continue;

		$subscriber_data['list_id'] = $list_id;

		$insert_id = oih_insert_subscriber( $subscriber_data );

		if( $insert_id )
			$insert_ids[] = $insert_id;

	}

	return $insert_ids;

}


/**
 * Inserts a subscriber into the db
 *
 * @param array $data
 *
 * @return int
 *
 */
function oih_insert_subscriber( $data = array() ) {

	if( empty( $data ) )
		return 0;

	if( empty( $data['email'] ) )
		return 0;

	if( empty( $data['list_id'] ) )
		return 0;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'subscribers';

	if( $wpdb->insert( $table, $data ) ) {

		/**
		 * Hook to do something after the subscriber has been added to the database
		 *
		 * @param int 	$subscriber_id
		 * @param array $data
		 *
		 */
		do_action( 'oih_insert_subscriber', $wpdb->insert_id, $data );

		return $wpdb->insert_id;

	} else
		return 0;

}


/**
 * Updates data for a subscriber
 *
 * @param int 	$subscriber_id
 * @param array $data
 *
 * @return bool
 *
 */
function oih_update_subscriber( $subscriber_id = 0, $data = array() ) {

	if( empty( $subscriber_id ) || empty( $data ) )
		return false;

	// We don't want to update the list id
	if( ! empty( $data['list_id'] ) )
		unset( $data['list_id'] );

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'subscribers';

	$updated = $wpdb->update( $table, $data, array( 'id' => (int)$subscriber_id ) );

	if( false === $updated )
		return false;

	else {

		/**
		 * Hook to do something after the subscriber has been updated in the database
		 *
		 * @param int 	$subscriber_id
		 * @param array $data
		 *
		 */
		do_action( 'oih_update_subscriber', $subscriber_id, $data );

		return true;

	}

}


/**
 * Removes a subscriber from the dabatase
 *
 * @param int $subscriber_id
 *
 * @return bool
 *
 */
function oih_delete_subscriber( $subscriber_id = 0 ) {

	if( empty( $subscriber_id ) )
		return false;

	global $wpdb;

	$db 	= new OIH_Database();
	$table  = $wpdb->prefix . $db->get_prefix() . 'subscribers';

	$deleted = $wpdb->delete( $table, array( 'id' => (int)$subscriber_id ) );

	if( false === $deleted )
		return false;
	else
		return true;

}
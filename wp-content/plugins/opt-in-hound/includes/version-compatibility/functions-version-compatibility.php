<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Prior to version 1.1.0 to save the source of the subscriber we had a column named "opt_in_id",
 * because at the time the plugin only had the opt-ins as a source to catch subscribers.
 *
 * In version 1.1.0 integrations with other plugins have been added, in order to catch subscribers
 * from different registration forms, such as Profile Builder, Paid Member Subscriptions or WooCommerce
 *
 * The column "opt_in_id" was not suitable anymore for the role, so a new column was added named "source".
 * The name "source" is much more general and we can save here pretty much any string describing the source
 * of the subscriber.
 *
 * In the "opt_in_id" column only the id of the opt-in would be saved. Eg. "14". For the "source" column the source
 * for an opt-in is a string formed from the prefix "opt_in_" and the id number of the opt-in. Eg. "opt_in_14"
 *
 */
function oih_version_compatibility_v_1_1_0( $db_version = '', $db_version_type = '' ) {

	if( empty( $db_version ) )
		return;

	if( empty( $db_version_type ) )
		return;

	// Check to see if this compatibility script has already been done
	$compatibility_done = get_option( 'oih_version_compatibility_v_1_1_0', '' );

	if( ! empty( $compatibility_done ) )
		return;

	global $wpdb;

	$db    = new OIH_Database();
	$table = $wpdb->prefix . $db->get_prefix() . 'subscribers';

	if ( $wpdb->get_var( "SHOW COLUMNS FROM {$table} LIKE 'opt_in_id';" ) ) {

		// Add data from the "opt_in_id" column to the "source" column
		$wpdb->query( $wpdb->prepare( "UPDATE {$table} SET source = CONCAT('opt_in_', opt_in_id) WHERE 1=%d", 1 ) );

		// Remove the "opt_in_id" column
		$wpdb->query( "ALTER TABLE {$table} DROP COLUMN opt_in_id" );

	}

	// Version compatibility done
	update_option( 'oih_version_compatibility_v_1_1_0', 1 );

}
add_action( 'oih_update_check', 'oih_version_compatibility_v_1_1_0', 11, 2 );


/**
 * Version 1.2.0 introduces support for subscriber lists. 
 *
 * What had to be done to implement this feature is:
 * 1) Add another table to the database, named "oih_lists", in which we save the available list.
 * 2) Add another column, named "list_id", in the "oih_subscribers" table where we save the id of the list
 *    the subscriber is added to.
 *
 * Prior to version 1.2.0 the "list_id" column did not exist, thus it is needed in version 1.2.0 to create
 * a first list, with the id "1" and to add this id to each subscriber in the "list_id" column.
 * 
 * Given that all opt-ins need to point the subscriber into a certain list, we have to add this newly created
 * list_id to all opt-ins in the opt-in's options array
 *
 * Also, because all integrations need to point the subscriber into a certain list, 
 * we have have to add this first list_id to all integrations.
 *
 */
function oih_version_compatibility_v_1_2_0( $db_version = '', $db_version_type = '' ) {

	// Check to see if this compatibility script has already been done
	$compatibility_done = get_option( 'oih_version_compatibility_v_1_2_0', '' );

	if( ! empty( $compatibility_done ) )
		return;

	/**
	 * If we already have lists, consider this compatibility as done
	 *
	 */
	$lists = oih_get_lists();

	if( ! empty( $lists ) ) {

		update_option( 'oih_version_compatibility_v_1_2_0', 1 );
		return;

	}

	global $wpdb;

	$db    			   = new OIH_Database();
	$table_subscribers = $wpdb->prefix . $db->get_prefix() . 'subscribers';
	$table_opt_ins	   = $wpdb->prefix . $db->get_prefix() . 'opt_ins';

	/**
	 * Insert the first list
	 *
	 */
	$list_data = array(
		'name' 		  => __( 'My First List', 'opt-in-hound' ),
		'description' => __( 'This is your first list. It was created automatically by the plugin to get you started faster. You can of course change this information to suit your needs.', 'opt-in-hound' ),
		'date'		  => date( 'Y-m-d H:i:s' )
	);

	$list_id = oih_insert_list( $list_data );

	/**
	 * Add the list id to all existing subscribers
	 *
	 */
	if( ! empty( $list_id ) ) {

		$subscribers = oih_get_subscribers();

		// Update each subscriber and add the created list id if the subscriber doesn't have a list id added
		foreach( $subscribers as $subscriber ) {

			$subscriber_list_id = $subscriber->get('list_id');

			// Skip if the subscriber already has a list id attached
			if( ! empty( $subscriber_list_id ) )
				continue;

			$subscriber_id = $subscriber->get('id');

			// Update the subscriber with the list id
			$wpdb->query( $wpdb->prepare( "UPDATE {$table_subscribers} SET list_id = {$list_id} WHERE 1=%d AND id = {$subscriber_id}", 1 ) );

		}

	}

	/**
	 * Add the list id to all existing opt-ins
	 *
	 */
	if( ! empty( $list_id ) ) {

		$opt_ins = oih_get_opt_ins();

		foreach( $opt_ins as $opt_in ) {

			$opt_in_options = $opt_in->get('options');

			// Skip if the opt-in already has a list attached
			if( ! empty( $opt_in_options['subscriber_lists'] ) && is_array( $opt_in_options['subscriber_lists'] ) )
				continue;

			$opt_in_options['subscriber_lists'] = array( $list_id );

			$opt_in_data = array(
				'options' => $opt_in_options
			);

			oih_update_opt_in( $opt_in->get('id'), $opt_in_data );

		}

	}

	/**
	 * Add the list id to all existing integrations
	 *
	 */
	if( ! empty( $list_id ) ) {

		$integrations = oih_get_available_integrations();

		foreach( $integrations as $integration_slug => $integration_data ) {

			if( $integration_slug == 'profile_builder' )
				continue;

			// Get integration settings
			$integration_settings = oih_get_integration_settings( $integration_slug );

			// Skip if no integration settings are set
			if( empty( $integration_settings ) )
				continue;

			// Skip if the lists are already added
			if( ! empty( $integration_settings['subscribe_checkbox_subscriber_lists'] ) )
				continue;

			$integration_settings['subscribe_checkbox_subscriber_lists'] = array( $list_id );
			
			oih_update_integration_settings( $integration_slug, $integration_settings );

		}

	}

	// Version compatibility done
	update_option( 'oih_version_compatibility_v_1_2_0', 1 );

}
add_action( 'oih_update_check', 'oih_version_compatibility_v_1_2_0', 11, 2 );


/**
 * In version 1.4.0 the Opt-In Schedule mechanism has been changed from the simple start date / end date
 * to a repeater field where the admin can add multiple date_range, recurring_weekly and 
 * recurring_monthly fields.
 *
 * This change comes with a structure change in the "options" value of the opt-ins. The "start_date" and 
 * "end_date" options elements do not exist anymore. They have been replaced by an array named "schedules"
 *
 */
function oih_version_compatibility_v_1_4_0( $db_version = '', $db_version_type = '' ) {

	// Check to see if this compatibility script has already been done
	$compatibility_done = get_option( 'oih_version_compatibility_v_1_4_0', '' );

	if( ! empty( $compatibility_done ) )
		return;

	/**
	 * Remove scheduled cron jobs for the old Opt-In Scheduler
	 *
	 */
	if( wp_next_scheduled( 'oih_cron_deactivate_opt_ins' ) )
		wp_clear_scheduled_hook( 'oih_cron_deactivate_opt_ins' );

	// Get all opt-ins
	$opt_ins = oih_get_opt_ins();

	foreach( $opt_ins as $opt_in ) {

		$opt_in_options = $opt_in->get('options');

		if( empty( $opt_in_options['start_date'] ) && empty( $opt_in_options['end_date'] ) )
			continue;

		if( ! empty( $opt_in_options['schedules'] ) )
			continue;

		$opt_in_options['schedules']['1'] = array(
			'type' 		 => 'date_range',
			'start_date' => ( ! empty( $opt_in_options['start_date'] ) ? $opt_in_options['start_date'] : '' ),
			'end_date'   => ( ! empty( $opt_in_options['end_date'] ) ? $opt_in_options['end_date'] : '' )
		);

		$opt_in_data = array(
			'options' => $opt_in_options
		);

		oih_update_opt_in( $opt_in->get('id'), $opt_in_data );

	}

	// Version compatibility done
	update_option( 'oih_version_compatibility_v_1_4_0', 1 );

}
add_action( 'oih_update_check', 'oih_version_compatibility_v_1_4_0', 10, 2 );
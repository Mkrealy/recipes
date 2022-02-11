<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include Paid Member Subscriptions integration files
 *
 */
function oih_include_files_integration_paid_member_subscriptions() {

	include 'front-end/subscribe-field.php';

}
add_action( 'oih_include_files_integrations', 'oih_include_files_integration_paid_member_subscriptions' );


/**
 * Register the Paid Member Subscriptions integration
 *
 */
function oih_register_available_integration_paid_member_subscriptions( $integrations = array() ) {

	if( ! is_array( $integrations ) )
		return array();

	$integrations['paid_member_subscriptions'] = array(
		'name' 		   => 'Paid Member Subscriptions',
		'description'  => __( 'Subscribe users from your Paid Member Subscriptions register form.', 'opt-in-hound' ),
		'has_settings' => 1
	);

	return $integrations;

}
add_filter( 'oih_available_integrations', 'oih_register_available_integration_paid_member_subscriptions', 40 );


/**
 * Determines whether the Paid Member Subscription plugin is active or not
 *
 * @param bool $is_active
 *
 * @return bool
 *
 */
function oih_is_integration_plugin_active_paid_member_subscriptions( $is_active = false ) {

	if( defined( 'PMS_VERSION' ) )
		return true;

	return false;

}
add_filter( 'oih_is_integration_plugin_active_paid_member_subscriptions', 'oih_is_integration_plugin_active_paid_member_subscriptions', 10 );


/**
 * Register the source names for the subscriber source
 *
 * @param array  $source_names
 * @param string $source_slug
 *
 * @return array
 *
 */
function oih_subscriber_source_names_paid_member_subscriptions( $source_names = array(), $source_slug = '' ) {

	if( $source_slug == 'paid_member_subscriptions_register' ) {

		$source_names = array(
			'short_name' => 'PMS',
			'long_name'	 => 'Paid Member Subscriptions Register'
		);

	}	

	return $source_names;

}
add_action( 'oih_subscriber_source_names', 'oih_subscriber_source_names_paid_member_subscriptions', 10, 2 );

/**
 * Includes the view for the Paid Member Subscriptions integration settings page
 *
 * @param string $integration_slug
 *
 */
function oih_settings_edit_integration_paid_member_subscriptions() {

	$integration_slug = 'paid_member_subscriptions';

	include 'views/view-settings-edit-integration.php';

}
add_action( 'oih_submenu_page_settings_edit_integration_paid_member_subscriptions', 'oih_settings_edit_integration_paid_member_subscriptions' );
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Include Profile Builder integration files
 *
 */
function oih_include_files_integration_profile_builder() {

	include 'admin/manage-fields.php';
	include 'front-end/subscribe-field.php';

}
add_action( 'oih_include_files_integrations', 'oih_include_files_integration_profile_builder' );


/**
 * Enqueue needed scripts for the admin area
 *
 */
function oih_enqueue_admin_scripts_profile_builder() {

	if( ! oih_is_integration_plugin_active( 'profile_builder' ) )
		return;

	wp_register_script( 'oih-script-profile-builder', OIH_PLUGIN_INTEGRATIONS_DIR_URL . 'available-integrations/profile-builder/assets/js/main.js', array( 'jquery', 'wp-color-picker' ), OIH_VERSION );
	wp_enqueue_script( 'oih-script-profile-builder' );

	wp_register_style( 'oih-style-profile-builder', OIH_PLUGIN_INTEGRATIONS_DIR_URL . 'available-integrations/profile-builder/assets/css/style-admin-opt-in-hound-profile-builder.css', array(), OIH_VERSION );
	wp_enqueue_style( 'oih-style-profile-builder' );

}
add_action( 'oih_enqueue_admin_scripts', 'oih_enqueue_admin_scripts_profile_builder' );


/**
 * Enqueue needed scripts for the front-end area
 *
 */
function oih_enqueue_front_end_scripts_profile_builder() {

	if( ! oih_is_integration_plugin_active( 'profile_builder' ) )
		return;

	wp_register_style( 'oih-style-profile-builder', OIH_PLUGIN_INTEGRATIONS_DIR_URL . 'available-integrations/profile-builder/assets/css/style-front-opt-in-hound-profile-builder.css', array(), OIH_VERSION );
	wp_enqueue_style( 'oih-style-profile-builder' );

}
add_action( 'oih_enqueue_front_end_scripts', 'oih_enqueue_front_end_scripts_profile_builder' );


/**
 * Register the Profile Builder integration
 *
 */
function oih_register_available_integration_profile_builder( $integrations = array() ) {

	if( ! is_array( $integrations ) )
		return array();

	$integrations['profile_builder'] = array(
		'name' 		   => 'Profile Builder',
		'description'  => __( 'Subscribe users from your Profile Builder register forms.', 'opt-in-hound' ),
		'has_settings' => 1
	);

	return $integrations;

}
add_filter( 'oih_available_integrations', 'oih_register_available_integration_profile_builder', 30 );


/**
 * Determines whether the Profile Builder plugin is active or not
 *
 * @param bool $is_active
 *
 * @return bool
 *
 */
function oih_is_integration_plugin_active_profile_builder( $is_active = false ) {

	if( defined( 'PROFILE_BUILDER_VERSION' ) )
		return true;

	return false;

}
add_filter( 'oih_is_integration_plugin_active_profile_builder', 'oih_is_integration_plugin_active_profile_builder', 10 );


/**
 * Register the source names for the subscriber source
 *
 * @param array  $source_names
 * @param string $source_slug
 *
 * @return array
 *
 */
function oih_subscriber_source_names_profile_builder( $source_names = array(), $source_slug = '' ) {

	if( $source_slug == 'profile_builder_register' ) {

		$source_names = array(
			'short_name' => 'PB',
			'long_name'	 => 'Profile Builder Register'
		);

	}
		

	return $source_names;

}
add_action( 'oih_subscriber_source_names', 'oih_subscriber_source_names_profile_builder', 10, 2 );


/**
 * Includes the view for the Profile Builder integration settings page
 *
 * @param string $integration_slug
 *
 */
function oih_settings_edit_integration_profile_builder() {

	$integration_slug = 'profile_builder';

	include 'views/view-settings-edit-integration.php';

}
add_action( 'oih_submenu_page_settings_edit_integration_profile_builder', 'oih_settings_edit_integration_profile_builder' );
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include Easy Digital Downloads integration files
 *
 */
function oih_include_files_integration_easy_digital_downloads() {

	include 'front-end/subscribe-field.php';

}
add_action( 'oih_include_files_integrations', 'oih_include_files_integration_easy_digital_downloads' );


/**
 * Register the Easy Digital Downloads integration
 *
 */
function oih_register_available_integration_easy_digital_downloads( $integrations = array() ) {

	if( ! is_array( $integrations ) )
		return array();

	$integrations['easy_digital_downloads'] = array(
		'name' 		   => 'Easy Digital Downloads',
		'description'  => __( 'Subscribe users from your Easy Digital Downloads checkout form.', 'opt-in-hound' ),
		'has_settings' => 1
	);

	return $integrations;

}
add_filter( 'oih_available_integrations', 'oih_register_available_integration_easy_digital_downloads', 20 );


/**
 * Determines whether the Easy Digital Downloads plugin is active or not
 *
 * @param bool $is_active
 *
 * @return bool
 *
 */
function oih_is_integration_plugin_active_easy_digital_downloads( $is_active = false ) {

	if( defined( 'EDD_VERSION' ) )
		return true;

	return false;

}
add_filter( 'oih_is_integration_plugin_active_easy_digital_downloads', 'oih_is_integration_plugin_active_easy_digital_downloads', 10 );


/**
 * Register the source names for the subscriber source
 *
 * @param array  $source_names
 * @param string $source_slug
 *
 * @return array
 *
 */
function oih_subscriber_source_names_easy_digital_downloads( $source_names = array(), $source_slug = '' ) {

	if( $source_slug == 'easy_digital_downloads_register' ) {

		$source_names = array(
			'short_name' => 'EDD',
			'long_name'	 => 'Easy Digital Downloads Register'
		);

	}	

	return $source_names;

}
add_action( 'oih_subscriber_source_names', 'oih_subscriber_source_names_easy_digital_downloads', 10, 2 );

/**
 * Includes the view for the Easy Digital Downloads integration settings page
 *
 * @param string $integration_slug
 *
 */
function oih_settings_edit_integration_easy_digital_downloads() {

	$integration_slug = 'easy_digital_downloads';

	include 'views/view-settings-edit-integration.php';

}
add_action( 'oih_submenu_page_settings_edit_integration_easy_digital_downloads', 'oih_settings_edit_integration_easy_digital_downloads' );
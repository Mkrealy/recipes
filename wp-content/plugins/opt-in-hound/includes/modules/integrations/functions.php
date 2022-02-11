<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Define constants for the integrations module
 *
 */
function oih_define_constants_integrations() {
	
	define( 'OIH_PLUGIN_INTEGRATIONS_DIR',     plugin_dir_path( __FILE__ ) );
	define( 'OIH_PLUGIN_INTEGRATIONS_DIR_URL', plugin_dir_url( __FILE__ ) );

}
add_action( 'oih_initialized', 'oih_define_constants_integrations' );


/**
 * Include integrations files
 *
 */
function oih_include_integrations_files() {

	if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/integrations/class-list-table-integrations.php' ) )
		include 'class-list-table-integrations.php';

	// Include all available integration files
	$dirs = array_filter( glob( OIH_PLUGIN_DIR . 'includes/modules/integrations/available-integrations/*' ), 'is_dir' );
    
    foreach( $dirs as $dir ) {
        if( file_exists( $file =  $dir . '/functions.php' ) ){
            include ( $file );
        }
    }

    /**
	 * Helper hook to include files early in the integrations module
	 *
	 */
    do_action( 'oih_include_files_integrations' );

}
add_action( 'oih_include_files', 'oih_include_integrations_files', 10 );


/**
 * Adds the Integration tab to the plugin's Settings page
 *
 * @param array $settings_tabs
 *
 * @return array
 *
 */
function oih_submenu_page_settings_tabs_integrations( $settings_tabs = array() ) {

	$settings_tabs['integrations'] = __( 'Integrations', 'opt-in-hound' );

	return $settings_tabs;

}
add_filter( 'oih_submenu_page_settings_tabs', 'oih_submenu_page_settings_tabs_integrations', 20 );


/**
 * Adds the content of the Integrations tab in the Settings page
 *
 * @param array $settings
 *
 */
function oih_submenu_page_settings_tab_integrations( $settings = array() ) {

	if( empty( $_GET['integration'] ) ) {

		echo '<h2>';
			echo __( 'Available Integrations', 'opt-in-hound' );
		echo '</h2>';

		echo '<p>' . __( 'Click on the name of an integration to edit all settings specific to that integration. Greyed out integrations will become available after installing & activating the corresponding plugin.', 'opt-in-hound' ) . '</p>';

		$table = new OIH_WP_List_Table_Integrations();
		$table->display();

		echo '<br />';

	} else {

		$integration_slug = sanitize_text_field( $_GET['integration'] );
		$integrations 	  = oih_get_available_integrations();

		if( empty( $integrations[ $integration_slug ]['name'] ) )
			return;

		echo '<div class="oih-settings-integration-wrapper">';

			echo '<h2>';
				printf( __( '%s Integration Settings', 'opt-in-hound' ), $integrations[ $integration_slug ]['name'] );
				echo '<a href="' . remove_query_arg( 'integration', oih_get_current_page_url() ) . '" id="oih-button-back-to-integrations" class="button-secondary">' . __( 'Back to Integrations', 'opt-in-hound' ) . '</a>';
			echo '</h2>';

			// Hidden field that mentions for which integration to save the options settings
			echo '<input type="hidden" name="oih_settings_integration" value="' . $integration_slug . '" />';

			/**
			 * Hook for each integration to display their settings fields
			 *
			 * @param string
			 *
			 */
			do_action( 'oih_submenu_page_settings_edit_integration_' . sanitize_text_field( $_GET['integration'] ) );

		echo '</div>';

	}

}
add_action( 'oih_submenu_page_settings_tab_integrations', 'oih_submenu_page_settings_tab_integrations', 20 );


/**
 * Returns the available integrations
 *
 * @return array
 *
 */
function oih_get_available_integrations() {

	/**
	 * Filter to dynamically add integrations
	 *
	 * @param array
	 *
	 */
	$integrations = apply_filters( 'oih_available_integrations', array() );

	$integrations = ( is_array( $integrations ) ? $integrations : array() );

	return $integrations;

}


/**
 * Returns the settings saved for the given integration
 *
 * @param string $integration_slug
 *
 * @return array
 *
 */
function oih_get_integration_settings( $integration_slug = '' ) {

	if( empty( $integration_slug ) )
		return array();

	return get_option( 'oih_settings_integration_' . $integration_slug, array() );

}


/**
 * Updates the settings for the given integration
 *
 * @param string $integration_slug
 * @param array  $data
 *
 * @return bool
 *
 */
function oih_update_integration_settings( $integration_slug = '', $data = array() ) {

	if( empty( $integration_slug ) )
		return false;

	return update_option( 'oih_settings_integration_' . $integration_slug, $data );

}


/**
 * Returns the name of the settings option saved in the db
 *
 * @param string $integration_slug
 *
 * @return string
 *
 */
function oih_get_integration_settings_name( $integration_slug = '' ) {

	if( empty( $integration_slug ) )
		return '';

	return 'oih_settings_integration_' . $integration_slug;

}


/**
 * Registers the settings for the integration being updated
 *
 */
function oih_register_settings_integrations() {

	if( empty( $_POST['oih_settings_integration'] ) )
		return;

	$integration_slug = sanitize_text_field( $_POST['oih_settings_integration'] );

	register_setting( 'oih_settings', 'oih_settings_integration_' . $integration_slug );

}
add_action( 'admin_init', 'oih_register_settings_integrations', 50 );


/**
 * Checks to see if the plugin for which we want to make the integration with
 * is present and active in the Plugins page of WP
 *
 * @param string $integration_slug
 *
 * @return bool
 *
 */
function oih_is_integration_plugin_active( $integration_slug = '' ) {

	/**
	 * Integrations should take the wheel to determine if the plugins for which the integration
	 * is being made is active or not
	 *
	 * @param bool false
	 *
	 */
	return apply_filters( 'oih_is_integration_plugin_active_' . $integration_slug, false );

}
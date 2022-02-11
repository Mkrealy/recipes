<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Uninstaller submenu page
 *
 */
Class OIH_Submenu_Page_Uninstaller extends OIH_Submenu_Page {

	/**
	 * Handles the output
	 *
	 */
	public function output() {

		include 'views/view-submenu-page-uninstall.php';

	}


	/**
	 * Listen for requests to uninstall the plugin
	 *
	 */
	public function request_listener() {

		if( empty( $_GET['page'] ) || $_GET['page'] != $this->menu_slug )
			return;

		if( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'oih_uninstall_page_nonce' ) )
			return;

		if( empty( $_POST['oih_token'] ) || ! wp_verify_nonce( $_POST['oih_token'], 'oih_uninstall' ) )
			return;

		if( empty( $_POST['oih_uninstall_plugin'] ) )
			return;

		if( $_POST['oih_uninstall_plugin'] !== 'REMOVE' )
			return;

		// Drop the custom tables
		$db = new OIH_Database();
		$db->drop_tables();

		// Remove options
		global $wpdb;

		$options = $wpdb->get_results( "SELECT * FROM {$wpdb->options} WHERE option_name LIKE '%oih_%'", ARRAY_A );
		
		if( ! empty( $options ) ) {
			foreach( $options as $option ) {
				delete_option( $option['option_name'] );
			}
		}

		// Deactivate the plugin
	    deactivate_plugins( OIH_BASENAME );
	    
	    wp_redirect( admin_url( 'plugins.php' ) );
	    exit;

	}

}

/**
 * Uninstaller submenu page initializer
 *
 */
function oih_add_submenu_page_uninstaller() {

	new OIH_Submenu_Page_Uninstaller( null, __( 'Uninstall', 'opt-in-hound' ), __( 'Uninstall', 'opt-in-hound' ), 'manage_options', 'oih-uninstall' );

}
add_action( 'init', 'oih_add_submenu_page_uninstaller' );
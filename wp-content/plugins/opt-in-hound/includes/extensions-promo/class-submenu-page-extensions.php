<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Opt-ins submenu page
 *
 */
Class OIH_Submenu_Page_Extensions extends OIH_Submenu_Page {


	/**
	 * Handles the output for different cases
	 *
	 */
	public function output() {

		include 'views/view-submenu-page-extensions.php';

	}

}

/**
 * Opt-ins submenu page initializer
 *
 */
function oih_add_submenu_page_extensions() {

	new OIH_Submenu_Page_Extensions( 'opt-in-hound', __( 'Extensions', 'opt-in-hound' ), '<strong style="color: orange;">' . __( 'Extensions', 'opt-in-hound' ) . '</strong>', 'manage_options', 'oih-extensions' );

}
add_action( 'init', 'oih_add_submenu_page_extensions', 150 );
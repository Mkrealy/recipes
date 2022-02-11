<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Settings submenu page
 *
 */
Class OIH_Submenu_Page_Settings extends OIH_Submenu_Page {

	/**
	 * Tabs for different settings sections
	 *
	 */
	protected $tabs;


	/**
	 * Constructor
	 *
	 */
	public function __construct( $parent_slug = '', $page_title = '', $menu_title = '', $capability = '', $menu_slug = '' ) {
		
		parent::__construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug );

		add_action( 'admin_init', array( $this, 'register_settings' ) );

		/**
		 * Filter to dynamically add custom tabs in the settings page
		 *
		 * @param array
		 *
		 */
		$this->tabs = apply_filters( 'oih_submenu_page_settings_tabs', array() );

	}


	/**
	 * Registers the settings option
	 *
	 */
	public function register_settings() {

		register_setting( 'oih_settings', 'oih_settings', array( $this, 'settings_sanitize' ) );

	}


	/**
	 * Sanitizes the settings before saving them to the db
	 *
	 */
	public function settings_sanitize( $settings ) {

		return $settings;

	}


	/**
	 * Handles the output for different cases
	 *
	 */
	public function output() {

		include 'views/view-submenu-page-settings.php';

	}

}

/**
 * Settings submenu page initializer
 *
 */
function oih_add_submenu_page_settings() {

	new OIH_Submenu_Page_Settings( 'opt-in-hound', __( 'Settings', 'opt-in-hound' ), __( 'Settings', 'opt-in-hound' ), 'manage_options', 'oih-settings' );

}
add_action( 'init', 'oih_add_submenu_page_settings', 100 );
<?php
/**
 * Plugin Name: Opt-In Hound
 * Plugin URI: http://www.devpups.com/opt-in-hound/
 * Description: Add simple and beautiful e-mail opt-in pop-ups and opt-in widgets to increase your e-mail subscribers
 * Version: 1.4.3
 * Author: DevPups, Mihai Iova
 * Author URI: http://www.devpups.com/
 * License: GPL2
 *
 * == Copyright ==
 * Copyright 2017 DevPups (www.devpups.com)
 *	
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class Opt_In_Hound {

	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		// Defining constants
		define( 'OIH_VERSION', 				  '1.4.3' );
		define( 'OIH_BASENAME',  			  plugin_basename( __FILE__ ) );
		define( 'OIH_PLUGIN_DIR', 			  plugin_dir_path( __FILE__ ) );
		define( 'OIH_PLUGIN_DIR_URL', 		  plugin_dir_url( __FILE__ ) );

		$this->include_files();

		define( 'OIH_VERSION_TYPE', 		  apply_filters( 'oih_get_plugin_version_type', 'free' ) );
		define( 'OIH_TRANSLATION_DIR', 		  OIH_PLUGIN_DIR . '/translations' );
		define( 'OIH_TRANSLATION_TEXTDOMAIN', 'opt-in-hound' );

		// Check if just updated
		add_action( 'plugins_loaded', array( $this, 'update_check' ), 20 );

		// Add and remove main plugin page
		add_action( 'admin_menu', array( $this, 'add_main_menu_page' ), 10 );
        add_action( 'admin_menu', array( $this, 'remove_main_menu_page' ), 11 );

        // Admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

        // Front-end scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_end_scripts' ) );

        // Add a 5 star review call to action to admin footer text
        add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );

        register_activation_hook( __FILE__, array( $this, 'set_cron_jobs' ) );
        register_deactivation_hook( __FILE__, array( $this, 'unset_cron_jobs' ) );

        /**
         * Plugin initialized
         *
         */
        do_action( 'oih_initialized' );

	}


	/**
	 * Add the main menu page
	 *
	 */
	public function add_main_menu_page() {

		add_menu_page( 'Opt-In Hound', 'Opt-In Hound', 'manage_options', 'opt-in-hound', '','dashicons-email-alt', 30 );

	}
    
    /**
	 * Remove the main menu page as we will rely only on submenu pages
	 *
	 */
	public function remove_main_menu_page() {

		remove_submenu_page( 'opt-in-hound', 'opt-in-hound' );

	}


	/**
	 * Checks to see if the current version of the plugin matches the version
	 * saved in the database
	 *
	 * @return void 
	 *
	 */
	public function update_check() {

		$db_version 	 = get_option( 'oih_version', '' );
		$db_version_type = get_option( 'oih_version_type', '' );

		$do_update 		 = false;

		// If current version number differs from saved version number
		if( $db_version != OIH_VERSION ) {

			$do_update = true;

			// Update the version number in the db
			update_option( 'oih_version', OIH_VERSION );

			// Add first activation time
			if( get_option( 'oih_first_activation', '' ) == '' )
				update_option( 'oih_first_activation', time() );

		}

		// If current version type differs from saved version type
		if( $db_version_type != OIH_VERSION_TYPE ) {

			$do_update = true;

			// Update the version number in the db
			update_option( 'oih_version_type', OIH_VERSION_TYPE );

		}

		if( $do_update ) {

			// Update database
			$this->update_database_tables();

			// Hook for fresh update
			do_action( 'oih_update_check', $db_version, $db_version_type );

			// Trigger set cron jobs
			$this->set_cron_jobs();

		}

	}


	/**
	 * Creates and updates the database tables 
	 *
	 * @return void
	 *
	 */
	private function update_database_tables() {

		$db = new OIH_Database();
		$db->update_tables();

	}


	/**
	 * Sets an action hook for modules to add custom schedules
	 *
	 */
	public function set_cron_jobs() {

		do_action( 'oih_set_cron_jobs' );

	}


	/**
	 * Sets an action hook for modules to remove custom schedules
	 *
	 */
	public function unset_cron_jobs() {

		do_action( 'oih_unset_cron_jobs' );

	}


	/**
	 * Include files
	 *
	 * @return void
	 *
	 */
	public function include_files() {

		// Functions
		if( file_exists( OIH_PLUGIN_DIR . 'includes/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/functions.php';

		// Utilities
		if( file_exists( OIH_PLUGIN_DIR . 'includes/functions-utils.php' ) )
			require OIH_PLUGIN_DIR . 'includes/functions-utils.php';

		// Database
		if( file_exists( OIH_PLUGIN_DIR . 'includes/class-database.php' ) )
			require OIH_PLUGIN_DIR . 'includes/class-database.php';

		// Version Compatibility
		if( file_exists( OIH_PLUGIN_DIR . 'includes/version-compatibility/functions-version-compatibility.php' ) )
			require OIH_PLUGIN_DIR . 'includes/version-compatibility/functions-version-compatibility.php';

		// Abstracts
		if( file_exists( OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-list-table.php' ) )
			require OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-list-table.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-submenu-page.php' ) )
			require OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-submenu-page.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-merge-tags.php' ) )
			require OIH_PLUGIN_DIR . 'includes/abstracts/abstract-class-merge-tags.php';

		// General settings
		if( file_exists( OIH_PLUGIN_DIR . 'includes/settings/class-submenu-page-settings.php' ) )
			include OIH_PLUGIN_DIR . 'includes/settings/class-submenu-page-settings.php';

		// Opt-in forms
		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/functions-db.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/functions-db.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/functions.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-outputter-factory.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-outputter-factory.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-outputter-base.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-outputter-base.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-form-handler.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-opt-in-form-handler.php';		

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-submenu-page-opt-ins.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-submenu-page-opt-ins.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/class-list-table-opt-ins.php' ) )
			require OIH_PLUGIN_DIR . 'includes/opt-ins/class-list-table-opt-ins.php';

		// Lists
		if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/lists/functions.php';

		// Subscribers
		if( file_exists( OIH_PLUGIN_DIR . 'includes/subscribers/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/subscribers/functions.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/subscribers/functions-db.php' ) )
			require OIH_PLUGIN_DIR . 'includes/subscribers/functions-db.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/subscribers/class-subscriber.php' ) )
			require OIH_PLUGIN_DIR . 'includes/subscribers/class-subscriber.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/subscribers/class-list-table-subscribers.php' ) )
			require OIH_PLUGIN_DIR . 'includes/subscribers/class-list-table-subscribers.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/subscribers/class-merge-tags-subscribers.php' ) )
			require OIH_PLUGIN_DIR . 'includes/subscribers/class-merge-tags-subscribers.php';

		// Lists
		if( file_exists( OIH_PLUGIN_DIR . 'includes/email-providers/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/email-providers/functions.php';

		// Admin
		if( file_exists( OIH_PLUGIN_DIR . 'includes/functions-admin.php' ) )
			require OIH_PLUGIN_DIR . 'includes/functions-admin.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/functions-admin-settings-fields.php' ) )
			require OIH_PLUGIN_DIR . 'includes/functions-admin-settings-fields.php';

		// Statistics
		if( file_exists( OIH_PLUGIN_DIR . 'includes/statistics/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/statistics/functions.php';

		// Uninstaller Module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/uninstaller/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/uninstaller/functions.php';

		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/uninstaller/class-submenu-page-uninstall.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/uninstaller/class-submenu-page-uninstall.php';

		// Integrations module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/integrations/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/integrations/functions.php';

		// Email notifications module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/email-notifications/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/email-notifications/functions.php';

		// Opt-in active period module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/opt-in-schedules/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/opt-in-schedules/functions.php';

		// Google Fonts module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/opt-in-google-fonts/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/opt-in-google-fonts/functions.php';

		// Update checker Module
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/update-checker/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/update-checker/functions.php';

		// Extensions Promo
		if( file_exists( OIH_PLUGIN_DIR . 'includes/extensions-promo/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/extensions-promo/functions.php';

		// Feedback
		if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/feedback-form/functions.php' ) )
			require OIH_PLUGIN_DIR . 'includes/modules/feedback-form/functions.php';

		/**
		 * Helper hook to include files early
		 *
		 */
		do_action( 'oih_include_files' );

	}


	/**
	 * Enqueue the scripts and style for the admin area
	 *
	 */
	public function enqueue_admin_scripts( $hook ) {

		if( strpos( $hook, 'oih' ) !== false ) {

			// Color picker
    		wp_enqueue_style( 'jquery-style', OIH_PLUGIN_DIR_URL . 'assets/css/jquery-ui.css', array(), OIH_VERSION );
			wp_enqueue_style( 'wp-color-picker' );

			// Chosen
			global $wp_scripts;

	        // Try to detect if chosen has already been loaded
	        $found_chosen = false;

	        foreach( $wp_scripts as $wp_script ) {
	            if( ! empty( $wp_script['src'] ) && strpos( $wp_script['src'], 'chosen' ) !== false )
	                $found_chosen = true;
	        }

	        if( ! $found_chosen ) {
	            wp_enqueue_script( 'oih-chosen', OIH_PLUGIN_DIR_URL . 'assets/libs/chosen/chosen.jquery.min.js', array( 'jquery' ), OIH_VERSION );
	            wp_enqueue_style( 'oih-chosen', OIH_PLUGIN_DIR_URL . 'assets/libs/chosen/chosen.css', array(), OIH_VERSION );
	        }

		}

		// Daterange Picker
		if( strpos( $hook, 'oih-statistics' ) !== false ) {

			wp_enqueue_script( 'oih-moment', OIH_PLUGIN_DIR_URL . 'assets/libs/daterangepicker/moment.min.js', array( 'jquery' ), OIH_VERSION );
	        wp_enqueue_script( 'oih-daterangepicker-script', OIH_PLUGIN_DIR_URL . 'assets/libs/daterangepicker/daterangepicker.js', array( 'jquery', 'oih-moment' ), OIH_VERSION );
	        wp_enqueue_script( 'oih-chartsjs', OIH_PLUGIN_DIR_URL . 'assets/libs/chartjs/chart.min.js', array( 'jquery' ), OIH_VERSION );

 			wp_enqueue_style( 'oih-daterangepicker-style', OIH_PLUGIN_DIR_URL . 'assets/libs/daterangepicker/daterangepicker.css', array(), OIH_VERSION );

		}

		// Plugin styles
		wp_register_style( 'oih-style', OIH_PLUGIN_DIR_URL . 'assets/css/style-admin-opt-in-hound.css', array(), OIH_VERSION );
		wp_enqueue_style( 'oih-style' );

		// Plugin script
		wp_register_script( 'oih-script', OIH_PLUGIN_DIR_URL . 'assets/js/script-admin-opt-in-hound.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-datepicker' ), OIH_VERSION );
		wp_enqueue_script( 'oih-script' );

		/**
		 * Hook to enqueue scripts immediately after the plugin's scripts
		 *
		 */
		do_action( 'oih_enqueue_admin_scripts' );

	}


	/**
	 * Enqueue the scripts and style for the front-end part
	 *
	 */
	public function enqueue_front_end_scripts() {

		// Plugin styles
		wp_register_style( 'oih-style', OIH_PLUGIN_DIR_URL . 'assets/css/style-front-opt-in-hound.css', array(), OIH_VERSION );
		wp_enqueue_style( 'oih-style' );

		// Plugin script
		wp_register_script( 'oih-script', OIH_PLUGIN_DIR_URL . 'assets/js/script-front-opt-in-hound.js', array( 'jquery' ), OIH_VERSION, true );
		wp_enqueue_script( 'oih-script' );

		$ajax_url = "
			var oih_ajax_url = '" . admin_url( 'admin-ajax.php' ) . "';
		";
		
		wp_add_inline_script( 'oih-script', $ajax_url, 'before' );

		/**
		 * Hook to enqueue scripts immediately after the plugin's scripts
		 *
		 */
		do_action( 'oih_enqueue_front_end_scripts' );

	}


	/**
	 * Replace admin footer text with a rate plugin message
	 *
	 * @param string $text
	 *
	 */
	public function admin_footer_text( $text ) {

		if( isset( $_GET['page'] ) && strpos( $_GET['page'], 'oih' ) !== false ) {

			return sprintf( __( 'If you enjoy using <strong>Opt-In Hound</strong>, please <a href="%s" target="_blank">leave us a ★★★★★ rating</a>. Big thank you for this!', 'social-pug' ), 'https://wordpress.org/support/view/plugin-reviews/opt-in-hound?rate=5#postform' );

		}

		return $text;

	}


}

// Let's get the party started
new Opt_In_Hound();
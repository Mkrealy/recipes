<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Include statistics files
 *
 */
function oih_include_feedback_files() {

	// AJAX functions
	if( file_exists( OIH_PLUGIN_DIR . 'includes/modules/feedback-form/functions-ajax.php' ) )
		include 'functions-ajax.php';

}
add_action( 'oih_include_files', 'oih_include_feedback_files', 10 );


/**
 * Enqueue admin scripts for the feedback form
 *
 */
function oih_enqueue_admin_scripts_feedback() {

	// Plugin styles
	wp_register_style( 'oih-style-feedback', OIH_PLUGIN_DIR_URL . 'includes/modules/feedback-form/assets/css/style-admin-feedback-form.css', array(), OIH_VERSION );
	wp_enqueue_style( 'oih-style-feedback' );

	// Plugin script
	wp_register_script( 'oih-script-feedback', OIH_PLUGIN_DIR_URL . 'includes/modules/feedback-form/assets/js/script-admin-feedback-form.js', array( 'jquery' ), OIH_VERSION );
	wp_enqueue_script( 'oih-script-feedback' );

}
add_action( 'oih_enqueue_admin_scripts', 'oih_enqueue_admin_scripts_feedback' );


/**
 * Outputs the feedback form in the admin footer
 *
 */
function oih_output_feedback_form() {

	if( empty( $_GET['page'] ) || false === strpos( $_GET['page'], 'oih' ) )
		return;

	include 'views/view-feedback-form.php';

}
add_action( 'admin_footer', 'oih_output_feedback_form' );
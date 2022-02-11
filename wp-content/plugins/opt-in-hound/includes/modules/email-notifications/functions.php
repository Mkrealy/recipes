<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Include integrations files
 *
 */
function oih_include_email_notifications_files() {

	// Include all available integration files
	$dirs = array_filter( glob( OIH_PLUGIN_DIR . 'includes/modules/email-notifications/available-email-notifications/*' ), 'is_dir' );
    
    foreach( $dirs as $dir ) {
        if( file_exists( $file =  $dir . '/functions.php' ) ){
            include ( $file );
        }
    }

    /**
	 * Helper hook to include files early in the email notifications module
	 *
	 */
    do_action( 'oih_include_files_email_notifications' );

}
add_action( 'oih_include_files', 'oih_include_email_notifications_files', 10 );


/**
 * Adds the Email Notifications tab to the plugin's Settings page
 *
 * @param array $settings_tabs
 *
 * @return array
 *
 */
function oih_submenu_page_settings_tabs_email_notifications( $settings_tabs = array() ) {

	$settings_tabs['email_notifications'] = __( 'Email Notifications', 'opt-in-hound' );

	return $settings_tabs;

}
add_filter( 'oih_submenu_page_settings_tabs', 'oih_submenu_page_settings_tabs_email_notifications', 30 );


/**
 * Adds the content of the Email Notifications tab in the Settings page
 *
 * @param array $settings
 *
 */
function oih_submenu_page_settings_tab_email_notifications( $settings = array() ) {

	include 'views/view-submenu-page-settings-tab-email-notifications.php';

}
add_action( 'oih_submenu_page_settings_tab_email_notifications', 'oih_submenu_page_settings_tab_email_notifications', 30 );


/**
 * Returns the available email notifications
 *
 * @return array
 *
 */
function oih_get_available_email_notifications() {

	/**
	 * Filter to dynamically add email notifications
	 *
	 * @param array
	 *
	 */
	$email_notifications = apply_filters( 'oih_available_email_notification', array() );

	$email_notifications = ( is_array( $email_notifications ) ? $email_notifications : array() );

	return $email_notifications;

}


/**
 * Returns the settings saved for the given email notification
 *
 * @param string $email_notification_slug
 *
 * @return array
 *
 */
function oih_get_email_notification_settings( $email_notification_slug = '' ) {

	if( empty( $email_notification_slug ) )
		return array();

	return get_option( 'oih_settings_email_notification_' . $email_notification_slug, array() );

}


/**
 * Returns the name of the settings option saved in the db
 *
 * @param string $email_notification_slug
 *
 * @return string
 *
 */
function oih_get_email_notification_settings_name( $email_notification_slug = '' ) {

	if( empty( $email_notification_slug ) )
		return '';

	return 'oih_settings_email_notification_' . $email_notification_slug;

}


/**
 * Registers the settings for the email notification
 *
 */
function oih_register_settings_email_notifications() {

	$email_notifications = oih_get_available_email_notifications();


	if( empty( $email_notifications ) )
		return;

	foreach( $email_notifications as $email_notification_slug => $email_notification_name )
		register_setting( 'oih_settings', 'oih_settings_email_notification_' . $email_notification_slug );

}
add_action( 'admin_init', 'oih_register_settings_email_notifications', 50 );


/**
 * Modifies the from_name from the wp_mail_from_name filter before sending an email
 *
 * @param string $from_name
 *
 */
function oih_email_notification_modify_from_name( $from_name ) {

	global $oih_send_email_notification_slug;

	if( is_null( $oih_send_email_notification_slug ) )
		return $from_name;

	// Get email notification settings
	$notification_settings = oih_get_email_notification_settings( $oih_send_email_notification_slug );

	if( empty( $notification_settings['from_name'] ) )
		return $from_name;

	// Set from name
	$from_name = sanitize_text_field( $notification_settings['from_name'] );

	return $from_name;

}


/**
 * Modifies the from_email from the wp_mail_from filter before sending an email
 *
 * @param string $from_email
 *
 */
function oih_email_notification_modify_from_email( $from_email ) {

	global $oih_send_email_notification_slug;

	if( is_null( $oih_send_email_notification_slug ) )
		return $from_email;

	// Get email notification settings
	$notification_settings = oih_get_email_notification_settings( $oih_send_email_notification_slug );

	if( empty( $notification_settings['from_email'] ) )
		return $from_email;

	if( ! is_email( $notification_settings['from_email'] ) )
		return $from_email;

	// Set from name
	$from_email = sanitize_text_field( $notification_settings['from_email'] );

	return $from_email;

}


/**
 * Modifies the email content type from the wp_mail_content_type filter before sending an email
 *
 */
function oih_email_notification_modify_email_content_type() {

	return apply_filters( 'oih_email_content_type', 'text/html' );

}
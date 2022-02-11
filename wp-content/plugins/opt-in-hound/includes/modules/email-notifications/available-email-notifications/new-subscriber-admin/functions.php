<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register the email notification sent to administrators when a new user subscribes
 *
 * @param array $email_notifications
 *
 * @return array
 *
 */
function oih_register_email_notification_new_subscriber_admin( $email_notifications = array() ) {

	$email_notifications['new_subscriber_admin'] = __( 'New Subscriber Admin Notification', 'opt-in-hound' );

	return $email_notifications;

}
add_filter( 'oih_available_email_notification', 'oih_register_email_notification_new_subscriber_admin', 10 );


/**
 * Add content to New Subscriber Admin Notification sub-tab of the Email Notifications tab
 *
 * @param array $settings
 *
 */
function oih_submenu_page_settings_tab_email_notification_sub_tab_new_subscriber_admin( $settings ) {

	echo '<div>';

		$settings     	  = oih_get_email_notification_settings( 'new_subscriber_admin' );
		$settings_name    = oih_get_email_notification_settings_name( 'new_subscriber_admin' );

		// Add explanation about the tags the user can use in the emails
		$tags_explanation = '<div>';

			$tags_explanation .= '<p>' . __( 'You can use the following tags in the email subject and email content to personalise your emails:', 'opt-in-hound' ) . '</p>';

			$tags_explanation .= '<ul>';
				$tags_explanation .= '<li>{{subscriber_email}} - ' . __( 'replaces the tag with the subscribers email address', 'opt-in-hound' ) . '</li>';
				$tags_explanation .= '<li>{{subscriber_first_name}} - ' . __( 'replaces the tag with the subscribers first name', 'opt-in-hound' ) . '</li>';
				$tags_explanation .= '<li>{{subscriber_last_name}} - ' . __( 'replaces the tag with the subscribers last name', 'opt-in-hound' ) . '</li>';
			$tags_explanation .= '</ul>';

		$tags_explanation .= '</div>';

		// Add the settings fields
		$settings_field = array(
			'name'	  => $settings_name,
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'    => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Enabled', 'opt-in-hound' ),
					'default' => 0
				),
				'admin_emails' => array(
					'name'    => 'admin_emails',
					'type'	  => 'text',
					'label'	  => __( 'Administrator emails', 'opt-in-hound' ),
					'desc'	  => __( 'Add a list of email addresses, separated by comma, that should receive an email notification when a new user subscribes to the email list.', 'opt-in-hound' )
				),
				'from_name'	=> array(
					'name'	  => 'from_name',
					'type'	  => 'text',
					'label'	  => __( 'From name', 'opt-in-hound' ),
					'input_class'	=> 'oih-medium'
				),
				'from_email' => array(
					'name'	  => 'from_email',
					'type'	  => 'text',
					'label'	  => __( 'From email', 'opt-in-hound' ),
					'input_class'	=> 'oih-medium'
				),
				'email_subject' => array(
					'name'	  => 'email_subject',
					'type'	  => 'text',
					'label'   => __( 'Email subject', 'opt-in-hound' ),
					'default' => __( 'Say Hello to a New Email Subscriber', 'opt-in-hound' )
				),
				'email_content' => array(
					'name'	  => 'email_content',
					'type'	  => 'editor',
					'label'	  => __( 'Email content', 'opt-in-hound' ),
					'default' => '<p>' . __( 'A new email subscriber just joined your list:', 'opt-in-hound' ) . '</p><p>' . __( '{{subscriber_first_name}} {{subscriber_last_name}} - {{subscriber_email}}', 'opt-in-hound' ) . '</p>',
					'editor_settings' => array( 'textarea_rows' => 9, 'editor_height' => 250 ),
					'content_after'	  => $tags_explanation
				)
			),
			'value' => $settings
		);
		
		oih_output_settings_field( $settings_field );

	echo '</div>';

}
add_action( 'oih_submenu_page_settings_tab_email_notification_sub_tab_new_subscriber_admin', 'oih_submenu_page_settings_tab_email_notification_sub_tab_new_subscriber_admin', 10 );


/**
 * Send an email notification to the admininstrators when a new user subscribes
 *
 * @param int   $subscriber_id
 * @param array $subscriber_data
 *
 */
function oih_send_email_notification_new_subscriber_admin( $subscriber_id = 0, $subsciber_data = array() ) {

	/**
	 * Verify email sending
	 *
	 */
	if( empty( $subscriber_id ) )
		return;

	if( empty( $subsciber_data ) )
		return;

	if( empty( $subsciber_data['source'] ) || $subsciber_data['source'] == 'manual' )
		return;

	$notification_settings = oih_get_email_notification_settings( 'new_subscriber_admin' );

	if( empty( $notification_settings['enabled'] ) )
		return;

	if( empty( $notification_settings['admin_emails'] ) )
		return;

	// Get admin emails as an array
	$admin_emails = array_filter( array_map( 'trim', explode( ',', $notification_settings['admin_emails'] ) ) );

	// Remove items that are not email addresses
	if( ! empty( $admin_emails ) ) {

		foreach( $admin_emails as $key => $value ) {
			if( ! is_email( $value ) )
				unset( $admin_emails[$key] );
		}

		$admin_emails = array_values( $admin_emails );

	}

	if( empty( $admin_emails ) )
		return;

	if( empty( $notification_settings['email_subject'] ) && empty( $notification_settings['email_content'] ) )
		return;


	/**
	 * Prepare email content
	 *
	 */
	$email_subject = ( ! empty( $notification_settings['email_subject'] ) ? sanitize_text_field( $notification_settings['email_subject'] ) : '' );
	$email_content = ( ! empty( $notification_settings['email_content'] ) ? $notification_settings['email_content'] : '' );

	$subscriber 		    = oih_get_subscriber_by_id( $subscriber_id );
	$merge_tags_subscribers = new OIH_Merge_Tags_Subscribers( _oih_prefix_array_keys( $subscriber->to_array(), 'subscriber_' ) );

	$email_subject = $merge_tags_subscribers->replace_tags( $email_subject );
	$email_content = $merge_tags_subscribers->replace_tags( $email_content );


	/**
	 * Send email
	 *
	 */
	global $oih_send_email_notification_slug;

	$oih_send_email_notification_slug = 'new_subscriber_admin';

	// Temporary change the from name and from email
    add_filter( 'wp_mail_from_name', 'oih_email_notification_modify_from_name', 999 );
    add_filter( 'wp_mail_from', 'oih_email_notification_modify_from_email', 999 );
    add_filter( 'wp_mail_content_type', 'oih_email_notification_modify_email_content_type', 999 );

    // Send email
    wp_mail( $admin_emails, $email_subject, wpautop( $email_content ) );

    // Reset the from name and email
    remove_filter( 'wp_mail_from_name', 'oih_email_notification_modify_from_name', 999 );
    remove_filter( 'wp_mail_from', 'oih_email_notification_modify_from_email', 999 );
    remove_filter( 'wp_mail_content_type', 'oih_email_notification_modify_email_content_type', 999 );

    $oih_send_email_notification_slug = null;

}
add_action( 'oih_insert_subscriber', 'oih_send_email_notification_new_subscriber_admin', 10, 2 );
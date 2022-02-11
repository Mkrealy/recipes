<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * AJAX callback to send the feedback
 *
 */
function oih_ajax_send_feedback() {

	if( empty( $_POST['oih_token'] ) || ! wp_verify_nonce( $_POST['oih_token'], 'oih_feedback_form' ) ) {
		echo 0;
		wp_die();
	}

	$_POST = stripslashes_deep( $_POST );

	if( empty( $_POST['user_email'] ) ) {
		echo 0;
		wp_die();
	}

	// Set headers
	$headers = array(
		"From: " . sanitize_email( $_POST['user_email'] ),
		"Reply-To: " . sanitize_email( $_POST['user_email'] ),
	);

	// Message type
	$message  = 'Type:';
    $message .= "\n";
    $message .= "---------------------------------------------------------";
    $message .= "\n";
    $message .= sanitize_text_field( $_POST['type'] );

	// Message content
    $message .= "\n\r";
    $message .= 'Message:';
    $message .= "\n";
    $message .= "---------------------------------------------------------";
    $message .= "\n";
    $message .= sanitize_text_field( $_POST['message'] );

    // Message user email
    $message .= "\n\r";
    $message .= 'User email:';
    $message .= "\n";
    $message .= "---------------------------------------------------------";
    $message .= "\n";
    $message .= sanitize_text_field( $_POST['user_email'] );


	// Send the email
	$sent = wp_mail( 'support@devpups.com', 'Optin Hound User Feedback', $message, $headers );

	// Return
	echo ( $sent ? 1 : 0 );
	wp_die();

}
add_action( 'wp_ajax_oih_ajax_send_feedback', 'oih_ajax_send_feedback' );
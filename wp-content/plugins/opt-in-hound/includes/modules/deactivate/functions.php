<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output deactivaton modal window code on Plugins page.
 * 
 */
function oih_deactivation_modal() {

    global $pagenow;

    if( ! is_admin() && $pagenow !== 'plugins.php' )
        return;

    $current_user = wp_get_current_user();

    if( ! ( $current_user instanceof WP_User ) )
        return;

    $email = trim( $current_user->user_email );
    
    include_once 'views/view-modal-deactivate.php';
}
add_filter( 'admin_footer', 'oih_deactivation_modal' );


/**
 * Ajax callback for sending deactivation email.
 * 
 */
function oih_send_deactivation_feedback() {

    if( isset( $_POST['data'] ) ) {
        parse_str( $_POST['data'], $form );
    }

    $message = '';
    
    $headers = array();

    $from = isset( $form['oih_disable_from'] ) ? sanitize_text_field( $form['oih_disable_from'] ) : '';

    if( $from ) {
        $headers[] = "From: " . $from;
        $headers[] = "Reply-To: " . $from;
    }
    
    $subject = "Opt-In Hound Deactivation Notification";
    
    $message .= isset( $form['oih_disable_reason'] ) ? 'Deactivation reason: ' . sanitize_text_field( $form['oih_disable_reason'] ) : '(no reason given)';
    
    if( isset( $form['oih_disable_text'] ) ) {
        $message .= "\n\r";
        $message .= 'Message: ' . sanitize_text_field( implode('', $form['oih_disable_text']) );
    }

    if( isset( $form['oih_contact_me'] ) ) {
        $message .= "\n\r";
        $message .= 'Contact me: Yes';
    } else {
        $message .= "\n\r";
        $message .= 'Contact me: No';
    }
    
    $success = wp_mail( array( 'support@devpups.com' ), $subject, $message, $headers );

    wp_die();
}
add_action( 'wp_ajax_oih_send_deactivation_feedback', 'oih_send_deactivation_feedback' );
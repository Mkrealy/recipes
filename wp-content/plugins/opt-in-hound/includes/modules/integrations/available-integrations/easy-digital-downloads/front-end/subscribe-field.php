<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Outputs the subscribe to newsletter checkbox at the bottom of Easy Digital Downloads
 * register form
 *
 */
function oih_edd_register_form_subscribe_field() {

    $integration_settings = oih_get_integration_settings( 'easy_digital_downloads' );

    if( empty( $integration_settings['enabled'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_message'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_subscriber_lists'] ) )
    	return;

    $checked = ( ! empty( $_POST['oih_subscribe'] ) || ( empty( $_POST ) && ! empty( $integration_settings['subscribe_checkbox_default_checked'] ) && $integration_settings['subscribe_checkbox_default_checked'] == 'yes' ) ? 'checked="checked"' : '' );

	echo '<div class="oih-subscribe-field-wrapper">';
		echo '<label>';
			echo '<input type="checkbox" name="oih_subscribe" value="1" ' . $checked . ' />';
			echo $integration_settings['subscribe_checkbox_message'];
		echo '</label>';
	echo '</div>';

}
add_action( 'edd_purchase_form_user_register_fields', 'oih_edd_register_form_subscribe_field' );


/**
 * Subscribe the user just after it was created
 *
 * @param array $posted
 * @param array $user_data
 *
 */
function oih_edd_register_form_subscribe_user( $posted = array(), $user_data = array() ) {

	if( empty( $_POST['oih_subscribe'] ) )
		return;

	$integration_settings = oih_get_integration_settings( 'easy_digital_downloads' );

    if( empty( $integration_settings['enabled'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_subscriber_lists'] ) )
    	return;

	if( empty( $user_data ) )
		return;

	if( ! is_array( $user_data ) )
		return;

	if( empty( $user_data['email'] ) )
		return;

	$subscriber_data = array(
        'email'      => ( ! empty( $user_data['email'] ) ? $user_data['email'] : '' ),
        'first_name' => ( ! empty( $user_data['first_name'] ) ? $user_data['first_name'] : '' ),
        'last_name'  => ( ! empty( $user_data['last_name'] )  ? $user_data['last_name']  : '' ),
        'ip_address' => oih_get_user_ip_address(),
        'date'       => date( 'Y-m-d H:i:s' ),
        'source'  	 => 'easy_digital_downloads_register'
    );

    // Insert the subscriber in each list
    oih_insert_subscriber_in_lists( $integration_settings['subscribe_checkbox_subscriber_lists'], $subscriber_data );

}
add_action( 'edd_checkout_before_gateway', 'oih_edd_register_form_subscribe_user', 10, 2 );
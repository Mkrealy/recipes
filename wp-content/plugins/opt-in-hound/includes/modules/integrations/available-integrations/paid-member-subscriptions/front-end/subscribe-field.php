<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Outputs the subscribe to newsletter checkbox at the bottom of Paid Member Subscriptions
 * register form
 *
 */
function oih_pms_register_form_subscribe_field() {

    $integration_settings = oih_get_integration_settings( 'paid_member_subscriptions' );

    if( empty( $integration_settings['enabled'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_message'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_subscriber_lists'] ) )
    	return;

    $checked = ( ! empty( $_POST['oih_subscribe'] ) || ( empty( $_POST ) && ! empty( $integration_settings['subscribe_checkbox_default_checked'] ) && $integration_settings['subscribe_checkbox_default_checked'] == 'yes' ) ? 'checked="checked"' : '' );

	echo '<li class="pms-field">';
		echo '<label>';
			echo '<input type="checkbox" name="oih_subscribe" value="1" ' . $checked . ' />';
			echo $integration_settings['subscribe_checkbox_message'];
		echo '</label>';
	echo '</li>';

}
add_action( 'pms_register_form_after_fields', 'oih_pms_register_form_subscribe_field' );


/**
 * Subscribe the user just after it was created
 *
 * @param array $user_data
 *
 */
function oih_pms_register_form_subscribe_user( $user_data = array() ) {

	if( empty( $_POST['oih_subscribe'] ) )
		return;
	
	$integration_settings = oih_get_integration_settings( 'paid_member_subscriptions' );

    if( empty( $integration_settings['enabled'] ) )
    	return;

    if( empty( $integration_settings['subscribe_checkbox_subscriber_lists'] ) )
    	return;

	if( empty( $user_data ) )
		return;

	if( ! is_array( $user_data ) )
		return;

	if( empty( $user_data['user_email'] ) )
		return;

	$subscriber_data = array(
        'email'      => ( ! empty( $user_data['user_email'] ) ? $user_data['user_email'] : '' ),
        'first_name' => ( ! empty( $user_data['first_name'] ) ? $user_data['first_name'] : '' ),
        'last_name'  => ( ! empty( $user_data['last_name'] )  ? $user_data['last_name']  : '' ),
        'ip_address' => oih_get_user_ip_address(),
        'date'       => date( 'Y-m-d H:i:s' ),
        'source'  	 => 'paid_member_subscriptions_register'
    );

    // Insert the subscriber in each list
    oih_insert_subscriber_in_lists( $integration_settings['subscribe_checkbox_subscriber_lists'], $subscriber_data );

}
add_action( 'pms_register_form_after_create_user', 'oih_pms_register_form_subscribe_user' );
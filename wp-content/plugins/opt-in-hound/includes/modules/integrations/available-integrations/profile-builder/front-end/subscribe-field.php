<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Handle field output
 *
 */
function oih_wppb_subscribe_field_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){

    $integration_settings = oih_get_integration_settings( 'profile_builder' );

    if( empty( $integration_settings['enabled'] ) )
        return $output;

    if( $field['field'] == 'Opt-In Hound Subscribe' ) {

        if( empty( $field['oih-subscribe-subscriber-lists'] ) )
            return $output;

        $item_title       = apply_filters( 'wppb_' . $form_location . '_opt_in_hound_subscribe_custom_field_' . $field['id'] . '_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_' . $field['id'] . '_title_translation', $field['field-title'] ) );
        $item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_' . $field['id'] . '_description_translation', $field['description'] );
        
        $input_value      = 1;

        if( $form_location == 'register' ) {

            $checked     = '';

            // Check the checkbox if there is a value
            if( ! empty( $request_data['custom_field_opt_in_hound_subscribe_' . $field['id']] ) || ( ! empty( $field['oih-subscribe-default-checked'] ) && $field['oih-subscribe-default-checked'] == 'yes' ) )
                $checked = 'checked="checked"';

            $output  = '<label for="custom_field_opt_in_hound_subscribe_' . $field['id'] . '">';

            $output .= '<input name="custom_field_opt_in_hound_subscribe_' . $field['id'] . '" id="custom_field_opt_in_hound_subscribe_' . $field['id'] . '" type="checkbox" value="' . $input_value . '" ' . $checked . ' />';

            $output .= ( ! empty( $field['oih-subscribe-message'] ) ? $field['oih-subscribe-message'] : '' ) . '</label>';

        }

        return apply_filters( 'wppb_' . $form_location . '_opt_in_hound_subscribe_custom_field_' . $field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );

    }

}
add_filter( 'wppb_output_form_field_opt-in-hound-subscribe', 'oih_wppb_subscribe_field_handler', 10, 6 );


/**
 * Handle field save
 *
 */
function oih_wppb_subscribe_field_save( $field, $user_id, $request_data, $form_location ) {

    if( $form_location != 'register' )
        return;

    if( $field['field'] != 'Opt-In Hound Subscribe' )
        return;

    if( empty( $request_data['custom_field_opt_in_hound_subscribe_' . $field['id']] ) )
        return;

    if( empty( $field['oih-subscribe-subscriber-lists'] ) )
        return;

    $subscriber_lists = array_map( 'trim', explode( ',', $field['oih-subscribe-subscriber-lists'] ) );
    
    if( empty( $subscriber_lists ) )
        return;

    $user_data = get_userdata( $user_id );

    if( ! $user_data )
        return;

    $subscriber_data = array(
        'email'      => $user_data->user_email,
        'first_name' => $user_data->first_name,
        'last_name'  => $user_data->last_name,
        'ip_address' => oih_get_user_ip_address(),
        'date'       => date( 'Y-m-d H:i:s' ),
        'source'     => 'profile_builder_register'
    );

    // Insert the subscriber in each list
    oih_insert_subscriber_in_lists( $subscriber_lists, $subscriber_data );
    
}
add_action( 'wppb_save_form_field', 'oih_wppb_subscribe_field_save', 10, 4 );


/**
 * For e-mail confirmation we will store the value of the subscribe field so that
 * we know the user wishes to subscribe
 *
 */
function oih_wppb_add_to_user_signup_form_meta_subscribe_field( $meta, $global_request ) {

    $wppb_manage_fields = get_option( 'wppb_manage_fields', array() );

    if( !empty( $wppb_manage_fields ) ) {

        foreach( $wppb_manage_fields as $field ) {

            if( $field['field'] == 'Opt-In Hound Subscribe' && ! empty( $global_request[ 'custom_field_opt_in_hound_subscribe_' . $field['id'] ] ) ) {
                $meta['custom_field_opt_in_hound_subscribe_' . $field['id'] ] = trim( $global_request[ 'custom_field_opt_in_hound_subscribe_' . $field['id'] ] );
            }

        }

    }

    return $meta;

}
add_filter( 'wppb_add_to_user_signup_form_meta', 'oih_wppb_add_to_user_signup_form_meta_subscribe_field', 10 , 2 );


/**
 * Subscribe user to the list when the user becomes active
 *
 */
function oih_wppb_activate_user_subscribe_field( $user_id, $password, $meta ) {

    // Get all fields in manage fields
    $wppb_manage_fields = get_option( 'wppb_manage_fields', array() );

    if( ! empty( $wppb_manage_fields ) ) {

        foreach( $wppb_manage_fields as $field ) {

            if( $field['field'] == 'Opt-In Hound Subscribe' && ! empty( $meta[ 'custom_field_opt_in_hound_subscribe_' . $field['id'] ] ) ) {

                if( empty( $field['oih-subscribe-subscriber-lists'] ) )
                    continue;

                $subscriber_lists = array_map( 'trim', explode( ',', $field['oih-subscribe-subscriber-lists'] ) );

                if( empty( $subscriber_lists ) )
                    continue;

                $user_data = get_userdata( $user_id );

                if( ! $user_data )
                    continue;

                $subscriber_data = array(
                    'email'      => $user_data->user_email,
                    'first_name' => $user_data->first_name,
                    'last_name'  => $user_data->last_name,
                    'ip_address' => oih_get_user_ip_address(),
                    'date'       => date( 'Y-m-d H:i:s' ),
                    'source'     => 'profile_builder_register'
                );

                // Insert the subscriber in each list
                oih_insert_subscriber_in_lists( $subscriber_lists, $subscriber_data );

            }

        }

    }
}
add_action( 'wppb_activate_user', 'oih_wppb_activate_user_subscribe_field', 10, 3 );
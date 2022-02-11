<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Function that ads the Subscribe field to the fields list
 * and also the list of fields that skip the meta-name check
 *
 * @param array $fields - The names of all the fields
 *
 * @return array
 *
 */
function oih_wppb_manage_field_types( $fields ) {

    $fields[] = 'Opt-In Hound Subscribe';

    return $fields;

}
add_filter( 'wppb_manage_fields_types', 'oih_wppb_manage_field_types' );
add_filter( 'wppb_skip_check_for_fields', 'oih_wppb_manage_field_types' );


/**
 * Adds custom options to the field properties from Manage Fields
 *
 * @param array $fields - The current field properties
 *
 * @return array
 *
 */
function oih_wppb_manage_fields( $fields ) {

    // Set the lists
    $subscriber_lists = array();
    $lists            = oih_get_lists();

    foreach( $lists as $list ) {

        $subscriber_lists[] = '%' . $list->get('name') . '%' . $list->get('id');

    }

    $fields[] = array( 'type' => 'text', 'slug' => 'oih-subscribe-message', 'title' => __( 'Checkbox label message', 'profile-builder' ), 'description' => __( 'This message will be displayed next to the subscribe checkbox.', 'profile-builder' ) );
    $fields[] = array( 'type' => 'select', 'slug' => 'oih-subscribe-default-checked', 'title' => __( 'Checked by default', 'opt-in-hound' ), 'options' => array( '%No%no', '%Yes%yes' ), 'description' => __( 'Choose whether the subscribe checkbox is checked by default.', 'opt-in-hound' ) );
    $fields[] = array( 'type' => 'checkbox', 'slug' => 'oih-subscribe-subscriber-lists', 'title' => __( 'Subscriber lists', 'opt-in-hound' ), 'options' => $subscriber_lists, 'description' => __( 'Select the subscriber lists where you wish to add users that subscribe through this field.', 'opt-in-hound' ) );
    
    return $fields;
}
add_filter( 'wppb_manage_fields', 'oih_wppb_manage_fields' );


/**
 * Remove the Opt-In Hound Subscribe field from Profile Builder's Edit Profile forms
 *
 * @param array $ep_fields
 *
 * @return array
 *
 */
function oih_wppb_epf_fields_types_remove_subscribe_field( $ep_fields = array() ) {

    if( empty( $ep_fields ) )
        return array();

    foreach( $ep_fields as $key => $ep_field ) {

        if( false !== strpos( $ep_field, 'Opt-In Hound Subscribe' ) )
            unset( $ep_fields[$key] );

    }

    $ep_fields = array_values( $ep_fields );

    return $ep_fields;

}
add_filter( 'wppb_epf_fields_types', 'oih_wppb_epf_fields_types_remove_subscribe_field' );


/**
 * Remove the Opt-In Hound Subscribe field from Profile Builder's Edit Profile forms when first
 * adding them to a new Edit Profile form custom post type
 *
 * @param array $ep_fields
 *
 * @return array
 *
 */
function option_wppb_manage_fields_epf_remove_subscribe_field( $wppb_manage_fields = array() ) {

    if( empty( $wppb_manage_fields ) )
        return array();

    if( empty( $_GET['post_type'] ) )
        return $wppb_manage_fields;

    if( $_GET['post_type'] != 'wppb-epf-cpt' )
        return $wppb_manage_fields;

    foreach( $wppb_manage_fields as $key => $field ) {

        if( $field['field'] == 'Opt-In Hound Subscribe' )
            unset( $wppb_manage_fields[$key] );

    }

    $wppb_manage_fields = array_values( $wppb_manage_fields );

    return $wppb_manage_fields;

}
add_filter( 'option_wppb_manage_fields', 'option_wppb_manage_fields_epf_remove_subscribe_field' );


/**
 * Function that removes the field from the user-listing moustache variables
 *
 */
function oih_wppb_strip_moustache_var( $wppb_manage_fields ) {

    if( is_array( $wppb_manage_fields ) ) {
        foreach( $wppb_manage_fields as $key => $field ) {
            if( $field['field'] == 'Opt-In Hound Subscribe' ) {
                unset( $wppb_manage_fields[$key] );
            }
        }
    }

    return $wppb_manage_fields;
}
add_filter( 'wppb_userlisting_merge_tags', 'oih_wppb_strip_moustache_var' );
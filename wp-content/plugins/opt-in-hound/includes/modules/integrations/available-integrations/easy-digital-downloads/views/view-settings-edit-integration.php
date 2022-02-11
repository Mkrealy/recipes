<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$settings     	  = oih_get_integration_settings( $integration_slug );
$settings_name    = oih_get_integration_settings_name( $integration_slug );

// Set the lists
$subscriber_lists = array();
$lists 			  = oih_get_lists();

foreach( $lists as $list ) {

	$subscriber_lists[ $list->get('id') ] = $list->get('name');

}

$settings_field = array(
	'name'	  => $settings_name,
	'type'	  => 'fields_collection',
	'fields'  => array(
		'enabled' => array(
			'name'    => 'enabled',
			'type'	  => 'switch',
			'label'	  => __( 'Integration Enabled', 'opt-in-hound' ),
			'default' => 0
		),
		'subscribe_checkbox_heading' => array(
			'default' => '<h4>' . __( 'Register Form Subscribe Checkbox', 'opt-in-hound' ) . '</h4>',
			'type' 	  => 'heading'
		),
		'subscribe_checkbox_message' => array(
			'name'    => 'subscribe_checkbox_message',
			'type'	  => 'text',
			'label'	  => __( 'Checkbox label message', 'opt-in-hound' ),
			'default' => __( 'Subscribe to our newsletter!', 'opt-in-hound' ),
		),
		'subscribe_checkbox_default_checked' => array(
			'name'    => 'subscribe_checkbox_default_checked',
			'type'	  => 'select',
			'label'	  => __( 'Checked by default', 'opt-in-hound' ),
			'default' => 'no',
			'options' => array(
				'no'  => __( 'No', 'opt-in-hound' ),
				'yes' => __( 'Yes', 'opt-in-hound' )
			)
		),
		'subscribe_checkbox_subscriber_lists' => array(
			'name'	  => 'subscribe_checkbox_subscriber_lists',
			'type'	  => 'select_multiple',
			'label'	  => __( 'Subscriber lists', 'opt-in-hound' ),
			'options' => $subscriber_lists,
			'desc'	  => __( 'Select the subscriber lists where you wish to add users that subscribe through this integration.', 'opt-in-hound' )
		)
	),
	'value'   => $settings
);
?>

<?php 
	oih_output_settings_field( $settings_field );
?>
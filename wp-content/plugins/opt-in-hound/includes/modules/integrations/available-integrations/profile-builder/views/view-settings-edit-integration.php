<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$settings     	  = oih_get_integration_settings( $integration_slug );
$settings_name    = oih_get_integration_settings_name( $integration_slug );

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
		)
	),
	'value'   => $settings
);
?>

<?php 
	oih_output_settings_field( $settings_field );

	echo sprintf( __( "To add custom checkboxes into Profile Builder's register forms please navigate to %sProfile Builder -> Manage Fields%s and add the custom Opt-In Hound Subscribe field to your fields list.", 'opt-in-hound' ), '<a href="' . add_query_arg( array( 'page' => 'manage-fields' ), admin_url( 'admin.php' ) ) . '">', '</a>' );

	echo '<br /><br />';
?>
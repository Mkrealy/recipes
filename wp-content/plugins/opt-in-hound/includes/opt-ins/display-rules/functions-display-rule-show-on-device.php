<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add opt-in "show on device" display rule
 *
 * @param array  $opt_in_type_settings_display_rules
 * @param string $opt_in_type
 *
 * @return array
 *
 */
function oih_opt_in_types_settings_display_rule_show_on_device( $opt_in_type_settings_display_rules = array(), $opt_in_type ) {

	if( empty( $opt_in_type_settings_display_rules ) )
		return array();

	if( ! in_array( $opt_in_type, array( 'pop_up', 'fly_in', 'floating_bar' ) ) )
		return $opt_in_type_settings_display_rules;

	// User status
	$opt_in_type_settings_display_rules['display_rule_on_device'] = array(
		'name'	  => 'display_rule_on_device',
		'type'	  => 'select',
		'label'	  => __( 'Show on Device', 'opt-in-hound' ),
		'options' => array(
			'all'  	  => __( 'All Devices', 'opt-in-hound' ),
			'mobile'  => __( 'Mobile Only', 'opt-in-hound' ),
			'desktop' => __( 'Desktop Only', 'opt-in-hound' )
		)
	);

	return $opt_in_type_settings_display_rules;

}
add_filter( 'oih_opt_in_type_settings_display_rules', 'oih_opt_in_types_settings_display_rule_show_on_device', 100, 2 );


/**
 * Adds the display option for mobile to the trigger data of the opt-in outputter
 *
 * This should have been added to the opt-in extra data attributes, but it makes a bit more sense
 * for it to be here
 *
 * @param array  	 $trigger_data
 * @param OIH_Opt_In $opt_in
 *
 * @return array
 *
 */
function oih_opt_in_outputter_trigger_data_show_on_device( $trigger_data = array(), $opt_in = null ) {

	if( is_null( $opt_in ) )
		return $trigger_data;

	$opt_in_options = $opt_in->get('options');

	if( empty( $opt_in_options['display_rule_on_device'] ) || $opt_in_options['display_rule_on_device'] == 'all' )
		return $trigger_data;

	$trigger_data['show-on-device'] = $opt_in_options['display_rule_on_device'];

	return $trigger_data;

}
add_filter( 'oih_opt_in_outputter_trigger_data_attributes', 'oih_opt_in_outputter_trigger_data_show_on_device', 10, 2 );
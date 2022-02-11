<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include opt-in files
 *
 */
function oih_include_opt_in_files() {

	// Include all opt-in types
	$dirs = array_filter( glob( OIH_PLUGIN_DIR . 'includes/opt-ins/types/*' ), 'is_dir' );

    foreach( $dirs as $dir ) {
        if( file_exists( $file =  $dir . '/' . basename($dir) . '.php') ){
            include_once ( $file );
        }
    }

    // Include opt-in display rules
    if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/class-display-rule-validator-factory.php' ) )
		require OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/class-display-rule-validator-factory.php';

	if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/interface-display-rule-validator.php' ) )
		require OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/interface-display-rule-validator.php';

	if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/class-display-rule-validator-abstract.php' ) )
		require OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/class-display-rule-validator-abstract.php';
	
    $files = array_reverse( array_filter( glob( OIH_PLUGIN_DIR . 'includes/opt-ins/display-rules/*' ), 'is_file' ) );
	
    foreach( $files as $file ) {
        include_once ( $file );
    }

}
add_action( 'oih_include_files', 'oih_include_opt_in_files' );


/**
 * Returns the available opt-in type forms
 *
 * @return array
 *
 */
function oih_get_opt_in_types() {

	/**
	 * Filter to dynamically add opt-in types
	 *
	 * @param array
	 *
	 */
	$opt_in_types = apply_filters( 'oih_opt_in_types', array() );

	$opt_in_types = ( is_array( $opt_in_types ) ? $opt_in_types : array() );

	return $opt_in_types;

}


/**
 * Returns the default settings array for a given opt-in type
 *
 * @param string $opt_in_type
 *
 * @return array
 *
 */
function oih_get_opt_in_type_settings( $opt_in_type = '' ) {

	if( empty( $opt_in_type ) )
		return array();

	/**
	 * Filter to dynamically add the settings for the opt-in type
	 *
	 * @param array
	 *
	 */
	$opt_in_types_settings = apply_filters( 'oih_opt_in_types_settings', array() );

	if( ! empty( $opt_in_types_settings[$opt_in_type] ) && is_array( $opt_in_types_settings[$opt_in_type] ) )
		return $opt_in_types_settings[$opt_in_type];

	return array();

}


/**
 * Returns the sections for the add new / edit settings page of the opt-ins
 *
 * @return array
 *
 */
function oih_get_opt_in_settings_sections() {

	$sections = array(
		'general' => array(
			'label' 	=> __( 'General', 'opt-in-hound' ),
			'dashicon'	=> 'admin-generic'
		),
		'content_style' => array(
			'label' 	=> __( 'Content &amp; Design', 'opt-in-hound' ),
			'dashicon'  => 'admin-customizer'
		),
		'display' => array(
			'label' 	=> __( 'Display Options', 'opt-in-hound' ),
			'dashicon'  => 'visibility'
		)
	);

	/**
	 * Filter to add custom sections if needed
	 *
	 */
	$sections = apply_filters( 'oih_get_opt_in_settings_sections', $sections );

	if( empty( $sections ) )
		$sections = array();

	return $sections;

}


/**
 * Register the opt-in source names for the subscriber source
 *
 * @param array  $source_names
 * @param string $source_slug
 *
 * @return array
 *
 */
function oih_subscriber_source_names_opt_in( $source_names = array(), $source_slug = '' ) {

	if( false !==  strpos( $source_slug, 'opt_in_' ) ) {

		$opt_in_id = (int)str_replace( 'opt_in_' , '', $source_slug );

		$source_names = array(
			'short_name' => '#' . $opt_in_id,
			'long_name'  => __( 'Opt-In', 'opt-in-hound' ) . ' #' . $opt_in_id
		);

	}

	return $source_names;

}
add_filter( 'oih_subscriber_source_names', 'oih_subscriber_source_names_opt_in', 10, 2 );
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Returns the available sources for a subscriber
 *
 * @return array
 *
 */
function oih_get_subscriber_source_names( $source_slug = '' ) {

	/**
	 * Filter to dynamically add a short name and a long name to the
	 * given source slug
	 *
	 * @param array
	 *
	 */
	$source_names = apply_filters( 'oih_subscriber_source_names', array( 'short_name' => '', 'long_name' => '' ), $source_slug );

	$source_names = ( is_array( $source_names ) ? $source_names : array( 'short_name' => '', 'long_name' => '' ) );

	return $source_names;

}


/**
 * Register the manual source names for the subscriber source
 *
 * @param array  $source_names
 * @param string $source_slug
 *
 * @return array
 *
 */
function oih_subscriber_source_names_manual( $source_names = array(), $source_slug = '' ) {

	if( $source_slug != 'manual' )
		return $source_names;

	$source_names = array(
		'short_name' => __( 'Manual', 'opt-in-hound' ),
		'long_name'  => __( 'Manual', 'opt-in-hound' )
	);

	return $source_names;

}
add_filter( 'oih_subscriber_source_names', 'oih_subscriber_source_names_manual', 10, 2 );
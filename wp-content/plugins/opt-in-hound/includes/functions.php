<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Because certain widgets / plugins reset the global $post variable
 * we are going to cache it when WP has just loaded, so that we have the
 * original post available at all times
 *
 */
function oih_cache_post_object() {

	global $oih_cache_wp_post;

	$oih_cache_wp_post = null;

	if( is_singular() )	{

		global $post;
		$oih_cache_wp_post = $post;

	}
	
}
add_action( 'wp', 'oih_cache_post_object' );


/**
 * Adds details about the page being displayed in the front-end as a JS variable
 *
 */
function oih_enqueue_front_end_scripts_current_page_data() {

	global $oih_cache_wp_post;

	// Set the post data
	if( ! is_null( $oih_cache_wp_post ) && is_a( $oih_cache_wp_post, 'WP_Post' ) ) {

		$object_id   = (int)$oih_cache_wp_post->ID;
		$object_type = $oih_cache_wp_post->post_type;

	} else {

		$object_id   = 0;
		$object_type = '';

	}

	// Set if is homepage
	$is_home = ( is_front_page() ? '1' : '' );

	$page_data = "
		var oih_current_page_data = {
			'object_id'   : '" . esc_attr( $object_id ) . "',
			'object_type' : '" . esc_attr( $object_type ) . "',
			'is_home'	  : '" . $is_home . "'
		};
	";
	
	wp_add_inline_script( 'oih-script', $page_data, 'before' );

}
add_action( 'oih_enqueue_front_end_scripts', 'oih_enqueue_front_end_scripts_current_page_data' );
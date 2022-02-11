<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Displays the HTML of the plugin admin header
 *
 */
function oih_admin_header() {

	//$page = ( isset( $_GET['page'] ) && strpos( $_GET['page'], 'oih' ) !== false ? trim( $_GET['page'] ) : '' );

	echo '<div class="oih-page-header">';
		echo '<span class="oih-logo">Opt-In Hound <span>' . ucfirst( OIH_VERSION_TYPE ) . '</span></span>';
		echo '<small>v.' . OIH_VERSION . '</small>';

		echo '<nav>';
			echo '<a href="http://docs.devpups.com/opt-in-hound/installing-the-plugin/" target="_blank"><i class="dashicons dashicons-book"></i>' . __( 'Documentation', 'opt-in-hound' ) . '</a>';
			//echo '<a href="https://wordpress.org/support/view/plugin-reviews/opt-in-hound?filter=5#postform" target="_blank">5<i class="dashicons dashicons-star-filled"></i>Leave a Review</a>';

			if( OIH_VERSION_TYPE == 'free' )
				echo '<a id="oih-to-premium" href="http://www.devpups.com/opt-in-hound/?utm_source=plugin&utm_medium=header-to-premium&utm_campaign=opt-in-hound" target="_blank"><i class="dashicons dashicons-external"></i>' . __( 'Upgrade to Pro', 'opt-in-hound' ) . '</a>';

		echo '</nav>';

	echo '</div>';

}


/**
 * Add admin notice on plugin activation
 *
 */
function oih_admin_notice_first_activation() {

	// Get first activation of the plugin
	$first_activation = get_option( 'oih_first_activation', '' );

	if( empty( $first_activation ) )
		return;

	// Do not display this notice if user cannot activate plugins
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	// Do not display this notice if plugin has been activated for more than 3 minutes
	if( time() - 3 * MINUTE_IN_SECONDS >= $first_activation )
		return;

	// Do not display this notice for users that have dismissed it
	if( get_user_meta( get_current_user_id(), 'oih_admin_notice_first_activation', true ) != '' )
		return;

	// Echo the admin notice
	echo '<div class="oih-admin-notice oih-admin-notice-activation notice notice-info">';

    	echo '<h4>' . __( 'Thank you for installing Opt-In Hound. Let\'s start growing your email subscriber list.', 'opt-in-hound' ) . '</h4>';

    	echo '<a class="oih-admin-notice-link" href="' . add_query_arg( array( 'oih_admin_notice_activation' => 1 ), admin_url( 'admin.php?page=oih-opt-in-forms' ) ) . '"><span class="dashicons dashicons-admin-settings"></span>' . __( 'Go to the Plugin', 'opt-in-hound' ) . '</a>';

    	if( OIH_VERSION_TYPE == 'free' )
    		echo '<a class="oih-admin-notice-link" href="https://www.devpups.com/opt-in-hound/?utm_source=plugin&utm_medium=plugin-activation&utm_campaign=opt-in-hound" target="_blank"><span class="dashicons dashicons-external"></span>' . __( 'Upgrade to Pro', 'opt-in-hound' ) . '</a>';

    	echo '<a href="' . add_query_arg( array( 'oih_admin_notice_activation' => 1 ) ) . '" type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>';

    echo '</div>';

}
add_action( 'admin_notices', 'oih_admin_notice_first_activation' );


/**
 * Handle admin notices dismissals
 *
 */
function oih_admin_notice_dismiss() {

	if( isset( $_GET['oih_admin_notice_activation'] ) )
		add_user_meta( get_current_user_id(), 'oih_admin_notice_first_activation', 1, true );

}
add_action( 'admin_init', 'oih_admin_notice_dismiss' );
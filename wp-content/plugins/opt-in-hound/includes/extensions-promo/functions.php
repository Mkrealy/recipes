<?php


/**
 * Include pro extensions promo files
 *
 */
function oih_include_extensions_promo_files() {

	if( file_exists( OIH_PLUGIN_DIR . 'includes/extensions-promo/class-submenu-page-extensions.php' ) )
		include 'class-submenu-page-extensions.php';	

}
add_action( 'oih_include_files', 'oih_include_extensions_promo_files', 10 );


/**
 * Include pro scripts promo files
 *
 */
function oih_enqueue_admin_scripts_promo_files() {

	// Plugin styles
	wp_register_style( 'oih-style-promo', OIH_PLUGIN_DIR_URL . 'includes/extensions-promo/assets/css/style-admin-opt-in-hound-promo.css', array(), OIH_VERSION );
	wp_enqueue_style( 'oih-style-promo' );

	// Plugin script
	wp_register_script( 'oih-script-promo', OIH_PLUGIN_DIR_URL . 'includes/extensions-promo/assets/js/script-admin-opt-in-hound-promo.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-datepicker' ), OIH_VERSION );
	wp_enqueue_script( 'oih-script-promo' );

}
add_action( 'oih_enqueue_admin_scripts', 'oih_enqueue_admin_scripts_promo_files' );


/**
 * Register the WooCommerce Promo integration
 *
 */
function oih_register_available_integration_woocommerce_promo( $integrations = array() ) {

	if( ! is_array( $integrations ) )
		return array();

	if( ! empty( $integrations['woocommerce'] ) )
		return $integrations;

	$integrations['woocommerce'] = array(
		'name' 		   => 'WooCommerce',
		'description'  => sprintf( __( 'Subscribe users from your WooCommerce checkout. Show pop-up and fly-in opt-ins on WooCommerce product pages. %sAvailable in the Pro version.%s', 'opt-in-hound' ), '<a target="_blank" href="https://devpups.com/opt-in-hound/">', '</a>' ),
		'has_settings' => 0
	);

	return $integrations;

}
add_filter( 'oih_available_integrations', 'oih_register_available_integration_woocommerce_promo', 10 );


/**
 * Register promo for more opt-in types
 *
 * @param array $opt_in_types
 *
 */
function oih_register_opt_in_types_promo( $opt_in_types = array() ) {

	if( ! is_array( $opt_in_types ) )
		return array();

	if( OIH_VERSION_TYPE != 'free' )
		return $opt_in_types;

	$opt_in_types['after_content_promo'] = array(
		'name'  => __( 'After Content', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-after-content.png'
	);

	$opt_in_types['fly_in_promo'] = array(
		'name'  => __( 'Fly-In', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-fly-in.png'
	);

	$opt_in_types['shortcode_promo'] = array(
		'name'  => __( 'Shortcode', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-shortcode.png'
	);

	$opt_in_types['floating_bar_promo'] = array(
		'name' 	=> __( 'Floating Bar', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-floating-bar.png'
	);

	return $opt_in_types;

}
add_filter( 'oih_opt_in_types', 'oih_register_opt_in_types_promo', 21 );

/**
 * Adds a promo pop-up for the opt-in types
 *
 */
function oih_admin_footer_add_promo_pop_up_opt_in_type_after_content() {

	include 'views/view-promo-pop-up-opt-in-types.php';

}
add_action( 'admin_footer', 'oih_admin_footer_add_promo_pop_up_opt_in_type_after_content' );


/**
 * Register "Misc" in the settings page
 *
 */
function oih_submenu_page_settings_tabs_misc( $settings_tabs = array() ) {

	if( ! isset( $settings_tabs['misc'] ) )
		$settings_tabs['misc'] = __( 'Misc', 'opt-in-hound' );

	return $settings_tabs;

}
add_filter( 'oih_submenu_page_settings_tabs', 'oih_submenu_page_settings_tabs_misc', 100 );


/**
 * Add the "Hide attribution links" switch field
 *
 * @param array $settings
 *
 */
function oih_submenu_page_settings_tab_misc_attribution_links( $settings ) {

	echo '<div>';

		$settings_field = array(
			'name'	  => 'oih_settings',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'hide_attribution_links' => array(
					'name'    => 'hide_attribution_links',
					'type'	  => 'switch',
					'label'	  => __( 'Hide attribution links', 'opt-in-hound' ),
					'default' => 0
				)
			),
			'value' => $settings
		);

		oih_output_settings_field( $settings_field );

	echo '</div>';

}
add_action( 'oih_submenu_page_settings_tab_misc', 'oih_submenu_page_settings_tab_misc_attribution_links', 100 );


/**
 * Add admin notice on plugin activation
 *
 */
function oih_admin_notice_added_attribution_links() {

	// Get first activation of the plugin
	$first_activation = get_option( 'oih_first_activation', '' );

	if( empty( $first_activation ) )
		return;

	// Display the notice only if the plugin has been activated for 10 minutes
	if( $first_activation + 10 * MINUTE_IN_SECONDS > time() )
		return;

	// Do not display this notice if user cannot activate plugins
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	// Do not display this notice it has been dismissed already
	if( get_option( 'oih_admin_notice_attribution_links', '' ) != '' )
		return;

	// Echo the admin notice
	echo '<div class="oih-admin-notice oih-admin-notice-activation notice notice-info">';

    	echo '<p><strong>' . __( "The free version of Opt-In Hound now adds attribution links at the bottom of each opt-in form to help spread the word about the plugin.", 'opt-in-hound' ) . '</strong></p>';
    	echo '<p><strong>' . __( "These links are optional, you can hide them if you want, but if you wish to help us you can leave them enabled. ", 'opt-in-hound' ) . '</strong></p>';

    	echo '<p>';
    		echo '<a href="' . add_query_arg( array( 'oih_admin_notice_attribution_links' => 1 ) ) . '" class="button button-primary" style="margin-right: 10px;">' . __( 'Display Attribution Links', 'opt-in-hound' ) . '</a>';
    		echo '<a href="' . add_query_arg( array( 'oih_admin_notice_attribution_links' => 1, 'oih_admin_notice_attribution_links_hide' => 1 ) ) . '" class="button">' . __( 'Hide Attribution Links', 'opt-in-hound' ) . '</a>';
    	echo '</p>';

    echo '</div>';

}
add_action( 'admin_notices', 'oih_admin_notice_added_attribution_links' );


/**
 * Handle to catch the dismiss action from the attribution links admin notice
 *
 */
function oih_admin_notice_added_attribution_links_dismiss() {

	if( empty( $_GET['oih_admin_notice_attribution_links'] ) )
		return;
	
	// Update attribution links admin notice
	update_option( 'oih_admin_notice_attribution_links', 1 );

	// Update the general settings of the plugin to hide the attribution links
	if( ! empty( $_GET['oih_admin_notice_attribution_links_hide'] ) ) {

		// Get general settings
		$settings = get_option( 'oih_settings', array() );

		// Update general settings if needed
		if( empty( $settings['hide_attribution_links'] ) ) {

			$settings['hide_attribution_links'] = 1;

			update_option( 'oih_settings', $settings );

		}

	}

}
add_action( 'admin_init', 'oih_admin_notice_added_attribution_links_dismiss' );
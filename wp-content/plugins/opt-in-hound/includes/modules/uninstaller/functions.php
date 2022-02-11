<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Adds the Uninstall link to plugin's action links in the Plugins page
 *
 * @param $links array
 *
 * @return array
 *
 */
function oih_add_plugin_action_links( $links = array() ) {

    $new_links = array();

    if( current_user_can( 'manage_options' ) )
        $new_links[] = '<span class="delete"><a href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-uninstall' ) , admin_url( 'admin.php' ) ), 'oih_uninstall_page_nonce' ) . '">' . __( 'Uninstall', 'opt-in-hound' ) . '</a></span>';

    return array_merge( $links, $new_links );

}
add_filter( 'plugin_action_links_' . OIH_BASENAME, 'oih_add_plugin_action_links' );
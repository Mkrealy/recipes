<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include lists files
 *
 */
function oih_include_lists_files() {

	// Lists
    if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/functions-db.php' ) )
		require OIH_PLUGIN_DIR . 'includes/lists/functions-db.php';

	if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/class-list.php' ) )
		require OIH_PLUGIN_DIR . 'includes/lists/class-list.php';

	if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/class-submenu-page-lists.php' ) )
		require OIH_PLUGIN_DIR . 'includes/lists/class-submenu-page-lists.php';

	if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/class-list-table-lists.php' ) )
		require OIH_PLUGIN_DIR . 'includes/lists/class-list-table-lists.php';

	// Subscribers
	if( file_exists( OIH_PLUGIN_DIR . 'includes/lists/class-list-table-subscribers.php' ) )
		require OIH_PLUGIN_DIR . 'includes/lists/class-list-table-subscribers.php';

}
add_action( 'oih_include_files', 'oih_include_lists_files' );
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
    $sub_tabs 	  	= oih_get_available_email_notifications();
    $sub_tab_slugs  = array_keys( $sub_tabs );

    $active_sub_tab = ( ! empty( $_GET['sub-tab'] ) ? $_GET['sub-tab'] : ( ! empty( $sub_tab_slugs[0] ) ? $sub_tab_slugs[0] : '' ) );
?>

<!-- Navigation Sub Tabs -->
<ul class="oih-nav-sub-tab-wrapper subsubsub">
	<?php

		if( ! empty( $sub_tabs ) ) {

			$sub_tabs_index = 1;
			$sub_tabs_count = count( $sub_tab_slugs );

			foreach( $sub_tabs as $sub_tab_slug => $sub_tab_name ) {

				echo '<li>';

					echo '<a href="' . add_query_arg( array( 'page' => 'oih-settings', 'tab' => 'email_notifications' , 'sub-tab' => $sub_tab_slug ), admin_url('admin.php') ) . '" data-sub-tab="' . $sub_tab_slug . '" class="oih-nav-sub-tab ' . ( $active_sub_tab == $sub_tab_slug ? 'current' : '' ) . '">' . $sub_tab_name . '</a>';

					if( $sub_tabs_index != $sub_tabs_count )
						echo ' | ';

				echo '</li>';

				$sub_tabs_index++;

			}
		}

	?>
</ul>

<!-- Sub Tabs Contents -->
<div class="oih-sub-tab-wrapper">
	<?php

		if( ! empty( $sub_tabs ) ) {
			foreach( $sub_tabs as $sub_tab_slug => $sub_tab_name ) {

				echo '<div class="oih-sub-tab oih-sub-tab-' . $sub_tab_slug . ' ' . ( $active_sub_tab == $sub_tab_slug ? 'oih-active' : '' ) . '" data-sub-tab="' . $sub_tab_slug . '">';

				/**
				 * Action to dynamically add content for each tab
				 *
				 */
				do_action( 'oih_submenu_page_settings_tab_email_notification_sub_tab_' . $sub_tab_slug, $settings );

				echo '</div>';

			}
		}

	?>
</div>
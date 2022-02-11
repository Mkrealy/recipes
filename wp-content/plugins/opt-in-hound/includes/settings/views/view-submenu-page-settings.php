<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="post" action="options.php">

        <?php
            settings_fields( 'oih_settings' );

            $settings 	= get_option( 'oih_settings', array() );
            $tabs 	  	= $this->tabs;
            $tab_slugs  = array_keys( $tabs );

            $active_tab = ( ! empty( $_GET['tab'] ) ? $_GET['tab'] : ( ! empty( $tab_slugs[0] ) ? $tab_slugs[0] : '' ) );
        ?>
		
		<h1><?php echo __( 'Settings', 'opt-in-hound' ); ?></h1>

		<!-- Navigation Tabs -->
		<h2 class="oih-nav-tab-wrapper nav-tab-wrapper">
			<?php

				if( ! empty( $tabs ) ) {
					foreach( $tabs as $tab_slug => $tab_name ){

						echo '<a href="' . add_query_arg( array( 'page' => 'oih-settings', 'oih-tab' => $tab_slug ), admin_url('admin.php') ) . '" data-tab="' . $tab_slug . '" class="nav-tab oih-nav-tab ' . ( $active_tab == $tab_slug ? 'nav-tab-active' : '' ) . '">' . $tab_name . '</a>';

					}
				}

			?>
		</h2>

		<!-- Tabs Contents -->
		<div class="oih-tab-wrapper">
			<?php

				if( ! empty( $tabs ) ) {
					foreach( $tabs as $tab_slug => $tab_name ) {

						echo '<div class="oih-tab oih-tab-' . $tab_slug . ' ' . ( $active_tab == $tab_slug ? 'oih-active' : '' ) . '" data-tab="' . $tab_slug . '">';

						/**
						 * Action to dynamically add content for each tab
						 *
						 */
						do_action( 'oih_submenu_page_settings_tab_' . $tab_slug, $settings );

						echo '</div>';

					}
				}

			?>
		</div>

		<!-- Save Settings Button -->
        <input type="hidden" name="oih_settings[always_update]" value="<?php echo ( isset( $settings['always_update'] ) && $settings['always_update'] == 1 ? 0 : 1 ); ?>" />
        <input type="submit" class="button-primary" value="<?php echo __( 'Save Settings', 'opt-in-hound' ); ?>" />

	</form>

</div>
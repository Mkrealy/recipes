<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


// Set subpage
$subpage = ( ! empty( $_GET['subpage'] ) ? sanitize_text_field( $_GET['subpage'] ) : '' );

// Return if no subpage is set for this view
if( empty( $subpage ) )
	return;

// Set active tab
$active_tab = ( ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general' );

// Set opt-in type
$opt_in_type = '';

if( $subpage == 'add_new' )
	$opt_in_type = ( ! empty( $_GET['opt_in_type'] ) ? sanitize_text_field( $_GET['opt_in_type'] ) : '' );

if( $subpage == 'edit' ) {

	$opt_in_id 	 = ( ! empty( $_GET['opt_in_id'] ) ? (int)$_GET['opt_in_id'] : 0 );

	if( empty( $opt_in_id ) )
		return;

	$opt_in 	 = oih_get_opt_in( $opt_in_id );
	$opt_in_type = $opt_in->get('type');

}

// Return if no opt-in type is set for this view
if( empty( $opt_in_type ) )
	return;

// Get default settings for the opt-in type
$settings_fields = oih_get_opt_in_type_settings( $opt_in_type );

// Add the value of the fields
foreach( $settings_fields as $fields_section_key => $fields_section ) {

	foreach( $fields_section as $field_key => $field ) {

		if( empty( $field['name'] ) )
			continue;

		if( ! empty( $_POST ) ) {

			$_POST = stripslashes_deep( $_POST );

			if( isset( $_POST[$field['name']] ) )
				$settings_fields[$fields_section_key][$field_key]['value'] = $_POST[$field['name']];
			else
				$settings_fields[$fields_section_key][$field_key]['value'] = '';

		} else {

			// For the edit subpage we don't need the field's default value
			if( $subpage == 'edit' ) {

				$opt_in_options = $opt_in->get('options');

				// General fields saved in options 
				if( isset( $opt_in_options[$field['name']] ) )
					$settings_fields[$fields_section_key][$field_key]['value'] = $opt_in_options[$field['name']];
				else
					$settings_fields[$fields_section_key][$field_key]['value'] = '';

				// Opt-in Name field
				if( $field['name'] == 'name' )
					$settings_fields[$fields_section_key][$field_key]['value'] = $opt_in->get('name');

				// Active field
				if( $field['name'] == 'active' )
					$settings_fields[$fields_section_key][$field_key]['value'] = $opt_in->get('active');

				// Test mode field
				if( $field['name'] == 'test_mode' )
					$settings_fields[$fields_section_key][$field_key]['value'] = $opt_in->get('test_mode');


			}

		}

	}
}
?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="POST" action="">

		<!-- Page Heading -->
		<h1>
			<?php
				if( $subpage == 'add_new' )
					echo __( 'Add New Opt-in', 'opt-in-hound' );

				if( $subpage == 'edit' )
					echo __( 'Edit Opt-in', 'opt-in-hound' );

				$opt_in_types = oih_get_opt_in_types();

				echo '<span class="oih-heading-span">' . ( ! empty( $opt_in_id ) ? '#' . $opt_in_id . ' - ' : '' ) . $opt_in_types[$opt_in_type]['name'] . '</span>';
			?>
		</h1>

		<!-- Navigation Tabs -->
		<div class="oih-opt-in-settings-nav-tab-wrapper">
			<?php

				// Get all available sections
				$tab_sections = oih_get_opt_in_settings_sections();

				// Echo the nav tabs
				foreach( $settings_fields as $fields_section_key => $fields_section ) {

					if( ! in_array( $fields_section_key, array_keys( $tab_sections ) ) )
						continue;

					// Echo the nav tab
					echo '<a href="#" data-tab="' . esc_attr( $fields_section_key ) . '" class="oih-nav-tab oih-opt-in-settings-nav-tab ' . ( $active_tab == $fields_section_key ? 'oih-active' : '' ) . '">';
						echo '<span class="dashicons dashicons-' . ( ! empty( $tab_sections[$fields_section_key]['dashicon'] ) ? esc_attr( $tab_sections[$fields_section_key]['dashicon'] ) : '' ) . '"></span>'; 
						echo ( ! empty( $tab_sections[$fields_section_key]['label'] ) ? esc_html( $tab_sections[$fields_section_key]['label'] ) : '' );
					echo '</a>';

				}
			?>
		</div>

		<div class="oih-opt-in-settings-tabs-wrapper">

			<?php 

				// Echo the tabs with the fields
				foreach( $settings_fields as $fields_section_key => $fields_section ) {

					echo '<div id="oih-opt-in-settings-tab-' . esc_attr( $fields_section_key ) . '" data-tab="' . esc_attr( $fields_section_key ) . '" class="oih-tab oih-opt-in-settings-tab ' . ( $active_tab == $fields_section_key ? 'oih-active' : '' ) . '">';

					foreach( $fields_section as $field ) {

						oih_output_settings_field( $field );

					}

					echo '</div>';

				}

			?>

			<!-- Footer -->
			<div class="oih-opt-in-settings-footer">

				<?php wp_nonce_field( 'oih_' . $subpage . '_opt_in', 'oih_token' ); ?>

				<input type="hidden" value="<?php echo $active_tab; ?>" name="active_tab" />
				<input type="submit" value="<?php echo ( $subpage == 'add_new' ? __( 'Add Opt-In', 'opt-in-hound' ) : __( 'Save Changes', 'opt-in-hound' ) ); ?>" class="button-primary" />

				<?php

					/**
					 * Add other action buttons in the settings footer
					 *
					 */
					do_action( 'oih_opt_in_settings_footer' );

				?>

				<?php 
					if( $subpage == 'edit' )
						echo '<a class="oih-trash" onclick="return confirm( \'' . __( "Are you sure you want to delete this opt-in?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-opt-in-forms', 'opt_in_id' => $opt_in->get('id') ) , admin_url( 'admin.php' ) ), 'oih_delete_opt_in', 'oih_token' ) . '">' . __( 'Delete Opt-in', 'opt-in-hound' ) . '</a>';
				?>

			</div>

		</div>

	</form>
</div>
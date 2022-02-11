<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Set subpage
$subpage = ( ! empty( $_GET['subpage'] ) ? str_replace( '_list', '', sanitize_text_field( $_GET['subpage'] ) ) : '' );

// Return if no subpage is set for this view
if( empty( $subpage ) )
	return;

if( $subpage != 'add_new' )
	return;

// List fields
$list_fields = array(
	'name' => array(
		'name'    => 'name',
		'type' 	  => 'text',
		'label'   => __( 'Name *', 'opt-in-hound' ),
		'value'	  => ( ! empty( $_POST['name'] ) ? $_POST['name'] : '' )
	),
	'description' => array(
		'name'    => 'description',
		'type' 	  => 'textarea',
		'label'   => __( 'Description', 'opt-in-hound' ),
		'value'	  => ( ! empty( $_POST['description'] ) ? $_POST['description'] : '' ),
		'desc'	  => __( 'Add a short description so that you can easily remember why you have created this list.', 'opt-in-hound' )
	)
);


?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="POST" action="">

		<!-- Page Heading -->
		<h1>
			<?php echo __( 'Add New List', 'opt-in-hound' ); ?>
		</h1>

		
		<div class="oih-opt-in-settings-panel-wrapper">

			<!-- Settings Fields -->
			<?php
				foreach( $list_fields as $field ) {

					oih_output_settings_field( $field );

				}
			?>

			<!-- Footer -->
			<div class="oih-opt-in-settings-footer">

				<?php wp_nonce_field( 'oih_' . $subpage . '_list', 'oih_token' ); ?>

				<input type="submit" value="<?php echo ( $subpage == 'add_new' ? __( 'Add List', 'opt-in-hound' ) : __( 'Save Changes', 'opt-in-hound' ) ); ?>" class="button-primary" />

			</div>

		</div>

	</form>

</div>
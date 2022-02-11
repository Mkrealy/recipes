<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Set subpage
$subpage = ( ! empty( $_GET['subpage'] ) ? str_replace( '_list', '', sanitize_text_field( $_GET['subpage'] ) ) : '' );

// Return if no subpage is set for this view
if( empty( $subpage ) )
	return;

if( $subpage != 'edit' )
	return;

$list_id = ( ! empty( $_GET['list_id'] ) ? (int)$_GET['list_id'] : 0 );

if( empty( $list_id ) )
	return;

// Get list
$list = oih_get_list( $list_id );

if( is_null( $list ) )
	return;

// Subscriber fields
$list_fields = array(
	'name' => array(
		'name'    => 'name',
		'type' 	  => 'text',
		'label'   => __( 'Name *', 'opt-in-hound' ),
		'value'   => $list->get('name')
	),
	'description' => array(
		'name'    => 'description',
		'type' 	  => 'textarea',
		'label'   => __( 'Description', 'opt-in-hound' ),
		'value'   => $list->get('description')
	),
	'date_added' => array(
		'name'    => 'date_added',
		'type' 	  => 'text',
		'label'   => __( 'Date Added', 'opt-in-hound' ),
		'disabled' => true,
		'value'   => date( oih_get_wp_datetime_format(), strtotime( $list->get('date') ) )
	)
);

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="POST" action="">

		<!-- Page Heading -->
		<h1>
			<?php
				echo __( 'Edit List', 'opt-in-hound' );

				if( ! empty( $list_id ) )
					echo '<span class="oih-heading-span">#' . esc_html( $list_id ) . '</span>';
			?>
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

				<?php
					$lists = oih_get_lists();

					if( count( $lists ) > 1 )
						echo '<a class="oih-trash" onclick="return confirm( \'' . __( "This will remove all subscribers from this list. Are you sure you want to delete this list?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-lists', 'list_id' => $list->get('id') ) , admin_url( 'admin.php' ) ), 'oih_delete_list', 'oih_token' ) . '">' . __( 'Delete List', 'opt-in-hound' ) . '</a>';
				?>

			</div>

		</div>

	</form>

</div>
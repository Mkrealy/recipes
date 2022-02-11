<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Set subpage
$subpage = ( ! empty( $_GET['subpage'] ) ? sanitize_text_field( $_GET['subpage'] ) : '' );

// Return if no subpage is set for this view
if( empty( $subpage ) )
	return;

if( $subpage == 'add_new' ) {

	// Subscriber fields
	$subscriber_fields = array(
		'email' => array(
			'name'    => 'email',
			'type' 	  => 'text',
			'label'   => __( 'Email Address *', 'opt-in-hound' ),
			'value'	  => ( ! empty( $_POST['email'] ) ? $_POST['email'] : '' )
		),
		'first_name' => array(
			'name'    => 'first_name',
			'type' 	  => 'text',
			'label'   => __( 'First Name', 'opt-in-hound' ),
			'value'	  => ( ! empty( $_POST['first_name'] ) ? $_POST['first_name'] : '' )
		),
		'last_name' => array(
			'name'    => 'last_name',
			'type' 	  => 'text',
			'label'   => __( 'Last Name', 'opt-in-hound' ),
			'value'	  => ( ! empty( $_POST['last_name'] ) ? $_POST['last_name'] : '' )
		),
		'source' => array(
			'name'    => 'source',
			'type' 	  => 'hidden',
			'default' => 'manual'
		)
	);

}

if( $subpage == 'edit' ) {

	$subscriber_id = ( ! empty( $_GET['subscriber_id'] ) ? (int)$_GET['subscriber_id'] : 0 );

	if( empty( $subscriber_id ) )
		return;

	// Get subscriber
	$subscriber = oih_get_subscriber_by_id( $subscriber_id );

	// Get source name
	$subscriber_source_names = oih_get_subscriber_source_names( $subscriber->get('source') );

	// Subscriber fields
	$subscriber_fields = array(
		'email' => array(
			'name'    => 'email',
			'type' 	  => 'text',
			'label'   => __( 'Email Address', 'opt-in-hound' ),
			'disabled' => true,
			'value'   => $subscriber->get('email')
		),
		'first_name' => array(
			'name'    => 'first_name',
			'type' 	  => 'text',
			'label'   => __( 'First Name', 'opt-in-hound' ),
			'value'   => $subscriber->get('first_name')
		),
		'last_name' => array(
			'name'    => 'last_name',
			'type' 	  => 'text',
			'label'   => __( 'Last Name', 'opt-in-hound' ),
			'value'   => $subscriber->get('last_name')
		),
		'date_added' => array(
			'name'    => 'date_added',
			'type' 	  => 'text',
			'label'   => __( 'Date Added', 'opt-in-hound' ),
			'disabled' => true,
			'value'   => date( oih_get_wp_datetime_format(), strtotime( $subscriber->get('date') ) )
		),
		'ip_address' => array(
			'name'    => 'ip_address',
			'type' 	  => 'text',
			'label'   => __( 'IP Address', 'opt-in-hound' ),
			'disabled' => true,
			'value'   => $subscriber->get('ip_address')
		),
		'source' => array(
			'name'    => 'source',
			'type' 	  => 'text',
			'label'   => __( 'Source', 'opt-in-hound' ),
			'disabled' => true,
			'value'	  => ( ! empty( $subscriber_source_names['long_name'] ) ? $subscriber_source_names['long_name'] : '' )
		)
	);

}

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="POST" action="">

		<!-- Page Heading -->
		<h1>
			<?php
				if( $subpage == 'add_new' )
					echo __( 'Add New Subscriber', 'opt-in-hound' );

				if( $subpage == 'edit' )
					echo __( 'Edit Subscriber', 'opt-in-hound' );

				if( ! empty( $subscriber_id ) )
					echo '<span class="oih-heading-span">#' . esc_html( $subscriber_id ) . '</span>';
			?>
		</h1>

		
		<div class="oih-opt-in-settings-panel-wrapper">

			<!-- Settings Fields -->
			<?php
				foreach( $subscriber_fields as $field ) {

					oih_output_settings_field( $field );

				}

				if( $subpage == 'add_new' ) {

					echo '<p class="description">' . __( 'Because you are adding this subscriber manually email notifications will not be sent. Also, the subscriber will not have attached an IP address.', 'opt-in-hound' ) . '</p><br />';

				}
			?>

			<!-- Footer -->
			<div class="oih-opt-in-settings-footer">

				<?php wp_nonce_field( 'oih_' . $subpage . '_subscriber', 'oih_token' ); ?>

				<input type="submit" value="<?php echo ( $subpage == 'add_new' ? __( 'Add Subscriber', 'opt-in-hound' ) : __( 'Save Changes', 'opt-in-hound' ) ); ?>" class="button-primary" />

				<?php 
					if( $subpage == 'edit' )
						echo '<a class="oih-trash" onclick="return confirm( \'' . __( "Are you sure you want to delete this subscriber?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-subscribers', 'subscriber_id' => $subscriber->get('id') ) , admin_url( 'admin.php' ) ), 'oih_delete_subscriber', 'oih_token' ) . '">' . __( 'Delete Subscriber', 'opt-in-hound' ) . '</a>';
				?>

			</div>

		</div>

	</form>

</div>
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$list_id = ( ! empty( $_GET['list_id'] ) ? (int)$_GET['list_id'] : 0 );

if( empty( $list_id ) )
	return;

$list = oih_get_list( $list_id );

if( is_null( $list ) )
	return;

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="GET">

		<input type="hidden" name="page" value="oih-lists" />
		<input type="hidden" name="subpage" value="view_subscribers" />
		<input type="hidden" name="list_id" value="<?php echo $list->get('id'); ?>" />
		
		<h1>
			<?php echo $list->get('name'); ?>
			<a href="<?php echo add_query_arg( array( 'subpage' => 'add_new_subscriber', 'list_id' => $list->get('id') ), $this->admin_url ); ?>" class="add-new-h2 page-title-action"><?php echo __( 'Add New Subscriber', 'opt-in-hound' ); ?></a>
		</h1>

		<?php
			$table = new OIH_WP_List_Table_Subscribers();
			$table->search_box( __( 'Search', 'opt-in-hound' ), 's' );
			$table->display();
		?>

	</form>

</div>
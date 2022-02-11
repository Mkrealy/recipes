<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<form method="GET">

		<input type="hidden" name="page" value="oih-subscribers" />
		
		<h1>
			<?php echo __( 'Subscribers', 'opt-in-hound' ); ?>
			<a href="<?php echo add_query_arg( array( 'subpage' => 'add_new' ), $this->admin_url ); ?>" class="add-new-h2 page-title-action"><?php echo __( 'Add New Subscriber', 'opt-in-hound' ); ?></a>
		</h1>

		<?php
			$table = new OIH_WP_List_Table_Subscribers();
			$table->search_box( __( 'Search', 'opt-in-hound' ), 's' );
			$table->display();
		?>

	</form>

</div>
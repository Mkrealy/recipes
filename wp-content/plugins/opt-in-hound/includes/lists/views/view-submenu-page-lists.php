<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$lists = oih_get_lists( array( 'number' => 1 ) );

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap oih-wrap-lists">

	<form method="GET">

		<input type="hidden" name="page" value="oih-lists" />
		
		<h1>
			<?php echo __( 'Subscriber Lists', 'opt-in-hound' ); ?>

			<?php if( ! empty( $lists ) ): ?>
				<a href="<?php echo add_query_arg( array( 'subpage' => 'add_new_list' ), $this->admin_url ); ?>" class="add-new-h2 page-title-action"><?php echo __( 'Add New List', 'opt-in-hound' ); ?></a>
			<?php endif; ?>
		</h1>

		<?php
			if( ! empty( $lists ) ):

				$table = new OIH_WP_List_Table_Lists();
				$table->search_box( __( 'Search', 'opt-in-hound' ), 's' );
				$table->display();
			else:
		?>

		<div class="oih-list-table-no-items-placeholder">
		    
		    <span class="dashicons dashicons-groups oih-icon"></span>

		    <h2><?php echo __( 'Set Up Your First Subscriber List', 'opt-in-hound' ); ?></h2>
		    <p><?php echo __( "It seems like you don't have any subscriber lists. Let's set up one with just one click.", 'opt-in-hound' ) ?></p>
		    
		    <a href="<?php echo wp_nonce_url( $this->admin_url, 'oih_set_up_first_list', 'oih_token' ); ?>" class="button-primary"><?php echo __( 'Set Up the Subscriber List', 'opt-in-hound' ); ?></a>
		    
		</div>

		<?php endif; ?>

	</form>

</div>
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$opt_ins = oih_get_opt_ins( array( 'number' => 1 ) );

?>

<?php oih_admin_header(); ?>
<div class="wrap oih-wrap">

	<h1>
		<?php echo __( 'Opt-Ins', 'opt-in-hound' ); ?>

		<?php if( ! empty( $opt_ins ) ): ?>
			<a href="<?php echo add_query_arg( array( 'subpage' => 'add_new' ), $this->admin_url ); ?>" class="add-new-h2 page-title-action"><?php echo __( 'Add New Opt-In', 'opt-in-hound' ); ?></a>
		<?php endif; ?>
	</h1>

	<?php
		if( ! empty( $opt_ins ) ):
			$table = new OIH_WP_List_Table_Opt_Ins();
			$table->display();
		else:

			$lists = oih_get_lists( array( 'number' => 1 ) );
	?>

	<div class="oih-list-table-no-items-placeholder">
		    
	    <span class="dashicons dashicons-email-alt oih-icon"></span>

	    <h2><?php echo __( 'Set Up Your First Opt-In Form', 'opt-in-hound' ); ?></h2>
	    <p><?php echo __( "It seems like you don't have any opt-in forms. Let's set up one and start collecting leads.", 'opt-in-hound' ) ?></p>
	    
	    <a href="<?php echo add_query_arg( array( 'subpage' => 'add_new' ), $this->admin_url ); ?>" class="oih-button-primary button-primary <?php echo ( empty( $lists ) ? 'disabled' : '' ); ?>"><?php echo __( 'Set Up an Opt-In Form', 'opt-in-hound' ); ?></a>
	    
	    <?php if( empty( $lists ) ): ?>
	    	<p class="description" style="margin-top: 10px; font-size: 12px;"><?php echo sprintf( __( 'Before you can set up an opt-in, please set up a %ssubscriber list here%s.', 'opt-in-hound' ), '<a href="' . add_query_arg( array( 'page' => 'oih-lists' ), admin_url( 'admin.php' ) ) . '">', '</a>' ); ?></p>
		<?php endif; ?>
		
	</div>

	<?php endif; ?>

</div>
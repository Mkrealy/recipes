<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="wrap oih-wrap">

	<h1><?php echo __( 'Uninstall Opt-In Hound', 'opt-in-hound' ); ?></h1>

	<div class="oih-notice-uninstall notice error"><p><strong><?php echo __( 'Warning: All information stored by Opt-In Hound will be removed from your database in the Uninstall process and cannot be recovered. Please do a backup of your database before proceeding.', 'opt-in-hound' ) ?></strong></p></div>

	<p><?php echo __( 'We\'re sad to see you leave, but we understand that sometimes things don\'t work out as planned.', 'opt-in-hound' ); ?></p>

	<p><?php echo __( 'We have to make sure you don\'t accidentally delete all your data, so to confirm your action please type in <strong>REMOVE</strong> in the box below.', 'opt-in-hound' ); ?></p>

	<br />

	<form method="post" action="">

        <input type="text" id="oih-uninstall-confirmation" name="oih_uninstall_plugin" />
        
        <p class="submit">
        	<input id="oih-uninstall-plugin-submit" disabled="disabled" type="submit" class="button button-primary" value="<?php echo __( 'Uninstall', 'opt-in-hound' ); ?>" />
        	<a class="button" href="<?php echo admin_url( 'plugins.php' ); ?>"><?php echo __( 'Cancel', 'opt-in-hound' ); ?></a>
        </p>

        <?php wp_nonce_field( 'oih_uninstall', 'oih_token' ) ?>

    </form>

</div>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<div id="fa-pro-popup">
	<div class="popup">
		<a href="#" class="fa-pro-popup-close dashicons dashicons-no-alt"></a>
		<div class="header">
			<span class="icon dashicons dashicons-lock"></span>
			<h2 class="title"><?php _e('Unlock PRO Features', 'maz-loader'); ?></h2>
		</div>
		<div class="content">
			<div class="message main"><strong class="reason"></strong> <?php _e('is a PRO feature.', 'maz-loader'); ?></div>
			<div class="message"><?php _e('Upgrade to PRO and unlock this feature alongside others to elevate your Preloaders!', 'maz-loader'); ?></div>
		</div>
		<div class="actions">
			<a href="<?php echo MZLDR_Constants::getUpgradeURL(); ?>" class="popup-button"><?php _e('Upgrade to PRO', 'maz-loader'); ?></a>
		</div>
		<div class="promo">
			<p style="margin: 0;"><?php _e('Upgrade to Pro and receive <strong>30%</strong> OFF!', 'maz-loader'); ?><br><?php _e('Pro users also benefit from <strong>30%</strong> OFF their renewal.', 'maz-loader'); ?></p>
		</div>
		<div class="links">
			<a href="<?php echo MZLDR_Constants::getPluginPageURL(); ?>" target="_blank"><?php _e('PRO Features', 'maz-loader'); ?></a> &mdash; <a href="<?php echo MZLDR_Constants::getSupportURL(); ?>" target="_blank"><?php _e('Have a question?', 'maz-loader'); ?></a>
		</div>
	</div>
</div>
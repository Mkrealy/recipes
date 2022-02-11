<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
?>
<div class="mzldr-update-notice-wrapper">
	<div class="update-notice">
		<div class="title"><?php echo esc_html($name) . ' ' . esc_attr($version); ?> is available!</div>
		<div class="subtitle">Your current version is <?php echo MZLDR_VERSION; ?>. <a href="<?php echo esc_url(MZLDR_CHANGELOG_URL); ?>">View Changelog</a></div>
		<a href="<?php echo admin_url('plugins.php'); ?>" class="mzldr-button small green"><i class="icon dashicons dashicons-download"></i>Update</a>
	</div>
</div>
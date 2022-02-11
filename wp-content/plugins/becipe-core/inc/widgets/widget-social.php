<?php

/**
 * Plugin Name: Socail Widget
 * Description: A widget that show social icons
 * Version: 1.0
 * Author: Frenify
 * Author URI: http://themeforest.net/user/frenify
 *
 */


/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Becipe_Social extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'becipe_social', // Base ID
			esc_html__( 'Frenify Social', 'becipe' ), // Name
			array( 'description' => esc_html__( 'Social Icons', 'becipe' ), ) // Args
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'Becipe_Social' );
        });
	}
	

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		
		$title				= '';
		
		$facebook			= '';
		$twitter			= '';
		$pinterest			= '';
		$linkedin			= '';
		$behance			= '';
		$vimeo				= '';
		$google				= '';
		$youtube			= '';
		$instagram			= '';
		$github				= '';
		$flickr				= '';
		$dribbble			= '';
		$dropbox			= '';
		$paypal				= '';
		$picasa				= '';
		$soundcloud			= '';
		$whatsapp			= '';
		$skype				= '';
		$slack				= '';
		$wechat				= '';
		$icq				= '';
		$rocketchat			= '';
		$telegram			= '';
		$vkontakte			= '';
		$rss				= '';
				
		
		/* Our variables from the widget settings. */
		if ( !empty( $instance[ 'title' ] ) ) { 
			$title 			= $instance[ 'title' ];
		}
		$title 		= apply_filters(esc_html__('Subscribe & Follow', 'becipe'), $title );
		
		
		if ( !empty( $instance[ 'facebook' ] ) ) {$facebook 		= $instance[ 'facebook' ];}
		if ( !empty( $instance[ 'twitter' ] ) ) {$twitter 			= $instance[ 'twitter' ];}
		if ( !empty( $instance[ 'pinterest' ] ) ) {$pinterest 		= $instance[ 'pinterest' ];}
		if ( !empty( $instance[ 'linkedin' ] ) ) {$linkedin 		= $instance[ 'linkedin' ];}
		if ( !empty( $instance[ 'behance' ] ) ) {$behance 			= $instance[ 'behance' ];}
		if ( !empty( $instance[ 'vimeo' ] ) ) {$vimeo 				= $instance[ 'vimeo' ];}
		if ( !empty( $instance[ 'google' ] ) ) {$google 			= $instance[ 'google' ];}
		if ( !empty( $instance[ 'youtube' ] ) ) {$youtube 			= $instance[ 'youtube' ];}
		if ( !empty( $instance[ 'instagram' ] ) ) {$instagram 		= $instance[ 'instagram' ];}
		if ( !empty( $instance[ 'github' ] ) ) {$github 			= $instance[ 'github' ];}
		if ( !empty( $instance[ 'flickr' ] ) ) {$flickr 			= $instance[ 'flickr' ];}
		if ( !empty( $instance[ 'dribbble' ] ) ) {$dribbble 		= $instance[ 'dribbble' ];}
		if ( !empty( $instance[ 'dropbox' ] ) ) {$dropbox 			= $instance[ 'dropbox' ];}
		if ( !empty( $instance[ 'paypal' ] ) ) {$paypal 			= $instance[ 'paypal' ];}
		if ( !empty( $instance[ 'picasa' ] ) ) {$picasa 			= $instance[ 'picasa' ];}
		if ( !empty( $instance[ 'soundcloud' ] ) ) {$soundcloud 	= $instance[ 'soundcloud' ];}
		if ( !empty( $instance[ 'whatsapp' ] ) ) {$whatsapp 		= $instance[ 'whatsapp' ];}
		if ( !empty( $instance[ 'skype' ] ) ) {$skype 				= $instance[ 'skype' ];}
		if ( !empty( $instance[ 'slack' ] ) ) {$slack 				= $instance[ 'slack' ];}
		if ( !empty( $instance[ 'wechat' ] ) ) {$wechat 			= $instance[ 'wechat' ];}
		if ( !empty( $instance[ 'icq' ] ) ) {$icq 					= $instance[ 'icq' ];}
		if ( !empty( $instance[ 'rocketchat' ] ) ) {$rocketchat 	= $instance[ 'rocketchat' ];}
		if ( !empty( $instance[ 'telegram' ] ) ) {$telegram 		= $instance[ 'telegram' ];}
		if ( !empty( $instance[ 'vkontakte' ] ) ) {$vkontakte 		= $instance[ 'vkontakte' ];}
		if ( !empty( $instance[ 'rss' ] ) ) {$rss 					= $instance[ 'rss' ];}
		
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
		
		
		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);
		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title); 
		}
		?>
           	<div class="becipe_fn_widget_social">
				<ul>
					<?php
						if($facebook != ''){echo '<li><a href="'.$facebook.'">'.$facebook_icon.$facebook_icon.'</a></li>';}
						if($twitter != ''){echo '<li><a href="'.$twitter.'">'.$twitter_icon.$twitter_icon.'</a></li>';}
						if($pinterest != ''){echo '<li><a href="'.$pinterest.'">'.$pinterest_icon.$pinterest_icon.'</a></li>';}
						if($linkedin != ''){echo '<li><a href="'.$linkedin.'">'.$linkedin_icon.$linkedin_icon.'</a></li>';}
						if($behance != ''){echo '<li><a href="'.$behance.'">'.$behance_icon.$behance_icon.'</a></li>';}
						if($vimeo != ''){echo '<li><a href="'.$vimeo.'">'.$vimeo_icon.$vimeo_icon.'</a></li>';}
						if($google != ''){echo '<li><a href="'.$google.'">'.$google_icon.$google_icon.'</a></li>';}
						if($youtube != ''){echo '<li><a href="'.$youtube.'">'.$youtube_icon.$youtube_icon.'</a></li>';}
						if($instagram != ''){echo '<li><a href="'.$instagram.'">'.$instagram_icon.$instagram_icon.'</a></li>';}
						if($github != ''){echo '<li><a href="'.$github.'">'.$github_icon.$github_icon.'</a></li>';}
						if($flickr != ''){echo '<li><a href="'.$flickr.'">'.$flickr_icon.$flickr_icon.'</a></li>';}
						if($dribbble != ''){echo '<li><a href="'.$dribbble.'">'.$dribbble_icon.$dribbble_icon.'</a></li>';}
						if($dropbox != ''){echo '<li><a href="'.$dropbox.'">'.$dropbox_icon.$dropbox_icon.'</a></li>';}
						if($paypal != ''){echo '<li><a href="'.$paypal.'">'.$paypal_icon.$paypal_icon.'</a></li>';}
						if($picasa != ''){echo '<li><a href="'.$picasa.'">'.$picasa_icon.$picasa_icon.'</a></li>';}
						if($soundcloud != ''){echo '<li><a href="'.$soundcloud.'">'.$soundcloud_icon.$soundcloud_icon.'</a></li>';}
						if($whatsapp != ''){echo '<li><a href="'.$whatsapp.'">'.$whatsapp_icon.$whatsapp_icon.'</a></li>';}
						if($skype != ''){echo '<li><a href="'.$skype.'">'.$skype_icon.$skype_icon.'</a></li>';}
						if($slack != ''){echo '<li><a href="'.$slack.'">'.$slack_icon.$slack_icon.'</a></li>';}
						if($rocketchat != ''){echo '<li><a href="'.$rocketchat.'">'.$rocketchat_icon.$rocketchat_icon.'</a></li>';}
						if($telegram != ''){echo '<li><a href="'.$telegram.'">'.$telegram_icon.$telegram_icon.'</a></li>';}
						if($vkontakte != ''){echo '<li><a href="'.$vkontakte.'">'.$vkontakte_icon.$vkontakte_icon.'</a></li>';}
						if($rss != ''){echo '<li><a href="'.$rss.'">'.$rss_icon.$rss_icon.'</a></li>';}
					?>
				</ul>
            </div>
            
		<?php 
		/* After widget (defined by themes). */
		echo wp_kses_post($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = array();
 
        $instance['title'] 			= ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['facebook'] 		= ( !empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
        $instance['twitter'] 		= ( !empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
        $instance['pinterest'] 		= ( !empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
        $instance['linkedin'] 		= ( !empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';
        $instance['behance'] 		= ( !empty( $new_instance['behance'] ) ) ? strip_tags( $new_instance['behance'] ) : '';
        $instance['vimeo'] 			= ( !empty( $new_instance['vimeo'] ) ) ? strip_tags( $new_instance['vimeo'] ) : '';
        $instance['google'] 		= ( !empty( $new_instance['google'] ) ) ? strip_tags( $new_instance['google'] ) : '';
        $instance['youtube'] 		= ( !empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
        $instance['instagram'] 		= ( !empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
        $instance['github'] 		= ( !empty( $new_instance['github'] ) ) ? strip_tags( $new_instance['github'] ) : '';
        $instance['flickr'] 		= ( !empty( $new_instance['flickr'] ) ) ? strip_tags( $new_instance['flickr'] ) : '';
        $instance['dribbble'] 		= ( !empty( $new_instance['dribbble'] ) ) ? strip_tags( $new_instance['dribbble'] ) : '';
        $instance['dropbox'] 		= ( !empty( $new_instance['dropbox'] ) ) ? strip_tags( $new_instance['dropbox'] ) : '';
        $instance['picasa'] 		= ( !empty( $new_instance['picasa'] ) ) ? strip_tags( $new_instance['picasa'] ) : '';
        $instance['soundcloud'] 	= ( !empty( $new_instance['soundcloud'] ) ) ? strip_tags( $new_instance['soundcloud'] ) : '';
        $instance['whatsapp'] 		= ( !empty( $new_instance['whatsapp'] ) ) ? strip_tags( $new_instance['whatsapp'] ) : '';
        $instance['skype'] 			= ( !empty( $new_instance['skype'] ) ) ? strip_tags( $new_instance['skype'] ) : '';
        $instance['slack'] 			= ( !empty( $new_instance['slack'] ) ) ? strip_tags( $new_instance['slack'] ) : '';
        $instance['wechat'] 		= ( !empty( $new_instance['wechat'] ) ) ? strip_tags( $new_instance['wechat'] ) : '';
        $instance['icq'] 			= ( !empty( $new_instance['icq'] ) ) ? strip_tags( $new_instance['icq'] ) : '';
        $instance['rocketchat'] 	= ( !empty( $new_instance['rocketchat'] ) ) ? strip_tags( $new_instance['rocketchat'] ) : '';
        $instance['telegram'] 		= ( !empty( $new_instance['telegram'] ) ) ? strip_tags( $new_instance['telegram'] ) : '';
        $instance['vkontakte'] 		= ( !empty( $new_instance['vkontakte'] ) ) ? strip_tags( $new_instance['vkontakte'] ) : '';
        $instance['rss'] 			= ( !empty( $new_instance['rss'] ) ) ? strip_tags( $new_instance['rss'] ) : '';
 
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$title 			= ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Subscribe & Follow', 'becipe');
		$facebook 		= ! empty( $instance['facebook'] ) ? $instance['facebook'] : '#';
		$twitter 		= ! empty( $instance['twitter'] ) ? $instance['twitter'] : '#';
		$pinterest 		= ! empty( $instance['pinterest'] ) ? $instance['pinterest'] : '#';
		$linkedin 		= ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$behance 		= ! empty( $instance['behance'] ) ? $instance['behance'] : '#';
		$vimeo 			= ! empty( $instance['vimeo'] ) ? $instance['vimeo'] : '';
		$google 		= ! empty( $instance['google'] ) ? $instance['google'] : '';
		$youtube 		= ! empty( $instance['youtube'] ) ? $instance['youtube'] : '#';
		$instagram 		= ! empty( $instance['instagram'] ) ? $instance['instagram'] : '#';
		$github 		= ! empty( $instance['github'] ) ? $instance['github'] : '';
		$flickr 		= ! empty( $instance['flickr'] ) ? $instance['flickr'] : '';
		$dribbble 		= ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '#';
		$dropbox 		= ! empty( $instance['dropbox'] ) ? $instance['dropbox'] : '';
		$picasa 		= ! empty( $instance['picasa'] ) ? $instance['picasa'] : '';
		$soundcloud		= ! empty( $instance['soundcloud'] ) ? $instance['soundcloud'] : '';
		$whatsapp		= ! empty( $instance['whatsapp'] ) ? $instance['whatsapp'] : '';
		$skype			= ! empty( $instance['skype'] ) ? $instance['skype'] : '';
		$slack			= ! empty( $instance['slack'] ) ? $instance['slack'] : '';
		$wechat			= ! empty( $instance['wechat'] ) ? $instance['wechat'] : '';
		$icq			= ! empty( $instance['icq'] ) ? $instance['icq'] : '';
		$rocketchat		= ! empty( $instance['rocketchat'] ) ? $instance['rocketchat'] : '';
		$telegram		= ! empty( $instance['telegram'] ) ? $instance['telegram'] : '';
		$vkontakte		= ! empty( $instance['vkontakte'] ) ? $instance['vkontakte'] : '';
		$rss			= ! empty( $instance['rss'] ) ? $instance['rss'] : '#';
		
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
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php echo $facebook_icon; esc_html_e('Facebook', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook' )); ?>" value="<?php echo esc_attr($facebook); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php echo $twitter_icon; esc_html_e('Twitter', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter' )); ?>" value="<?php echo esc_attr($twitter); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php echo $pinterest_icon; esc_html_e('Pinterest', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest' )); ?>" value="<?php echo esc_attr($pinterest); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>"><?php echo $linkedin_icon; esc_html_e('Linkedin', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'linkedin' )); ?>" value="<?php echo esc_attr($linkedin); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'behance' )); ?>"><?php echo $behance_icon; esc_html_e('Behance', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'behance' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'behance' )); ?>" value="<?php echo esc_attr($behance); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'vimeo' )); ?>"><?php echo $vimeo_icon; esc_html_e('Vimeo', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'vimeo' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vimeo' )); ?>" value="<?php echo esc_attr($vimeo); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'google' )); ?>"><?php echo $google_icon; esc_html_e('Google', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'google' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'google' )); ?>" value="<?php echo esc_attr($google); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php echo $youtube_icon; esc_html_e('Youtube', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube' )); ?>" value="<?php echo esc_attr($youtube); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php echo $instagram_icon; esc_html_e('Instagram', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram' )); ?>" value="<?php echo esc_attr($instagram); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'github' )); ?>"><?php echo $github_icon; esc_html_e('Github', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'github' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'github' )); ?>" value="<?php echo esc_attr($github); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'flickr' )); ?>"><?php echo $flickr_icon; esc_html_e('Flickr', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'flickr' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'flickr' )); ?>" value="<?php echo esc_attr($flickr); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'dribbble' )); ?>"><?php echo $dribbble_icon; esc_html_e('Dribbble', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'dribbble' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dribbble' )); ?>" value="<?php echo esc_attr($dribbble); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'dropbox' )); ?>"><?php echo $dropbox_icon; esc_html_e('Dropbox', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'dropbox' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dropbox' )); ?>" value="<?php echo esc_attr($dropbox); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'picasa' )); ?>"><?php echo $picasa_icon; esc_html_e('Picasa', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'picasa' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'picasa' )); ?>" value="<?php echo esc_attr($picasa); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'soundcloud' )); ?>"><?php echo $soundcloud_icon; esc_html_e('Soundcloud', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'soundcloud' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'soundcloud' )); ?>" value="<?php echo esc_attr($soundcloud); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'whatsapp' )); ?>"><?php echo $whatsapp_icon; esc_html_e('Whatsapp', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'whatsapp' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'whatsapp' )); ?>" value="<?php echo esc_attr($whatsapp); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>"><?php echo $skype_icon; esc_html_e('Skype', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'skype' )); ?>" value="<?php echo esc_attr($skype); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'slack' )); ?>"><?php echo $slack_icon; esc_html_e('Slack', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'slack' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'slack' )); ?>" value="<?php echo esc_attr($slack); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'wechat' )); ?>"><?php echo $wechat_icon; esc_html_e('Wechat', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'wechat' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'wechat' )); ?>" value="<?php echo esc_attr($wechat); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'icq' )); ?>"><?php echo $icq_icon; esc_html_e('ICQ', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'icq' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'icq' )); ?>" value="<?php echo esc_attr($icq); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'rocketchat' )); ?>"><?php echo $rocketchat_icon; esc_html_e('Rocketchat', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'rocketchat' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'rocketchat' )); ?>" value="<?php echo esc_attr($rocketchat); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'telegram' )); ?>"><?php echo $telegram_icon; esc_html_e('Telegram', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'telegram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'telegram' )); ?>" value="<?php echo esc_attr($telegram); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'vkontakte' )); ?>"><?php echo $vkontakte_icon; esc_html_e('Vkontakte', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'vkontakte' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vkontakte' )); ?>" value="<?php echo esc_attr($vkontakte); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'rss' )); ?>"><?php echo $rss_icon; esc_html_e('RSS', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'rss' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'rss' )); ?>" value="<?php echo esc_attr($rss); ?>" class="becipe_fn_width100" />
		</p>

	<?php
	}
}

$my_widget = new Becipe_Social();
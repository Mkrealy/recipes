<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
	

	$query_args = array(
		'post_type' 			=> 'becipe-recipe',
		'posts_per_page' 		=> -1,
		'post_status' 			=> 'publish',
	);

	$loop 						= new \WP_Query($query_args);

	$allRecipePosts = array();

	foreach ( $loop->posts as $key => $fn_post ) {
		setup_postdata( $fn_post );
		$allRecipePosts[$fn_post->ID] 	= $fn_post->post_title;
		wp_reset_postdata();
	}

    // This is your option name where all the Redux data is stored.
    $opt_name = "becipe_fn_option";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => 'becipe_fn_option',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_frenify_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => false,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
    
    Redux::setArgs( $opt_name, $args );


    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */
	$adminURL = '<a href="'.admin_url('options-permalink.php').'">'.esc_html__('Here', 'redux-framework-demo').'</a>';	 
	$permalink_description = __('After changing this, go to following link and click save. '.$adminURL.'', 'redux-framework-demo');

	$langURL = '<a target="_blank" href="https://wpml.org/">'.esc_html__('WPML Multilingual CMS', 'redux-framework-demo').'</a>';	 
	$lang_desc = __('Please, install and set up following plugin: '.$langURL.'', 'redux-framework-demo');
    // -> START Basic Fields
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'General', 'redux-framework-demo' ),
        'id'    => 'general',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-globe',
		'fields' 	=> array(
			
			
			array(
				'id'		=> 'box_shadow',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('All Box Shadows', 'redux-framework-demo'),
				'default' 	=> 'enable',
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),			
			),
			array(
				'id'		=> 'blog_single_title',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Page Title for Blog Single', 'redux-framework-demo'),
				'default'	=> esc_html__('Latest News', 'redux-framework-demo'),
			),
			
		)
			
	));
	Redux::setSection( $opt_name, array(
			'title' => esc_html__( 'Main Colors', 'redux-framework-demo' ),
			'id'    => 'main_color',
			'icon'  => 'el el-brush ',
			'fields' 	=> array(
			array(
				'id'		=> 'heading_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Heading Regular Color', 'redux-framework-demo'),
				'default' 	=> '#1e1e1e',
				'validate' 	=> 'color',
			),
			array(
				'id'		=> 'heading_h_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Heading Hover Color', 'redux-framework-demo'),
				'default' 	=> '#c00a27',
				'validate' 	=> 'color',
			),
			array(
				'id'		=> 'primary_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Primary Color', 'redux-framework-demo'),
				'default' 	=> '#f0ca6e',
				'validate' 	=> 'color',
			),
			array(
				'id'		=> 'secondary_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Secondary Color', 'redux-framework-demo'),
				'default' 	=> '#c00a27',
				'validate' 	=> 'color',
			),
		)
	));
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Logo', 'redux-framework-demo' ),
        'id'    => 'logo',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-puzzle',
		'fields' 	=> array(
			
			array(
				'id'			=> 'logo_dark',
				'type' 			=> 'media',
				'url'       	=> true,
				'title' 		=> esc_html__('Desktop Logo for Dark Background', 'redux-framework-demo'),
			),
		
			array(
				'id'			=> 'logo_light',
				'type' 			=> 'media',
				'url'      	 	=> true,
				'title' 		=> esc_html__('Desktop Logo for Light Background', 'redux-framework-demo'),
			),
			array(
				'id'			=> 'retina_logo_dark',
				'type' 			=> 'media',
				'url'       	=> true,
				'title' 		=> esc_html__('Retina Logo for Dark Background', 'redux-framework-demo'),
			),
		
			array(
				'id'			=> 'retina_logo_light',
				'type' 			=> 'media',
				'url'      	 	=> true,
				'title' 		=> esc_html__('Retina Logo for Light Background', 'redux-framework-demo'),
			),

			array(
				'id'		=> 'mobile_logo',
				'type' 		=> 'media',
				'url'       => true,
				'title' 	=> esc_html__('Mobile Logo', 'redux-framework-demo'),
			),
		)
	));

	/****************************************************************************************************************************/
	/**************************************************** DESKTOP NAVIGATION ****************************************************/
	/****************************************************************************************************************************/
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Desktop Navigation', 'redux-framework-demo' ),
        'id'    => 'desktop_navigation',
        'icon'  => 'el el-laptop',
		'fields' 	=> array(
			
			
			
			array(
			   	'id' 		=> 'options_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Navigation Options', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
			array(
				'id'		=> 'week_recipe_text',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Week’s Recipe Text', 'redux-framework-demo'),
				'default' 	=> esc_html__('This week’s Recipe', 'redux-framework-demo'),
			),
			
			array(
				'id'       		=> 'week_recipe_post',
				'type'     		=> 'select',
				'multi'     	=> true,
				'placeholder' 	=> esc_html__('Choose Post', 'redux-framework-demo'),
				'title'			=> esc_html__('Choose Week’s Recipe', 'redux-framework-demo'),
				'options'  		=> $allRecipePosts
			),
			
			
			array(
				'id'		=> 'nav_skin',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('Global Navigation Skin', 'redux-framework-demo'),
				'default' 	=> 'light',
				'options' 	=> array(
								'dark'  		=> esc_html__('Dark', 'redux-framework-demo'),
								'light'  		=> esc_html__('Light', 'redux-framework-demo'),
				),
			),
			
			
			
			array(
			   	'id' 		=> 'options_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
			
			
		)
    ));
	
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Mobile Navigation', 'redux-framework-demo' ),
        'id'    => 'mobile_navigation',
        'icon'  => 'el el-phone',
		'fields' 	=> array(
			
			array(
				'id'		=> 'mobile_menu_autocollapse',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('Autocollapse Menu on Click', 'redux-framework-demo'),
				'default' 	=> 'disable',
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'),
								'disable'  		=> esc_html__('Disabled', 'redux-framework-demo')),
			),
			array(
				'id'		=> 'mobile_menu_open_default',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('Menu Open Default', 'redux-framework-demo'),
				'default' 	=> 'disable',
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'),
								'disable'  		=> esc_html__('Disabled', 'redux-framework-demo')),
			),
			
			array(
			   	'id' 		=> 'mob_nav_skin_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Colors', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
				array(
					'id'		=> 'mob_nav_bg_color',
					'type' 		=> 'color',
					'transparent' => false,
					'title' 	=> esc_html__('Background Color', 'redux-framework-demo'),
					'default' 	=> '#0f0f16',
					'validate' 	=> 'color',
				),
				array(
					'id'		=> 'mob_nav_hamb_color',
					'type' 		=> 'color',
					'transparent' => false,
					'title' 	=> esc_html__('Hamburger Color', 'redux-framework-demo'),
					'default' 	=> '#ccc',
					'validate' 	=> 'color',
				),
				array(
					'id'		=> 'mob_nav_ddbg_color',
					'type' 		=> 'color',
					'transparent' => false,
					'title' 	=> esc_html__('Dropdown Background Color', 'redux-framework-demo'),
					'default' 	=> '#c00a27',
					'validate' 	=> 'color',
				),
				array(
					'id'		=> 'mob_nav_ddlink_color',
					'type' 		=> 'color',
					'transparent' => false,
					'title' 	=> esc_html__('Dropdown Link Regular Color', 'redux-framework-demo'),
					'default' 	=> '#eee',
					'validate' 	=> 'color',
				),
				array(
					'id'		=> 'mob_nav_ddlink_ha_color',
					'type' 		=> 'color',
					'transparent' => false,
					'title' 	=> esc_html__('Dropdown Link Hover & Active Color', 'redux-framework-demo'),
					'default' 	=> '#fff',
					'validate' 	=> 'color',
				),
			array(
				'id'     	=> 'nav_custom_skin_end',
				'type'   	=> 'section',
				'indent' 	=> false,
			),
		)

	));
	
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Right Bar', 'redux-framework-demo' ),
        'id'    => 'right_bar',
        'icon'  => 'el el-lines',
		'fields' 	=> array(
			
			array(
				'id'		=> 'mobile_menu_autocollapse',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('Autocollapse Menu on Click', 'redux-framework-demo'),
				'default' 	=> 'disable',
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'),
								'disable'  		=> esc_html__('Disabled', 'redux-framework-demo')),
			),
			
			array(
			   	'id' 		=> 'nav_social_section_start',
			   	'type' 		=> 'section',
				'title' 	=> esc_html__('Social Icons', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
			array(
				'id'       => 'social_position',
				'type'     => 'sortable',
				'title'    => __('List positions / switcher', 'redux-framework-demo'),
				'subtitle' => __('Define and reorder these however you want.', 'redux-framework-demo'),
				'mode'     => 'checkbox',
				'options'  => array(
					'facebook'     		=> __('Facebook', 'redux-framework-demo'),
					'twitter'     		=> __('Twitter', 'redux-framework-demo'),
					'pinterest'     	=> __('Pinterest', 'redux-framework-demo'),
					'linkedin'     		=> __('Linkedin', 'redux-framework-demo'),
					'behance'     		=> __('Behance', 'redux-framework-demo'),
					'vimeo'      		=> __('Vimeo', 'redux-framework-demo'),
					'google'      		=> __('Google', 'redux-framework-demo'),
					'youtube'      		=> __('Youtube', 'redux-framework-demo'),
					'instagram'      	=> __('Instagram', 'redux-framework-demo'),
					'github'      		=> __('Github', 'redux-framework-demo'),
					'flickr'      		=> __('Flickr', 'redux-framework-demo'),
					'dribbble'      	=> __('Dribbble', 'redux-framework-demo'),
					'dropbox'	      	=> __('Dropbox', 'redux-framework-demo'),
					'paypal'	      	=> __('Paypal', 'redux-framework-demo'),
					'picasa'	      	=> __('Picasa', 'redux-framework-demo'),
					'soundcloud'      	=> __('SoundCloud', 'redux-framework-demo'),
					'whatsapp'	      	=> __('Whatsapp', 'redux-framework-demo'),
					'skype'	      		=> __('Skype', 'redux-framework-demo'),
					'slack'	      		=> __('Slack', 'redux-framework-demo'),
					'wechat'	      	=> __('WeChat', 'redux-framework-demo'),
					'icq'	     	 	=> __('ICQ', 'redux-framework-demo'),
					'rocketchat'   	 	=> __('RocketChat', 'redux-framework-demo'),
					'rocketchat'   	 	=> __('RocketChat', 'redux-framework-demo'),						
					'telegram'	      	=> __('Telegram', 'redux-framework-demo'),
					'vk'		      	=> __('Vkontakte', 'redux-framework-demo'),
					'rss'		      	=> __('RSS', 'redux-framework-demo'),
				),
				// For checkbox mode
				'default' => array(
					'facebook'	=> true,
					'instagram'	=> true,
					'twitter'	=> true,
				),
			),
			array(
				'id'		=> 'facebook_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Facebook URL', 'redux-framework-demo'),
				'default'	=> '#'
			),
			array(
				'id'		=> 'twitter_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Twitter URL', 'redux-framework-demo'),
				'default'	=> '#'
			),
			array(
				'id'		=> 'pinterest_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Pinterest URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'linkedin_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Linkedin URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'behance_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Behance URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'vimeo_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Vimeo URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'google_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Google URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'youtube_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Youtube URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'instagram_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Instagram URL', 'redux-framework-demo'),
				'default'	=> '#'
			),
			array(
				'id'		=> 'github_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Github URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'flickr_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Flickr URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'dribbble_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Dribbble URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'dropbox_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Dropbox URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'paypal_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Paypal URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'picasa_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Picasa URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'soundcloud_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Soundcloud URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'whatsapp_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Whatsapp URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'skype_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Skype URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'slack_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Slack URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'wechat_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Wechat URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'icq_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('ICQ URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'rocketchat_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Rocketchat URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'telegram_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Telegram URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'vk_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Vkontakte URL', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'rss_helpful',
				'type' 		=> 'text',
				'title' 	=> esc_html__('RSS URL', 'redux-framework-demo'),
			),
			
			array(
			   	'id' 		=> 'nav_social_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false
			),
		)

	));


	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Typography', 'redux-framework-demo' ),
        'id'    => 'typography',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-font',
		'fields' 	=> array(
			array(
				'id'		=> 'body_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Body Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the body font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' => false,
				'text-align' => false,
				'default' 	=> array(
					'font-size' 	=> '16px',
					'font-family' 	=> 'Roboto',
					'font-weight' 	=> '400',
				),
			),
			array(
				'id'		=> 'nav_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Desktop Navigation Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the navigation font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' 	=> false,
				'text-align' => false,
				'default' 	=> array(
					'font-size' 	=> '16px',
					'font-family' 	=> 'Raleway',
					'font-weight' 	=> '500',
				),
			),
			array(
				'id'		=> 'nav_mob_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Mobile Navigation Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the navigation font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' 	=> false,
				'text-align' => false,
				'default' 	=> array(
					'font-size' 	=> '18px',
					'font-family' 	=> 'Montserrat',
					'font-weight' 	=> '400',
				),
			),
		
			array(
				'id'		=> 'input_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Input Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the Input font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' 	=> false,
				'text-align' => false,
				'default' 	=> array(
					'font-size' 	=> '14px',
					'font-family' 	=> 'Raleway',
					'font-weight' 	=> '400',
				),
			),
			array(
				'id'		=> 'blockquote_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Blockquote Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the blockquote font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' 	=> false,
				'text-align' => false,
				'default' 	=> array(
					'font-size' 	=> '16px',
					'font-family' 	=> 'Lora',
					'font-weight' 	=> '400',
				),
			),
			array(
				'id'		=> 'heading_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Heading Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the heading font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'color' 	=> false,
				'font-size' => false,
				'text-align' => false,
				'default' 	=> array(
					'font-family' 	=> 'Raleway',
					'font-weight' 	=> '400',
				),
			),
			array(
				'id'		=> 'extra_font',
				'type' 		=> 'typography',
				'title' 	=> esc_html__('Extra Font', 'redux-framework-demo'),
				'subtitle' 	=> esc_html__('Specify the extra font properties.', 'redux-framework-demo'),
				'google' 	=> true,
				'preview'	=> false,
				'line-height'=>false,
				'font-weight'=>false,
				'color' 	=> false,
				'font-size' => false,
				'text-align' => false,
				'default' 	=> array(
					'font-family' 	=> 'Montserrat',
				),
			),
		)
    ));
	
Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Recipe', 'redux-framework-demo' ),
        'id'    => 'recipe',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-leaf',
		'fields' 	=> array(
			
			array(
				'id' 		=> 'recipe_perpage',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Recipe Posts Per Page', 'redux-framework-demo'),
				'default' 	=> "6",
				"min" 		=> "1",
				"step" 		=> "1",
				"max" 		=> "30",
			),
			array(
				'id' 		=> 'recipe_slug',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Recipe Slug', 'frenify-core'),
				'subtitle' 	=> $permalink_description,
				'default' 	=> 'myrecipe',
			),
		
			array(
				'id' 		=> 'recipe_cat_slug',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Recipe Category Slug', 'frenify-core'),
				'subtitle' 	=> $permalink_description,
				'default' 	=> 'myrecipe-cat',
			),
			array(
				'id'		=> 'recipe_archive_title',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Title for Recipe Archive', 'redux-framework-demo'),
				'default'	=> esc_html__('All Recipes', 'redux-framework-demo'),
			),
			
			array(
			   	'id' 		=> 'recipe_diff_section_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Recipe Difficulty Options', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
			array(
				'id'       => 'recipe_position',
				'type'     => 'sortable',
				'title'    => __('Position / switcher', 'redux-framework-demo'),
				'subtitle' => __('Define and reorder these however you want.', 'redux-framework-demo'),
				'mode'     => 'checkbox',
				'options'  => array(
					'easy'     		=> __('Difficulty #1', 'redux-framework-demo'),
					'medium'     	=> __('Difficulty #2', 'redux-framework-demo'),
					'hard'     		=> __('Difficulty #3', 'redux-framework-demo'),
					'professional'  => __('Difficulty #4', 'redux-framework-demo'),
					'ultimate'  	=> __('Difficulty #5', 'redux-framework-demo'),
				),
				// For checkbox mode
				'default' => array(
					'easy'				=> true,
					'medium'			=> true,
					'hard'				=> true,
					'professional'		=> true,
					'ultimate'			=> true,
				),
			),
			array(
				'id'		=> 'recipe_difficulty_easy',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Difficulty #1', 'redux-framework-demo'),
				'default' 	=> esc_html__('Easy', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'recipe_difficulty_medium',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Difficulty #2', 'redux-framework-demo'),
				'default' 	=> esc_html__('Medium', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'recipe_difficulty_hard',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Difficulty #3', 'redux-framework-demo'),
				'default' 	=> esc_html__('Hard', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'recipe_difficulty_professional',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Difficulty #4', 'redux-framework-demo'),
				'default' 	=> esc_html__('Professional', 'redux-framework-demo'),
			),
			array(
				'id'		=> 'recipe_difficulty_ultimate',
				'type' 		=> 'text',
				'title' 	=> esc_html__('Difficulty #5', 'redux-framework-demo'),
				'default' 	=> esc_html__('Ultimate', 'redux-framework-demo'),
			),
			
			array(
				'id'		=> 'recipe_difficulty_easy_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Difficulty #1 Color', 'redux-framework-demo'),
				'default' 	=> '#55ce63',
				'validate' 	=> 'color',
			),
			
			array(
				'id'		=> 'recipe_difficulty_medium_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Difficulty #2 Color', 'redux-framework-demo'),
				'default' 	=> '#bfd430',
				'validate' 	=> 'color',
			),
			
			array(
				'id'		=> 'recipe_difficulty_hard_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Difficulty #3 Color', 'redux-framework-demo'),
				'default' 	=> '#ffba00',
				'validate' 	=> 'color',
			),
			
			array(
				'id'		=> 'recipe_difficulty_professional_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Difficulty #4 Color', 'redux-framework-demo'),
				'default' 	=> '#ff6600',
				'validate' 	=> 'color',
			),
			
			array(
				'id'		=> 'recipe_difficulty_ultimate_color',
				'type' 		=> 'color',
				'transparent' => false,
				'title' 	=> esc_html__('Difficulty #5 Color', 'redux-framework-demo'),
				'default' 	=> '#c00a27',
				'validate' 	=> 'color',
			),
			
			array(
			   	'id' 		=> 'recipe_diff_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
	)
));


Redux::setSection( $opt_name, array(
        'title' => __( 'Share Options', 'redux-framework-demo' ),
        'id'    => 'sharebox',
        'icon'  => 'el el-share-alt',
		'fields' 	=> array(  
			array(
				'id' 		=> 'share_facebook',
				'type' 		=> 'button_set',
				'title' 	=> __('Facebook', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')), 
				'default' 	=> 'enable'
			),
			array(
				'id' 		=> 'share_twitter',
				'type' 		=> 'button_set',
				'title' 	=> __('Twitter', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')), 
				'default' 	=> 'enable'
			),
			array(
				'id' 		=> 'share_google',
				'type' 		=> 'button_set',
				'title' 	=> __('Google Plus', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')), 
				'default' 	=> 'enable'
			),
			array(
				'id' 		=> 'share_pinterest',
				'type' 		=> 'button_set',
				'title' 	=> __('Pinterest', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),
				'default' 	=> 'enable'
			),
			array(
				'id' 		=> 'share_linkedin',
				'type' 		=> 'button_set',
				'title' 	=> __('Linkedin', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),
				'default' 	=> 'disable'
			),
			array(
				'id' 		=> 'share_email',
				'type' 		=> 'button_set',
				'title' 	=> __('Email', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),
				'default' 	=> 'disable'
			),
			array(
				'id' 		=> 'share_vk',
				'type' 		=> 'button_set',
				'title' 	=> __('Vkontakte', 'redux-framework-demo'),
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),
				'default' 	=> 'enable'
			),
		)
    ));
   Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Footer', 'redux-framework-demo' ),
        'id'    => 'footer',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-road',
		'fields' 	=> array(
			array(
				'id'		=> 'footer_switch',
				'type' 		=> 'button_set',
				'title' 	=> esc_html__('Footer', 'redux-framework-demo'),
				'default' 	=> 'enable',
				'options' 	=> array(
								'enable'  		=> esc_html__('Enabled', 'redux-framework-demo'), 
								'disable' 		=> esc_html__('Disabled', 'redux-framework-demo')),			
			),
			
			
			array(
				'id' 		=> 'footer_text',
				'type' 		=> 'textarea',
				'title' 	=> esc_html__('Footer Text', 'redux-framework-demo'),
				'default' 	=> wp_kses_post('Copyright © 2020. Designed by Frenify. Developed with &#10084; in London.'),
				'required' 		=> array(
					array('footer_switch','equals','enable'),
				),
			),
			
		),
	));
	
	
	
	
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Custom CSS', 'redux-framework-demo' ),
        'id'    => 'css',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-css',
		'fields' 	=> array(
			array(
				'id'       => 'custom_css',
				'type'     => 'ace_editor',
				'title'    => __('Custom CSS', 'redux-framework-demo'),
				'subtitle' => __('Paste your CSS code here.', 'redux-framework-demo'),
				'mode'     => 'css',
				'theme'    => 'monokai',
			),
		)
    )); 
	

	$seo_tags = array(	'span' 	=> 'span', 
						'p' 	=> 'p',		
						'h1' 	=> 'H1',		
						'h2' 	=> 'H2',		
						'h3' 	=> 'H3',		
						'h4' 	=> 'H4',		
						'h5' 	=> 'H5',		
						'h6' 	=> 'H6');
	
	
	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'SEO', 'redux-framework-demo' ),
        'id'    => 'seo',
        'desc'  => esc_html__( '', 'redux-framework-demo' ),
        'icon'  => 'el el-signal',
		'fields' 	=> array(
			
			array(
			   	'id' 		=> 'seo_menu_section_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Navigation HTML Tags', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
				array(
					'id'		=> 'seo_menu_recipe_heading',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Recipe Post: Heading', 'redux-framework-demo'),
					'default' 	=> 'span',
					'options' 	=> $seo_tags
				),
				array(
					'id'		=> 'seo_menu_recipe_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Recipe Post: Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
			array(
			   	'id' 		=> 'seo_menu_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
			
			
			
			array(
			   	'id' 		=> 'seo_recipe_post_section_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Recipe Post Single HTML Tags', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
				array(
					'id'		=> 'seo_recipe_post_recipe_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Recipe Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
				array(
					'id'		=> 'seo_recipe_post_related_heading',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Related Posts: Heading', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
				array(
					'id'		=> 'seo_recipe_post_related_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Related Posts: Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
				array(
					'id'		=> 'seo_recipe_post_prevnext_heading',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Previous & Next: Heading', 'redux-framework-demo'),
					'default' 	=> 'p',
					'options' 	=> $seo_tags
				),
				array(
					'id'		=> 'seo_recipe_post_prevnext_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Previous & Next: Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
			
			array(
			   	'id' 		=> 'seo_recipe_post_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
			
			array(
			   	'id' 		=> 'seo_page_section_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Pages HTML Tags', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
				array(
					'id'		=> 'seo_page_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Page Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
			
				array(
					'id'		=> 'seo_404_number',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('404 Page: 404 Text', 'redux-framework-demo'),
					'default' 	=> 'h2',
					'options' 	=> $seo_tags
				),
			
				array(
					'id'		=> 'seo_404_not_found',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('404 Page: Not Found Text', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
			
				array(
					'id'		=> 'seo_404_desc',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('404 Page: Description', 'redux-framework-demo'),
					'default' 	=> 'p',
					'options' 	=> $seo_tags
				),
			
			array(
			   	'id' 		=> 'seo_page_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
			
			
			array(
			   	'id' 		=> 'seo_recipe_search_section_start',
			   	'type' 		=> 'section',
			   	'title' 	=> esc_html__('Recipes page & Recipe Search Page HTML Tags', 'redux-framework-demo'),
			   	'indent' 	=> true,
			),
			
				array(
					'id'		=> 'seo_recipe_search_title',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Recipe Title', 'redux-framework-demo'),
					'default' 	=> 'h3',
					'options' 	=> $seo_tags
				),
			
			
			array(
			   	'id' 		=> 'seo_recipe_search_section_end',
			   	'type' 		=> 'section',
			   	'indent' 	=> false,
			),
		)
    )); 

    /*
     * <--- END SECTIONS
     */

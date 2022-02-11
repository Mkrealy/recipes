<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include opt-in pop-up files
 *
 */
function oih_include_opt_in_pop_up_files() {

	if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/types/pop-up/class-opt-in-outputter-pop-up.php' ) )
		include 'class-opt-in-outputter-pop-up.php';

}
add_action( 'init', 'oih_include_opt_in_pop_up_files' );


/**
 * Register the pop-up opt-in type
 *
 * @param array $opt_in_types
 *
 * @return array
 *
 */
function oih_register_opt_in_type_pop_up( $opt_in_types = array() ) {

	if( ! is_array( $opt_in_types ) )
		return array();

	$opt_in_types['pop_up'] = array(
		'name' 	=> __( 'Pop-Up', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-pop-up.png'
	);

	return $opt_in_types;

}
add_filter( 'oih_opt_in_types', 'oih_register_opt_in_type_pop_up', 10 );


/**
 * Register the default settings for the opt-in pop-up type
 *
 * @param array $opt_in_types_settings
 *
 * @return array
 *
 */
function oih_register_opt_in_type_settings_pop_up( $opt_in_types_settings = array() ) {

	if( ! is_array( $opt_in_types_settings ) )
		return array();

	$opt_in_type = 'pop_up';

	// Set the pages for the redirect
	$wp_pages = get_posts( array( 'post_type' => 'page', 'numberposts' => -1 ) );

	foreach( $wp_pages as $key => $wp_page ) {

		unset( $wp_pages[$key] );

		$wp_pages[ $wp_page->ID ] = $wp_page->post_title;

	}

	// Set the lists
	$subscriber_lists = array();
	$lists 			  = oih_get_lists();

	foreach( $lists as $list ) {

		$subscriber_lists[ $list->get('id') ] = $list->get('name');

	}


	// Settings for the opt-in
	$opt_in_types_settings[$opt_in_type] = array(

		// General tab
		'general' => array(
			'basics_heading' => array(
				'default' => '<h3>' . __( 'Basics', 'opt-in-hound' ) . '</h3>',
				'type'	  => 'heading'
			),
			'name' 		=> array(
				'name'    => 'name',
				'type' 	  => 'text',
				'default' => __( 'Your opt-in form name', 'opt-in-hound' ),
				'label'   => __( 'Opt-in Name', 'opt-in-hound' )
			),
			'subscriber_lists' => array(
				'name'	  => 'subscriber_lists',
				'type'	  => 'select_multiple',
				'label'	  => __( 'Subscriber Lists', 'opt-in-hound' ),
				'options' => $subscriber_lists,
				'desc'	  => __( 'Select the subscriber lists where you wish to add users that subscribe through this opt-in.', 'opt-in-hound' )
			),
			'active' 	=> array(
				'name'    => 'active',
				'type'	  => 'switch',
				'label'	  => __( 'Active', 'opt-in-hound' ),
				'default' => 1,
				'desc'	  => __( 'If the pop-up is active it will be displayed in the front-end of your website. Test mode overwrites this setting.', 'opt-in-hound' ),
			),
			'test_mode' 	=> array(
				'name'    => 'test_mode',
				'type'	  => 'switch',
				'label'	  => __( 'Test Mode', 'opt-in-hound' ),
				'default' => 1,
				'desc'	  => __( 'When test mode is activated only administrators will see the pop-ups in the front-end of your website.', 'opt-in-hound' ),
				'input_class' => "oih-orange"
			)
		),

		// Content & styles tab
		'content_style' => array(
			'box_content_heading' => array(
				'default' => '<h3>' . __( 'Opt-in Box Content', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'opt_in_image' => array(
				'name'    => 'opt_in_image',
				'type'	  => 'image',
				'label'   => __( 'Opt-in Image', 'opt-in-hound' )
			),
			'opt_in_image_size' => array(
				'name'	  => 'opt_in_image_size',
				'type'	  => 'range',
				'default' => 100,
				'label'	  => __( 'Opt-in Image Size', 'opt-in-hound' ),
				'conditional' 	=> 'opt_in_image',
				'content_after' => '<span>%</span>'
			),
			'opt_in_heading' => array(
				'name'    => 'opt_in_heading',
				'type' 	  => 'editor',
				'default' => '<p style="text-align: center;">' . __( 'So glad to see you sticking around!', 'opt-in-hound' ) . '</p>',
				'label'   => __( 'Opt-in heading', 'opt-in-hound' ),
				'editor_settings' => array( 'media_buttons' => false, 'teeny' => true, 'editor_height' => 60, 'tinymce' => array( 'toolbar1' => 'italic, underline, alignleft, aligncenter, alignright' ), 'quicktags' => false )
			),
			'opt_in_content' => array(
				'name'    => 'opt_in_content',
				'type' 	  => 'editor',
				'default' => '<p style="text-align: center;">' . __( "Want to be the first one to receive the new stuff?", 'opt-in-hound' ) . '</p><p style="text-align: center;">' . __( "Enter your email address below and we'll send you the goodies straight to your inbox.", 'opt-in-hound' ) . '</p>',
				'label'   => __( 'Opt-in content', 'opt-in-hound' ),
				'editor_settings' => array( 'media_buttons' => false, 'textarea_rows' => 7, 'teeny' => true, 'editor_height' => 150 )
			),
			'box_success_heading' => array(
				'default' => '<h3>' . __( 'Opt-in Box Submit Success', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'opt_in_success_type' => array(
				'name'	  => 'opt_in_success_type',
				'type'    => 'select',
				'options' => array(
					'message'  		   => __( 'Display Success Message', 'opt-in-hound' ),
					'redirect_to_page' => __( 'Redirect to a Page', 'opt-in-hound' )
				),
				'label'   => __( 'Success action type', 'opt-in-hound' )
			),
			'opt_in_success_message_heading' => array(
				'name'    => 'opt_in_success_message_heading',
				'type' 	  => 'editor',
				'default' => '<p style="text-align: center;">' . __( 'Thank You For Subscribing', 'opt-in-hound' ) . '</p>',
				'label'   => __( 'Opt-in success heading', 'opt-in-hound' ),
				'editor_settings' => array( 'media_buttons' => false, 'teeny' => true, 'editor_height' => 60, 'tinymce' => array( 'toolbar1' => 'italic, underline, alignleft, aligncenter, alignright' ), 'quicktags' => false ),
				'conditional' 		=> 'opt_in_success_type',
				'conditional_value' => 'message'
			),
			'opt_in_success_message' => array(
				'name'    => 'opt_in_success_message',
				'type' 	  => 'editor',
				'default' => '<p style="text-align: center;">' . __( 'This means the world to us!', 'opt-in-hound' ) . '</p><p style="text-align: center;">' . __( 'Spamming is not included! Pinky promise.', 'opt-in-hound' ) . '</p>',
				'label'   => __( 'Opt-in success message', 'opt-in-hound' ),
				'editor_settings' => array( 'media_buttons' => false, 'textarea_rows' => 7, 'teeny' => true, 'editor_height' => 150 ),
				'conditional' 		=> 'opt_in_success_type',
				'conditional_value' => 'message'
			),
			'opt_in_success_redirect_page_id' => array(
				'name'    => 'opt_in_success_redirect_page_id',
				'type'	  => 'select',
				'options' => $wp_pages,
				'label'	  => __( 'Opt-in success page', 'opt-in-hound' ),
				'conditional' 		=> 'opt_in_success_type',
				'conditional_value' => 'redirect_to_page'
			),
			'box_setup_heading' => array(
				'default' => '<h3>' . __( 'Opt-in Box Setup', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'opt_in_intro_animation' => array(
				'name'	  => 'opt_in_intro_animation',
				'type'	  => 'select',
				'options' => array(
					'fade_in' 	   => __( 'Fade In', 'opt-in-hound' ),
					'slide_up'	   => __( 'Slide Up', 'opt-in-hound' ),
					'slide_down'   => __( 'Slide Down', 'opt-in-hound' ),
					'scale_up'	   => __( 'Scale Up', 'opt-in-hound' ),
					'scale_down'   => __( 'Scale Down', 'opt-in-hound' )
				),
				'label'	  => __( 'Intro animation', 'opt-in-hound' )
			),
			'opt_in_close_overlay_click' => array(
				'name'    => 'opt_in_close_overlay_click',
				'type'	  => 'switch',
				'label'   => __( 'Close popup on overlay click', 'opt-in-hound' ),
				'desc'    => __( 'If active, when a user clicks anywhere on the pop-up overlay, the pop-up will close.', 'opt-in-hound' )
			),
			'opt_in_close_esc_key' => array(
				'name'    => 'opt_in_close_esc_key',
				'type'	  => 'switch',
				'label'   => __( 'Close popup on ESC key', 'opt-in-hound' ),
				'desc'    => __( 'If active, when a user presses the ESC key of the keyboard, the pop-up will close.', 'opt-in-hound' )
			),
			'form_content_heading' => array(
				'default' => '<h3>' . __( 'Form Setup', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'form_position' => array(
				'name'	  => 'form_position',
				'type'	  => 'select',
				'default' => 'bottom',
				'options' => array(
					'bottom' => __( 'Bottom', 'opt-in-hound' ),
					'right'	 => __( 'Right', 'opt-in-hound' )
				),
				'label'	  => __( 'Form position', 'opt-in-hound' ),
				'input_class'	=> 'oih-medium'
			),
			'form_fields_orientation' => array(
				'name'	  => 'form_fields_orientation',
				'type'	  => 'select',
				'default' => 'stacked',
				'options' => array(
					'inline'  => __( 'Inline Fields', 'opt-in-hound' ),
					'stacked' => __( 'Stacked Fields', 'opt-in-hound' )
				),
				'label'	  => __( 'Form fields orientation', 'opt-in-hound' ),
				'desc'    => __( "If the opt-in's width falls below 500 pixels, the fields automatically stack.", 'opt-in-hound' ),
				'input_class' => 'oih-medium',
				'conditional'   	=> 'form_position',
				'conditional_value' => 'bottom'
			),
			'form_fields' => array(
				'name'	  => 'form_fields',
				'type' 	  => 'checkbox_multiple',
				'options' => array(
					'first_name' => __( 'First Name', 'opt-in-hound' ),
					'last_name'  => __( 'Last Name', 'opt-in-hound' )
				),
				'label'   => __( 'Additional form fields', 'opt-in-hound' )
			),
			'form_field_placeholder_email' => array(
				'name'	  => 'form_field_placeholder_email',
				'type'	  => 'text',
				'default' => __( 'E-mail', 'opt-in-hound' ),
				'label'	  => __( 'E-mail field placeholder', 'opt-in-hound' )
			),
			'form_field_placeholder_first_name' => array(
				'name'	  => 'form_field_placeholder_first_name',
				'type'	  => 'text',
				'default' => __( 'First Name', 'opt-in-hound' ),
				'label'	  => __( 'First Name field placeholder', 'opt-in-hound' ),
				'conditional' => 'form_fields[first_name]'
			),
			'form_field_required_first_name' => array(
				'name'	  => 'form_field_required_first_name',
				'type'	  => 'checkbox',
				'label'	  => __( 'First Name field required', 'opt-in-hound' ),
				'conditional' => 'form_fields[first_name]'
			),
			'form_field_placeholder_last_name' => array(
				'name'	  => 'form_field_placeholder_last_name',
				'type'	  => 'text',
				'default' => __( 'Last Name', 'opt-in-hound' ),
				'label'	  => __( 'Last Name field placeholder', 'opt-in-hound' ),
				'conditional' => 'form_fields[last_name]'
			),
			'form_field_required_last_name' => array(
				'name'	  => 'form_field_required_last_name',
				'type'	  => 'checkbox',
				'label'	  => __( 'Last Name field required', 'opt-in-hound' ),
				'conditional' => 'form_fields[last_name]'
			),
			'form_button_text' => array(
				'name'    => 'form_button_text',
				'type'	  => 'text',
				'default' => __( 'Subscribe', 'opt-in-hound' ),
				'label'	  => __( 'Button text', 'opt-in-hound' )
			),
			'form_footer_text' => array(
				'name'    => 'form_footer_text',
				'type'	  => 'editor',
				'default' => '<p style="text-align: center;">' . __( 'No spam. Pinky promise!', 'opt-in-hound' ) . '</p>',
				'label'   => __( 'Footer text', 'opt-in-hound' ),
				'editor_settings' => array( 'media_buttons' => false, 'teeny' => true, 'editor_height' => 50, 'tinymce' => array( 'toolbar1' => 'italic, underline, alignleft, aligncenter, alignright, link' ), 'quicktags' => false )
			),
			'box_style_heading' => array(
				'default' => '<h3>' . __( 'Opt-in Box Style', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'opt_in_width' => array(
				'name'    => 'opt_in_width',
				'type'	  => 'text',
				'default' => '600',
				'label'	  => __( 'Opt-in box width', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>'
			),
			'opt_in_background_color' => array(
				'name'    => 'opt_in_background_color',
				'type'	  => 'colorpicker',
				'default' => '#fff',
				'label'	  => __( 'Opt-in box background color', 'opt-in-hound' )
			),
			'opt_in_corner_radius' => array(
				'name' 	  => 'opt_in_corner_radius',
				'type'	  => 'text',
				'default' => 4,
				'label'	  => __( 'Opt-in box corner radius', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>'
			),
			'opt_in_heading_color' => array(
				'name'    => 'opt_in_heading_color',
				'type'	  => 'colorpicker',
				'default' => '#000',
				'label'	  => __( 'Opt-in box heading color', 'opt-in-hound' )
			),
			'opt_in_content_color' => array(
				'name'    => 'opt_in_content_color',
				'type'	  => 'colorpicker',
				'default' => '#000',
				'label'	  => __( 'Opt-in box content color', 'opt-in-hound' )
			),
			'form_style_heading' => array(
				'default' => '<h3>' . __( 'Form Style', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'form_background_color' => array(
				'name'    => 'form_background_color',
				'type'	  => 'colorpicker',
				'default' => '#fff',
				'label'	  => __( 'Form background color', 'opt-in-hound' )
			),
			'form_fields_style_heading' => array(
				'default' => '<h3>' . __( 'Form Fields Style', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'form_fields_style_state' => array(
				'name'	  => 'form_fields_style_state',
				'type' 	  => 'radio_element_state',
				'default' => 'normal',
				'options' => array(
					'normal' => __( 'Normal', 'opt-in-hound' ),
					'focus'  => __( 'Focus', 'opt-in-hound' )
				)
			),
			'form_fields_background_color' => array(
				'name'    => 'form_fields_background_color',
				'type'	  => 'colorpicker',
				'default' => '#f1f1f1',
				'label'	  => __( 'Fields background color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'normal'
			),
			'form_fields_background_color_focus' => array(
				'name'    => 'form_fields_background_color_focus',
				'type'	  => 'colorpicker',
				'default' => '#f1f1f1',
				'label'	  => __( 'Fields background color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'focus'
			),
			'form_fields_text_color' => array(
				'name'    => 'form_fields_text_color',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Fields text color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'normal'
			),
			'form_fields_text_color_focus' => array(
				'name'    => 'form_fields_text_color_focus',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Fields text color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'focus'
			),
			'form_fields_border_width' => array(
				'name'    => 'form_fields_border_width',
				'type'	  => 'text',
				'default' => 0,
				'label'	  => __( 'Fields border width', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'normal'
			),
			'form_fields_border_width_focus' => array(
				'name'    => 'form_fields_border_width_focus',
				'type'	  => 'text',
				'default' => 0,
				'label'	  => __( 'Fields border width', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'focus'
			),
			'form_fields_border_color' => array(
				'name'    => 'form_fields_border_color',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Fields border color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'normal'
			),
			'form_fields_border_color_focus' => array(
				'name'    => 'form_fields_border_color_focus',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Fields border color', 'opt-in-hound' ),
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'focus'
			),
			'form_fields_corner_radius' => array(
				'name' 	  => 'form_fields_corner_radius',
				'type'	  => 'text',
				'default' => 4,
				'label'	  => __( 'Fields corner radius', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_fields_style_state',
				'conditional_value' => 'normal'
			),
			'form_button_style_heading' => array(
				'default' => '<h3>' . __( 'Form Button Style', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'form_button_style_state' => array(
				'name'	  => 'form_button_style_state',
				'type' 	  => 'radio_element_state',
				'default' => 'normal',
				'options' => array(
					'normal' => __( 'Normal', 'opt-in-hound' ),
					'hover'  => __( 'Hover', 'opt-in-hound' )
				)
			),
			'form_button_background_color' => array(
				'name'    => 'form_button_background_color',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Button background color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'normal'
			),
			'form_button_background_color_hover' => array(
				'name'    => 'form_button_background_color_hover',
				'type'	  => 'colorpicker',
				'default' => '#263545',
				'label'	  => __( 'Button background color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'hover'
			),
			'form_button_text_color' => array(
				'name'    => 'form_button_text_color',
				'type'	  => 'colorpicker',
				'default' => '#fff',
				'label'	  => __( 'Button text color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'normal'
			),
			'form_button_text_color_hover' => array(
				'name'    => 'form_button_text_color_hover',
				'type'	  => 'colorpicker',
				'default' => '#fff',
				'label'	  => __( 'Button text color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'hover'
			),
			'form_button_border_width' => array(
				'name'    => 'form_button_border_width',
				'type'	  => 'text',
				'default' => 0,
				'label'	  => __( 'Button border width', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'normal'
			),
			'form_button_border_width_hover' => array(
				'name'    => 'form_button_border_width_hover',
				'type'	  => 'text',
				'default' => 0,
				'label'	  => __( 'Button border width', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'hover'
			),
			'form_button_border_color' => array(
				'name'    => 'form_button_border_color',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Button border color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'normal'
			),
			'form_button_border_color_hover' => array(
				'name'    => 'form_button_border_color_hover',
				'type'	  => 'colorpicker',
				'default' => '#34495e',
				'label'	  => __( 'Button border color', 'opt-in-hound' ),
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'hover'
			),
			'form_button_corner_radius' => array(
				'name' 	  => 'form_button_corner_radius',
				'type'	  => 'text',
				'default' => 4,
				'label'	  => __( 'Button corner radius', 'opt-in-hound' ),
				'input_class'	=> 'oih-small',
				'content_after' => '<span>px</span>',
				'conditional' 		=> 'form_button_style_state',
				'conditional_value' => 'normal'
			),
			'custom_css_heading' => array(
				'default' => '<h3>' . __( 'Custom CSS', 'opt-in-hound' ) . '</h3>',
				'type' 	  => 'heading'
			),
			'use_custom_css' => array(
				'name'	  => 'use_custom_css',
				'type'	  => 'switch',
				'label'	  => 'Use Custom CSS'
			),
			'custom_css' => array(
				'name'    => 'custom_css',
				'type'	  => 'textarea',
				'label'	  => __( 'Custom CSS', 'opt-in-hound' )
			)
		)

	);


	// Add display options
	$opt_in_type_settings_display_rules = array(
		'display_rules' => array(
			'default' => '<h3>' . __( 'Display Options', 'opt-in-hound' ) . '</h3>',
			'type' 	  => 'heading'
		),
		'display_rule_homepage' => array(
			'name'	  => 'display_rule_homepage',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Homepage', 'opt-in-hound' )
				)
			)
		),
		'display_rule_posts' => array(
			'name'	  => 'display_rule_posts',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Posts', 'opt-in-hound' )
				),
				'explicit_type' => array(
					'name'	  => 'explicit_type',
					'type'	  => 'select',
					'options' => array(
						'exclude' => __( 'All posts excluding the following', 'opt-in-hound' ),
						'include' => __( 'Only the following posts', 'opt-in-hound' )
					),
					'label'	  => 'Show opt-in for',
					'desc'	  => __( 'List of post ids separated by commas.', 'opt-in-hound' ),
					'conditional' => 'display_rule_posts[enabled]'
				),
				'explicit' => array(
					'name'	  => 'explicit',
					'type'	  => 'text',
					'conditional' => 'display_rule_posts[enabled]'
				)
			)
		),
		'display_rule_pages' => array(
			'name'	  => 'display_rule_pages',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Pages', 'opt-in-hound' )
				),
				'explicit_type' => array(
					'name'	  => 'explicit_type',
					'type'	  => 'select',
					'options' => array(
						'exclude' => __( 'All pages excluding the following', 'opt-in-hound' ),
						'include' => __( 'Only the following pages', 'opt-in-hound' )
					),
					'label'	  => 'Show opt-in for',
					'desc'	  => __( 'List of page ids separated by commas.', 'opt-in-hound' ),
					'conditional' => 'display_rule_pages[enabled]'
				),
				'explicit' => array(
					'name'	  => 'explicit',
					'type'	  => 'text',
					'conditional' => 'display_rule_pages[enabled]'
				)
			)
		)
	);

	// Add trigger options
	$opt_in_type_settings_trigger_rules = array(
		'trigger_rules' => array(
			'default' => '<h3>' . __( 'Trigger Options', 'opt-in-hound' ) . '</h3>',
			'type' 	  => 'heading'
		),
		'trigger_rule_page_load' => array(
			'name'	  => 'trigger_rule_page_load',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'On page load', 'opt-in-hound' )
				)
			)
		),
		'trigger_rule_user_scrolls' => array(
			'name'	  => 'trigger_rule_user_scrolls',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'After user scrolls', 'opt-in-hound' )
				),
				'distance' => array(
					'name'	  => 'distance',
					'type'	  => 'text',
					'default' => 0,
					'label'	  => __( 'Scroll distance (%)', 'opt-in-hound' ),
					'input_class' => 'oih-small',
					'conditional' => 'trigger_rule_user_scrolls[enabled]'
				)
			)
		),
		'trigger_rule_time_on_page' => array(
			'name'	  => 'trigger_rule_time_on_page',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Time on page', 'opt-in-hound' )
				),
				'time' => array(
					'name'	  => 'time',
					'type'	  => 'text',
					'default' => 5,
					'label'	  => __( 'Number of seconds', 'opt-in-hound' ),
					'input_class' => 'oih-small',
					'conditional' => 'trigger_rule_time_on_page[enabled]'
				)
			)
		),
		'trigger_rule_display_per_session' => array(
			'name'	  => 'trigger_rule_display_per_session',
			'type'	  => 'fields_collection',
			'fields'  => array(
				'enabled' => array(
					'name'	  => 'enabled',
					'type'	  => 'switch',
					'label'	  => __( 'Display once per session', 'opt-in-hound' )
				),
				'session_length' => array(
					'name'	  => 'session_length',
					'type'	  => 'text',
					'default' => 3,
					'label'	  => __( 'Session length', 'opt-in-hound' ),
					'input_class' => 'oih-small',
					'content_after' => '<span>days</span>',
					'desc'	  => __( 'The sessions length in days. If you set this value to 3 it means the user will see this pop-up only once every 3 days.', 'opt-in-hound' ),
					'conditional' => 'trigger_rule_display_per_session[enabled]'
				)
			)
		)
	);

	/**
	 * Add custom display rules settings to the opt-in type
	 *
	 * @param array  $opt_in_type_settings_display_rules - the current set of rules
	 * @param string $opt_in_type
	 *
	 */
	$opt_in_type_settings_display_rules = apply_filters( 'oih_opt_in_type_settings_display_rules', $opt_in_type_settings_display_rules, $opt_in_type );

	/**
	 * Add custom display rules settings to the opt-in type
	 *
	 * @param array  $opt_in_type_settings_display_rules - the current set of rules
	 * @param string $opt_in_type
	 *
	 */
	$opt_in_type_settings_trigger_rules = apply_filters( 'oih_opt_in_type_settings_trigger_rules', $opt_in_type_settings_trigger_rules, $opt_in_type );

	// Add the display rules and trigger rules to the display fields section
	$opt_in_types_settings[$opt_in_type]['display'] = array_merge( $opt_in_type_settings_display_rules, $opt_in_type_settings_trigger_rules );


	return $opt_in_types_settings;

}
add_filter( 'oih_opt_in_types_settings', 'oih_register_opt_in_type_settings_pop_up' );


/**
 * Outputs the opt-ins in the footer of the HTML page
 *
 */
function oih_add_opt_ins_pop_up() {

	$opt_ins = oih_get_opt_ins( array( 'type' => 'pop_up' ) );

	foreach( $opt_ins as $opt_in ) {

		$opt_in_outputter = OIH_Opt_In_Outputter_Factory::build( $opt_in );

		if( $opt_in_outputter->meets_display_rules() )
			$opt_in_outputter->render_template();

	}

}
add_action( 'wp_footer', 'oih_add_opt_ins_pop_up' );
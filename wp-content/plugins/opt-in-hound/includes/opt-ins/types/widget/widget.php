<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Include opt-in widget files
 *
 */
function oih_include_opt_in_widget_files() {

	if( file_exists( OIH_PLUGIN_DIR . 'includes/opt-ins/types/widget/class-wp-opt-in-widget.php' ) )
		include 'class-wp-opt-in-widget.php';

}
add_action( 'widgets_init', 'oih_include_opt_in_widget_files' );


/**
 * Register the widget opt-in type
 *
 * @param array $opt_in_types
 *
 * @return array
 *
 */
function oih_register_opt_in_type_widget( $opt_in_types = array() ) {

	if( ! is_array( $opt_in_types ) )
		return array();

	$opt_in_types['widget'] = array(
		'name'  => __( 'Widget', 'opt-in-hound' ),
		'image'	=> OIH_PLUGIN_DIR_URL . 'assets/img/opt-in-icon-widget.png'
	);

	return $opt_in_types;

}
add_filter( 'oih_opt_in_types', 'oih_register_opt_in_type_widget', 20 );


/**
 * Register the default settings for the opt-in widget type
 *
 * @param array $opt_in_types_settings
 *
 * @return array
 *
 */
function oih_register_opt_in_type_settings_widget( $opt_in_types_settings = array() ) {

	if( ! is_array( $opt_in_types_settings ) )
		return array();

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
	$opt_in_types_settings['widget'] = array(

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
				'desc'	  => __( 'If the widget is active it will be displayed in the front-end of your website. Test mode overwrites this setting.', 'opt-in-hound' ),
			),
			'test_mode' 	=> array(
				'name'    => 'test_mode',
				'type'	  => 'switch',
				'label'	  => __( 'Test Mode', 'opt-in-hound' ),
				'default' => 1,
				'desc'	  => __( 'When test mode is activated only administrators will see the widgets in the front-end of your website.', 'opt-in-hound' ),
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
			'opt_in_background_color' => array(
				'name'    => 'opt_in_background_color',
				'type'	  => 'colorpicker',
				'default' => '#f9f9f9',
				'label'	  => __( 'Opt-in box background color', 'opt-in-hound' )
			),
			'opt_in_corner_radius' => array(
				'name' 	  => 'opt_in_corner_radius',
				'type'	  => 'text',
				'default' => 0,
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
				'default' => '#f9f9f9',
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
		),

	);

	return $opt_in_types_settings;

}
add_filter( 'oih_opt_in_types_settings', 'oih_register_opt_in_type_settings_widget' );
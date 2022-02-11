<?php
if ( defined( 'ABSPATH' ) && ! defined( 'RWMB_VER' ) ) {
	require_once dirname( __FILE__ ) . '/inc/loader.php';
	$loader = new RWMB_Loader();
	$loader->init();
}

/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign

$prefix = 'becipe_fn_';
global $meta_boxes, $becipe_fn_option;
$meta_boxes = array();




$ffn_nav_skin 	 		= array('type'		=> 'custom-html');

if(isset($becipe_fn_option['nav_skin'])){

	$ffn_nav_skin = array(
		'name'		=> esc_html__('Navigation Skin', 'becipe'),
		'id'		=> $prefix . "page_nav_color",
		'type'		=> 'select',
		'options'	=> array(
			'default'  		=> esc_html__('Default (from theme options)', 'becipe'),
			'dark'  		=> esc_html__('Dark', 'becipe'),
			'light'  		=> esc_html__('Light', 'becipe'),
		),
		'multiple'	=> false,
		'std'		=> 'default'
	);
}

$special_heading 		= array('type'		=> 'custom-html');
$special_option1 		= array('type'		=> 'custom-html');
$special_option2 		= array('type'		=> 'custom-html');
$special_option3 		= array('type'		=> 'custom-html');
$special_option4 		= array('type'		=> 'custom-html');

if(isset($becipe_fn_option)){

	$special_heading = array(
		'name'		=> esc_html__('Special Options', 'becipe'),
		'type'		=> 'heading',
	);
	$special_option1 = array(
		'name'		=> esc_html__('Featured Post', 'becipe'),
		'id'		=> $prefix . "page_special_featured",
		'type'		=> 'checkbox',
		'std'		=> false
	);
	$special_option2 = array(
		'name'		=> esc_html__('Cook Time', 'becipe'),
		'id'		=> $prefix . "page_special_cook_time",
		'type'		=> 'text',
	);
	
	
	$difficulties 	= array();
	if(isset($becipe_fn_option['recipe_position'])){
		$positions = $becipe_fn_option['recipe_position'];
		foreach($positions as $key => $pos){
			$difficulties[$key] = $becipe_fn_option['recipe_difficulty_'.$key];
		}
		if(!empty($difficulties)){
			$special_option3 = array(
				'name'		=> esc_html__('Difficulty', 'becipe'),
				'id'		=> $prefix . "page_special_difficulty",
				'type'		=> 'select',
				'options'	=> $difficulties,
				'multiple'	=> false,
			);
		}
	}
	
	$special_option4 = array(
		'name'		=> esc_html__('Video URL', 'becipe'),
		'id'		=> $prefix . "page_special_video",
		'type'		=> 'text',
	);
}




/* ----------------------------------------------------- */
//  Page Options
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'page_main_options',
	'title' => esc_html__('Page Options', 'becipe'),
	'pages' => array( 'page' ),
	'context' => 'normal',	
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		
		array(
			'name'		=> esc_html__('Page Options', 'becipe'),
			'type'		=> 'heading',
		),
		$ffn_nav_skin,
		array(
			'name'		=> esc_html__('Page Style', 'becipe'),
			'id'		=> $prefix . "page_style",
			'type'		=> 'select',
			'options'	=> array(
				'full'		=> esc_html__('Without Sidebar', 'becipe'),
				'ws'		=> esc_html__('With Sidebar', 'becipe'),

			),
			'multiple'	=> false,
			'std'		=> array( 'full' )
		),
		array(
			'name'		=> esc_html__('Page Title', 'becipe'),
			'id'		=> $prefix . "page_title",
			'type'		=> 'select',
			'options'	=> array(
				'enable'	=> esc_html__('Enable', 'becipe'),
				'disable'	=> esc_html__('Disable', 'becipe'),

			),
			'multiple'	=> false,
			'std'		=> array( 'enable' )
		),
		array(
			'name'		=> esc_html__('Page Contained', 'becipe'),
			'id'		=> $prefix . "page_contained",
			'type'		=> 'select',
			'options'	=> array(
				'enable'	=> esc_html__('Enable', 'becipe'),
				'disable'	=> esc_html__('Disable', 'becipe'),

			),
			'multiple'	=> false,
			'std'		=> array( 'enable' )
		),
		array(
			'name'		=> esc_html__('Page Spacing', 'becipe'),
			'type'		=> 'heading',
		),	

		array(
			'name'		=> esc_html__('Padding Top', 'becipe'),
			'desc'		=> '',
			'id'		=> $prefix . "page_padding_top",
			'type'		=> 'text',
			'size'  	=> 2,
			'std'		=> 0
		),
		array(
			'name'		=> esc_html__('Padding Bottom', 'becipe'),
			'desc'		=> '',
			'id'		=> $prefix . "page_padding_bottom",
			'type'		=> 'text',
			'size'  	=> 2,
			'std'		=> 0
		),

		array(
			'name'		=> esc_html__('Padding Left', 'becipe'),
			'desc'		=> '',
			'id'		=> $prefix . "page_padding_left",
			'type'		=> 'text',
			'size'  	=> 2,
			'std'		=> 0
		),
		array(
			'name'		=> esc_html__('Padding Right', 'becipe'),
			'desc'		=> '',
			'id'		=> $prefix . "page_padding_right",
			'type'		=> 'text',
			'size'  	=> 2,
			'std'		=> 0
		),
	)
);






// GET DEFAULT LAYOUT FROM GLOBAL OPTIONS

/* ----------------------------------------------------- */
//  Page Options for portfolio and service
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'pagecom',
	'title' => esc_html__('Recipe Post Options', 'becipe'),
	'pages' => array( 'becipe-recipe'),
	'context' => 'normal',
	'priority' => 'default',

	// List of meta fields
	'fields' => array(
		array(
			'name'		=> esc_html__('Page Options', 'becipe'),
			'type'		=> 'heading',
		),
		
		$ffn_nav_skin,
		$special_heading,
		$special_option1,
		$special_option2,
		$special_option3,
		$special_option4
	)
);


/* ----------------------------------------------------- */
//  Post Options
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id' => 'frenify-postoption',
	'title' => esc_html__('Post Options', 'becipe'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		
		
		array(
			'name'		=> esc_html__('Page Options', 'becipe'),
			'type'		=> 'heading',
		),
		$ffn_nav_skin,
		
		array(
			'name'		=> esc_html__('Page Style', 'becipe'),
			'id'		=> $prefix . "page_style",
			'type'		=> 'select',
			'options'	=> array(
				'full'		=> esc_html__('Without Sidebar', 'becipe'),
				'ws'		=> esc_html__('With Sidebar', 'becipe'),
				
			),
			'multiple'	=> false,
			'std'		=> array( 'full' )
		),
	)
);




/**************************************************************************/
/*********************								***********************/
/********************* 		META BOX REGISTERING 	***********************/
/*********************								***********************/
/**************************************************************************/

/**
 * Register meta boxes
 *
 * @return void
 */
function becipe_fn_register_meta_boxes()
{
	global $meta_boxes;
	global $becipe_fn_option;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'becipe_fn_register_meta_boxes' );
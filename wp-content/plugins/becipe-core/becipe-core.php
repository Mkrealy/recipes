<?php
/*
Plugin Name: Becipe Core
Plugin URI: https://themeforest.net/item/becipe-recipe-blogging-wordpress-theme/29029917
Description: Becipe Core Plugin for Becipe Theme
Version: 1.3
Author: Frenify
Author URI: http://www.themeforest.net/user/frenify/
*/


 
			
define ( 'BECIPE_CORE_URL', plugin_dir_url(__FILE__) );
define ( 'BECIPE_CORE_SHORTCODE_URL', BECIPE_CORE_URL . 'shortcode/');
define ( 'BECIPE_CORE_VERSION', '1.3'); 
define ( 'BECIPE_PLACEHOLDERS_URL', BECIPE_CORE_URL . 'shortcode/assets/img/placeholders/');
define ( 'BECIPE_CORE_CSS', BECIPE_CORE_URL . 'v--' . BECIPE_CORE_VERSION . '/css/' );
define ( 'BECIPE_CORE_JS', BECIPE_CORE_URL . 'v--' . BECIPE_CORE_VERSION . '/js/' );


// Custom Meta tags for Sharing

add_action('wp_head', 'becipe_fn_open_graph_meta');

function becipe_fn_open_graph_meta(){
	global $post, $becipe_fn_option;
	
	// enable or disable via theme options
	if(isset($becipe_fn_option['open_graph_meta']) && $becipe_fn_option['open_graph_meta'] == 'enable'){
	
		$image = '';
		if(isset($post)){
			if (has_post_thumbnail( $post->ID ) ) {
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$image = esc_attr( $thumbnail_src[0] );
		}}?>

		<meta property="og:title" content="<?php the_title(); ?>" />
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="<?php the_permalink(); ?>" />
		<meta property="og:site_name" content="<?php echo esc_html(get_bloginfo( 'name' )); ?>" />
		<meta property="og:description" content="<?php echo becipe_fn_excerpt(12); ?>" />

		<?php if ( $image != '' ) { ?>
			<meta property="og:image" content="<?php echo esc_url($image); ?>" />
		<?php }
	}
}
		add_action( 'init', 'translation' );
		// Load text domain
		function translation() 
		{
			load_plugin_textdomain( 'frenify-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
/*----------------------------------------------------------------------------*
 * Plugins
 *----------------------------------------------------------------------------*/
	
	if (!class_exists('ReduxFramework') && file_exists(plugin_dir_path(__FILE__) . '/optionpanel/framework.php'))
    {
    	require_once ('optionpanel/framework.php');
 
    }
 
	if (!isset($redux_demo) && file_exists(plugin_dir_path(__FILE__) . '/opt/config.php'))
    {
    	require_once ('opt/config.php');
 
    }

    // Load Theme Options Panel

	include_once(plugin_dir_path( __FILE__ ) . 'shortcode/frel-core.php');
//	include_once(plugin_dir_path( __FILE__ ) . 'opt/config.php');


	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-business-hours.php');		// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-estimate.php');				// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-brochure.php');				// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-about.php');				// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-social.php');				// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-trending-news.php');		// Load Widgets
	include_once( plugin_dir_path( __FILE__ ) . 'inc/widgets/widget-custom-categories.php');	// Load Widgets


	add_filter( 'plugin_row_meta', 'becipe_core_fn_plugin_row_meta', 10, 2 );

 	function becipe_core_fn_plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( 'becipe-core/becipe-core.php' === $plugin_file ) {
			$row_meta = [
				'docs' 		=> '<a href="https://frenify.com/envato/frenify/wp/becipe/doc/" target="_blank">Docs</a>',
				'faq' 		=> '<a href="https://frenify.com/envato/frenify/wp/becipe/doc/#faq" target="_blank">FAQs</a>',
				'changelog' => '<a href="https://frenify.com/envato/frenify/wp/becipe/doc/#changelog" target="_blank">Changelog</a>',
			];

			$plugin_meta = array_merge( $plugin_meta, $row_meta );
		}

		return $plugin_meta;
	}
	add_action( 'after_setup_theme', 'becipe_fn_plugin_setup', 100 );
	function becipe_fn_plugin_setup(){

		// Load Meta Boxes
		include_once(plugin_dir_path( __FILE__ ) . 'inc/meta-box/metabox-config.php');

		// Call to Custom Post types and Functions
		include_once(plugin_dir_path( __FILE__ ) . 'inc/frenify-custompost.php');
		
		// Call to Custom Functions
		include_once(plugin_dir_path( __FILE__ ) . 'inc/frenify_custom_functions.php');
		

	}



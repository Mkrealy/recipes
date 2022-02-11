<?php

// Exit if accessed directly. 
if ( ! defined( 'ABSPATH' ) ) { exit; }


if ( ! class_exists( 'Frel_Core' ) ) 
{
	
	class Frel_Core {
		
		// ---------------------------------------------------------
		// VARIABLES
		// ---------------------------------------------------------
		private static $instance = null;
		
		public $version = '1.0.0.0';
		
		private $plugin_path = null;
		
		
		// ---------------------------------------------------------
		// FUNCTIONS
		// ---------------------------------------------------------
		
		// Disable class cloning
		public function __clone() 
		{

			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'frenify-core' ));

		}
		
		
		// Disable unserializing the class.
		public function __wakeup() 
		{

			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'frenify-core' ));

		}
		
		
		public function __construct() 
		{
			
			$this->includes();
			$this->init_hooks();
			
		
		}
		
		
		// Includes
		public function includes() 
		{

			require_once( __DIR__ . '/frel-plugin.php' );
			require_once( __DIR__ . '/includes/frel-helper.php' );
			require_once( __DIR__ . '/includes/ajax_functions.php' );
		}
		
		
		// Hook into actions and filters.
		private function init_hooks() 
		{

			add_action( 'plugins_loaded', [ $this, 'init' ] );
			
			add_action( 'wp_ajax_nopriv_fn_action_post_terms', 'fn_post_terms' );
			add_action( 'wp_ajax_fn_action_post_terms', 'fn_post_terms' );

		}
		
		
		// Check if elementor exists
		public function init() 
		{
			
			// Check if Elementor installed and actived
//			if ( ! did_action( 'elementor/loaded' ) ) {
//				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
//				return;
//			}
			
			// Frel Classes
			new \Frel\Frel_Plugin();
		}
		
		
		// Warning when the site doesn't have Elementor installed or activated.
		public function admin_notice_missing_main_plugin() 
		{
			$message = sprintf(
				/* translators: 1: Frel 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'frenify-core' ),
				'<strong>' . esc_html__( 'Frel', 'frenify-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'frenify-core' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}
		
		
		
		
		// Returns the instance.
		public static function get_instance() 
		{
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
	}
	
}


if ( ! function_exists( 'frel_load' ) ) 
{
	// Returns instanse of the plugin class.
	function Frel_load() 
	{
		return frel_Core::get_instance();
	}
	
	frel_load();
}
// ---------------------------------------------------------
// REDUX remove demo mode
// ---------------------------------------------------------
function removeDemoModeLinkByFrenify() { 
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
	
}
add_action('init', 'removeDemoModeLinkByFrenify');
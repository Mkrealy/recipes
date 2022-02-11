<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Base class to add custom submenu pages
 *
 */
abstract Class OIH_Submenu_Page {

	/**
	 * The menu page under which the submenu page should be added
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $parent_slug;


	/**
	 * The title of the submenu page
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $page_title;


	/**
	 * The title that should appear in the menu 
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $menu_title;


	/**
	 * The user capability required to view this page
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $capability;


	/**
	 * The menu
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $menu_slug;

	/**
	 * The admin path to the page, used in admin_url
	 *
	 * @var string
	 * @access protected
	 *
	 */
	protected $admin_url;

	protected $admin_notices = array();


	/**
	 * Constructor
	 *
	 */
	public function __construct( $parent_slug = '', $page_title = '', $menu_title = '', $capability = '', $menu_slug = '' ) {

		$this->parent_slug = $parent_slug;
		$this->page_title  = $page_title;
		$this->menu_title  = $menu_title;
		$this->capability  = $capability;
		$this->menu_slug   = $menu_slug;

		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );

		add_action( 'admin_init', array( $this, 'request_listener' ) );

		add_action( 'admin_init', array( $this, 'catch_url_admin_notice' ) );

        add_action( 'admin_notices', array( $this, 'print_admin_notices_messages' ) );

	}


	/**
	 * Getter
	 *
	 * @param string $property
	 *
	 */
	public function get( $property = '' ) {

		if( method_exists( $this, 'get_' . $property ) )
			return $this->{'get_' . $property}();
		else
			return $this->$property;

	}
	

	/**
	 * Callback to add the submenu page
	 *
	 */
	public function add_submenu_page() {

		$hook_sufix = add_submenu_page( $this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( $this, 'output' ) );

		if( $hook_sufix ) {

			$this->admin_url = add_query_arg( array( 'page' => $this->menu_slug ), 'admin.php' );

		}

	}


	/**
	 * Callback for the HTML output for the page
	 *
	 */
	public function output() {}


	/**
	 * Listens for requests and manipulates data accordingly 
	 *
	 */
	public function request_listener() {}


	/**
	 * Adds an admin notice
	 *
	 * @param string $message
	 * @param string $class
	 *
	 */
	public function add_admin_notice( $message = '', $class = '' ) {

		if( empty( $message ) )
			return;

		$this->admin_notices[] = array(
			'message' => $message,
			'class'	  => $class
		);

	}


	/**
     * Catches messages sent through the URL
     *
     */
    public function catch_url_admin_notice() {

    	if( empty( $_GET['page'] ) )
    		return;

    	if( $_GET['page'] !== $this->menu_slug )
    		return;

        if( empty( $_GET['message'] ) )
            return;

        $message_code = (int)$_GET['message'];

        $type = '';
        
        if( isset( $_GET['error'] ) )
            $type = 'error';
        elseif( isset( $_GET['updated'] ) )
            $type = 'updated';

        $message = $this->get_message_by_code( $message_code );
        
        if( ! empty( $message ) )
            $this->add_admin_notice( $message, $type );

    }


    /**
     * Returns a message by the provided code.
     *
     * Should be overwritten by the extending class
     *
     * @param int $code
     *
     * @return string
     *
     */
    protected function get_message_by_code( $code = 0 ) { return ''; }


	/**
     * Method to display the admin notices to the user
     *
     */
    public function print_admin_notices_messages() {

        if( ! isset( $this->admin_notices ) )
            return;

        foreach( $this->admin_notices as $notice ) {
            echo '<div class="' . $notice['class'] . ' notice">';
                echo '<p>' . $notice['message'] . '</p>';
            echo '</div>';
        }

    }

}
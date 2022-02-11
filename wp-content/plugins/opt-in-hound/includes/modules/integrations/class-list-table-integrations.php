<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_WP_List_Table_Integrations extends OIH_WP_List_Table {

	/**
	 * The data of the table
	 *
	 * @access public
	 * @var array
	 *
	 */
	public $data = array();


	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		parent::__construct( array(
			'plural' 	=> 'oih_integrations',
			'singular' 	=> 'oih_integration',
			'ajax' 		=> false
		));

		// Get and set table data
		$this->set_table_data();
		
		// Add column headers and table items
		$this->_column_headers = array( $this->get_columns(), array(), array() );
		$this->items 		   = $this->data;

	}


	/**
	 * Overwrites the parent display of tablenav to display nothing
	 *
	 */
	protected function display_tablenav( $which ) {}


	/**
	 * Returns all the columns for the table
	 *
	 */
	public function get_columns() {

		$columns = array(
			'name' 		  => __( 'Name', 'opt-in-hound' ),
			'status'	  => '',
			'description' => __( 'Description', 'opt-in-hound' )
		);

		/**
		 * Filter the columns of the integrations table
		 *
		 * @param array $columns
		 *
		 */
		return apply_filters( 'oih_list_table_integrations_columns', $columns );

	}


	/**
	 * Gets the integrations data and sets it
	 *
	 */
	private function set_table_data() {

		$integrations = oih_get_available_integrations();

		if( !empty( $integrations ) ) {

			foreach( $integrations as $integration_slug => $integration ) {

				$integration_settings = oih_get_integration_settings( $integration_slug );

				$opt_in_table_row_data = array(
					'slug'				  => $integration_slug,
					'name'				  => $integration['name'],
					'description'		  => $integration['description'],
					'plugin_active' 	  => oih_is_integration_plugin_active( $integration_slug ),
					'integration_enabled' => ( ! empty( $integration_settings['enabled'] ) ? 1 : 0 ),
					'has_settings' 		  => $integration['has_settings']
				);

				$this->data[] = $opt_in_table_row_data;

			}

		}
		
	}


	/**
	 * Returns the HTML that will be displayed in each columns
	 *
	 * @param array $item 			- data for the current row
	 * @param string $column_name 	- name of the current column
	 *
	 * @return string
	 *
	 */
	public function column_default( $item, $column_name ) {

		return isset( $item[ $column_name ] ) ? $item[ $column_name ] : '-';

	}


	/**
	 * Returns the HTML that will be displayed in the "name" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_name( $item ) {

		$name = ( !empty( $item['name'] ) ? $item['name'] : '' );

		if( empty( $item['plugin_active'] ) )
			$output = '<strong class="oih-integration-inactive">' . $name . '</strong>';

		else {

			if( ! empty( $item['has_settings'] ) )
				$name = '<a href="' . add_query_arg( array( 'tab' => 'integrations', 'integration' => $item['slug'] ), oih_get_current_page_url() ) . '">' . $name . '</a>';

			$output = '<strong>' . $name . '</strong>';

		}

		return $output;

	}


	/**
	 * Returns the HTML that will be displayed in the "description" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_description( $item ) {

		$output = '<span ' . ( empty( $item['plugin_active'] ) ? 'class="oih-integration-inactive"' : '' ) . '>' . ( !empty( $item['description'] ) ? $item['description'] : '' ) . '</span>';

		return $output;

	}


	/**
	 * Returns the HTML that will be displayed in the "status" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_status( $item ) {

		if( empty( $item['plugin_active'] ) )
			return '';

		$output = '<span class="oih-item-status oih-item-status-' . ( ! empty( $item['integration_enabled'] ) ? 'active' : 'inactive' ) . '"></span>';

		return $output;

	}


	/**
	 * HTML display when there are no items in the table
	 *
	 */
	public function no_items() {

		echo '<div class="oih-list-table-no-items">';
			echo '<p>' . __( 'Oops... it seems there are no integrations available.', 'opt-in-hound' ) . '</p>';
		echo '</div>';

	}

}
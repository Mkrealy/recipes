<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_WP_List_Table_Opt_Ins extends OIH_WP_List_Table {

	/**
	 * The number of opt-ins that should appear in the table
	 *
	 * @access private
	 * @var int
	 *
	 */
	private $items_per_page;

	/**
	 * The number of the page being displayed by the pagination
	 *
	 * @access private
	 * @var int
	 *
	 */
	private $paged;

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
			'plural' 	=> 'oih_opt_ins',
			'singular' 	=> 'oih_opt_in',
			'ajax' 		=> false
		));

		$this->items_per_page = 10;
		$this->paged 		  = ( ! empty( $_GET['paged'] ) ? (int)$_GET['paged'] : 1 );

		$this->set_pagination_args( array(
            'total_items' => count( oih_get_opt_ins() ),
            'per_page'    => $this->items_per_page
        ));

		// Get and set table data
		$this->set_table_data();
		
		// Add column headers and table items
		$this->_column_headers = array( $this->get_columns(), array(), array() );
		$this->items 		   = $this->data;

	}


	/**
	 * Returns all the columns for the table
	 *
	 */
	public function get_columns() {

		$columns = array(
			'id' 		=> __( 'ID', 'opt-in-hound' ),
			'type'		=> __( 'Type', 'opt-in-hound' ),
			'status'	=> '',
			'name'		=> __( 'Name', 'opt-in-hound' ),
			'actions'	=> ''
		);

		/**
		 * Filter the columns of the opt-ins table
		 *
		 * @param array $columns
		 *
		 */
		return apply_filters( 'oih_list_table_opt_ins_columns', $columns );

	}


	/**
	 * Gets the opt-ins data and sets it
	 *
	 */
	private function set_table_data() {

		$opt_in_args  = array(
			'number' => $this->items_per_page,
			'offset' => ( $this->paged - 1 ) * $this->items_per_page
		);

		$opt_ins 	  = oih_get_opt_ins( $opt_in_args );
		$opt_in_types = oih_get_opt_in_types();

		if( !empty( $opt_ins ) ) {

			foreach( $opt_ins as $opt_in ) {

				$opt_in_type = $opt_in->get('type');
				$opt_in_type = ( ! empty( $opt_in_types[$opt_in_type]['name'] ) ? $opt_in_types[$opt_in_type]['name'] : $opt_in_type );

				$opt_in_table_row_data = array(
					'id'		=> $opt_in->get('id'),
					'type'		=> $opt_in_type,
					'name' 		=> $opt_in->get('name'),
					'active'	=> $opt_in->get('active'),
					'test_mode' => $opt_in->get('test_mode')
				);

				/**
				 * Filter the opt-in row data
				 *
				 * @param array $opt_in_table_row_data
				 * @param OIH_Opt_In 	$opt_in
				 *
				 */
				$opt_in_table_row_data = apply_filters( 'oih_list_table_opt_ins_row_data', $opt_in_table_row_data, $opt_in );

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

		$output = '<strong>' . ( !empty( $item['name'] ) ? $item['name'] : '' ) . '</strong>';

		return $output;

	}


	/**
	 * Returns the HTML that will be displayed in the "type" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_type( $item ) {

		$output = '<strong>' . ( !empty( $item['type'] ) ? $item['type'] : '' ) . '</strong>';

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

		$status = ( ! empty( $item['active'] ) ? 'active' : 'inactive' );
		$status = ( ! empty( $item['test_mode'] ) ? 'test-mode' : $status );

		$output = '<span class="oih-opt-in-' . $status . '"></span>';

		return $output;

	}


	/**
	 * Returns the HTML that will be displayed in the "actions" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_actions( $item ) {

		$output  = '<div class="row-actions">';
			$output .= '<a href="' . add_query_arg( array( 'page' => 'oih-opt-in-forms', 'subpage' => 'edit', 'opt_in_id' => $item['id'] ) , admin_url( 'admin.php' ) ) . '" class="button-secondary">' . __( 'Edit', 'opt-in-hound' ) . '</a>';
			$output .= '<a onclick="return confirm( \'' . __( "Are you sure you want to duplicate this opt-in?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-opt-in-forms', 'opt_in_id' => $item['id'] ) , admin_url( 'admin.php' ) ), 'oih_duplicate_opt_in', 'oih_token' ) . '">' . __( 'Duplicate', 'opt-in-hound' ) . '</a>';
			$output .= '<span class="trash"><a onclick="return confirm( \'' . __( "Are you sure you want to delete this opt-in?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-opt-in-forms', 'opt_in_id' => $item['id'] ) , admin_url( 'admin.php' ) ), 'oih_delete_opt_in', 'oih_token' ) . '" class="submitdelete">' . __( 'Delete', 'opt-in-hound' ) . '</a></span>';
		$output .= '</div>';

		return $output;

	}


	/**
	 * HTML display when there are no items in the table
	 *
	 */
	public function no_items() {

		echo '<div class="oih-list-table-no-items">';
			echo '<p>' . __( 'Oops... it seems there are no opt-ins', 'opt-in-hound' ) . '</p>';
			echo '<a class="button-primary" href="' . add_query_arg( array( 'page' => 'oih-opt-in-forms', 'subpage' => 'add_new' ), $this->admin_url ) . '">' . __( 'Set Up Your First Opt-In', 'opt-in-hound' ) . '</a>';
		echo '</div>';

	}

}
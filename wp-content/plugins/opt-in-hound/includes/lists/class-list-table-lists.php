<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_WP_List_Table_Lists extends OIH_WP_List_Table {

	/**
	 * The number of lists that should appear in the table
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
			'plural' 	=> 'oih_lists',
			'singular' 	=> 'oih_list',
			'ajax' 		=> false
		));

		$this->items_per_page = 20;
		$this->paged 		  = ( ! empty( $_GET['paged'] ) ? (int)$_GET['paged'] : 1 );

		$this->set_pagination_args( array(
            'total_items' => count( oih_get_lists() ),
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
			'id' 		  => __( 'ID', 'opt-in-hound' ),
			'name'		  => __( 'Name', 'opt-in-hound' ),
			'subscribers' => __( 'Subscribers', 'opt-in-hound' ),
			'date'		  => __( 'Date Added', 'opt-in-hound' ),
			'actions'	  => ''
		);

		return apply_filters( 'oih_list_table_lists_columns', $columns );

	}


	/**
	 * Gets the schedules data and sets it
	 *
	 */
	private function set_table_data() {

		$lists_args = array(
			'number' => $this->items_per_page,
			'offset' => ( $this->paged - 1 ) * $this->items_per_page,
			'search' => ( ! empty( $_GET['s'] ) ? $_GET['s'] : '' )
		);

		$lists = oih_get_lists( $lists_args );

		if( ! empty( $lists ) ) {

			$date_format = get_option('date_format');
			$time_format = get_option('time_format');

			$date_time_format = $date_format . ' ' . $time_format;

			foreach( $lists as $list ) {

				$this->data[] = array(
					'id'		  => $list->get('id'),
					'name'  	  => $list->get('name'),
					'subscribers' => count( oih_get_subscribers( array( 'list_id' => $list->get('id') ) ) ),
					'date'		  => date( $date_time_format, strtotime( $list->get('date') ) )
				);

			}

		}
		
	}


	/**
	 * Overwrite the default tablenav elements
	 *
	 */
	protected function display_tablenav( $which ) {

        echo '<div class="oih-tablenav tablenav ' . esc_attr( $which ) . '">';

            $this->extra_tablenav( $which );
            $this->pagination( $which );

            echo '<br class="clear" />';
        echo '</div>';

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

		return ! empty( $item[ $column_name ] ) ? $item[ $column_name ] : '-';

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
	 * Returns the HTML that will be displayed in the "subscribers" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_subscribers( $item ) {

		return ! empty( $item['subscribers'] ) ? (int)$item['subscribers'] : 0;

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
			$output .= '<a href="' . add_query_arg( array( 'page' => 'oih-lists', 'subpage' => 'view_subscribers', 'list_id' => $item['id'] ) , admin_url( 'admin.php' ) ) . '" class="button-primary">' . __( 'View Subscribers', 'opt-in-hound' ) . '</a>';
			$output .= '<a href="' . add_query_arg( array( 'page' => 'oih-lists', 'subpage' => 'edit_list', 'list_id' => $item['id'] ) , admin_url( 'admin.php' ) ) . '" class="button-secondary">' . __( 'Edit', 'opt-in-hound' ) . '</a>';
		$output .= '</div>';

		return $output;

	}


	/**
	 * HTML display when there are no items in the table
	 *
	 */
	public function no_items() {

		echo '<p>' . __( 'No lists found.', 'opt-in-hound' ) . '</p>';

	}

}
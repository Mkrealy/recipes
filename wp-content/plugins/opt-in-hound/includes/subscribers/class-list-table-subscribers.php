<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


Class OIH_WP_List_Table_Subscribers extends OIH_WP_List_Table {

	/**
	 * 
	 *
	 * @access private
	 * @var int
	 *
	 */
	private $list_id;

	/**
	 * The number of subscribers that should appear in the table
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
			'plural' 	=> 'oih_subscribers',
			'singular' 	=> 'oih_subscriber',
			'ajax' 		=> false
		));

		$list_id = ( ! empty( $_GET['list_id'] ) ? (int)$_GET['list_id'] : 0 );

		if( ! empty( $list_id ) ) {

			$this->list_id 		  = $list_id;

			$this->items_per_page = 20;
			$this->paged 		  = ( ! empty( $_GET['paged'] ) ? (int)$_GET['paged'] : 1 );

			$this->set_pagination_args( array(
	            'total_items' => count( oih_get_subscribers( array( 'list_id' => $this->list_id ) ) ),
	            'per_page'    => $this->items_per_page
	        ));

			// Get and set table data
			$this->set_table_data();
			
			// Add column headers and table items
			$this->_column_headers = array( $this->get_columns(), array(), array() );
			$this->items 		   = $this->data;

		}

	}


	/**
	 * Returns all the columns for the table
	 *
	 */
	public function get_columns() {

		$columns = array(
			'email'		 => __( 'E-mail', 'opt-in-hound' ),
			'first_name' => __( 'First Name', 'opt-in-hound' ),
			'last_name'	 => __( 'Last Name', 'opt-in-hound' ),
			'source'	 => __( 'Source' ),
			'date'		 => __( 'Date Added', 'opt-in-hound' ),
			'actions'	 => ''
		);

		return apply_filters( 'oih_list_table_subscribers_columns', $columns );

	}


	/**
	 * Gets the schedules data and sets it
	 *
	 */
	private function set_table_data() {

		$subscriber_args = array(
			'list_id' => $this->list_id,
			'number'  => $this->items_per_page,
			'offset'  => ( $this->paged - 1 ) * $this->items_per_page,
			'search'  => ( ! empty( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '' )
		);

		$subscribers = oih_get_subscribers( $subscriber_args );

		if( ! empty( $subscribers ) ) {

			foreach( $subscribers as $subscriber ) {

				$this->data[] = array(
					'id'		 => $subscriber->get('id'),
					'email' 	 => $subscriber->get('email'),
					'first_name' => $subscriber->get('first_name'),
					'last_name'  => $subscriber->get('last_name'),
					'source'     => $subscriber->get('source'),
					'date'		 => date( oih_get_wp_datetime_format(), strtotime( $subscriber->get('date') ) )
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
	 * Add extra functionality in the extra table navigation
	 *
	 * @param array $which
	 *
	 */
	public function extra_tablenav( $which ) {

		if( $which == 'top' )
			return;

		if( ! empty( $this->data ) )
			echo '<a href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-lists', 'subpage' => 'view_subscribers', 'list_id' => $this->list_id ), 'admin.php' ), 'oih_export_subscribers', 'oih_token' ) . '" class="button-secondary" style="display: inline-block;">' . __( 'Export CSV', 'opt-in-hound' ) . '</a>';

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

		return !empty( $item[ $column_name ] ) ? $item[ $column_name ] : '-';

	}

	/**
	 * Returns the HTML that will be displayed in the "source" column
	 *
	 * @param array $item - data for the current row
	 *
	 * @return string
	 *
	 */
	public function column_source( $item ) {

		$output = '-';

		// Handle built-in opt-in subscriber source output
		if( false !==  strpos( $item['source'], 'opt_in_' ) ) {

			$opt_in_id = (int)str_replace( 'opt_in_' , '', $item['source'] );
			$opt_in    = oih_get_opt_in( $opt_in_id );

			if( ! is_null( $opt_in ) )
				$output = '<a href="' . add_query_arg( array( 'page' => 'oih-opt-in-forms', 'subpage' => 'edit', 'opt_in_id' => $opt_in_id ), admin_url( 'admin.php' ) ) . '"><strong># ' . $opt_in_id . '</strong></a>';

		// Handle other subscriber sources
		} else {

			$source_names = oih_get_subscriber_source_names( $item['source'] );

			$output = '<strong>' . $source_names['short_name'] . '</strong>';

		}

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
			$output .= '<a href="' . add_query_arg( array( 'page' => 'oih-lists', 'subpage' => 'edit_subscriber', 'subscriber_id' => $item['id'] ) , admin_url( 'admin.php' ) ) . '" class="button-secondary">' . __( 'Edit', 'opt-in-hound' ) . '</a>';
			$output .= '<span class="trash"><a onclick="return confirm( \'' . __( "Are you sure you want to delete this subscriber?", "opt-in-hound" ) . ' \' )" href="' . wp_nonce_url( add_query_arg( array( 'page' => 'oih-lists', 'subscriber_id' => $item['id'] ) , admin_url( 'admin.php' ) ), 'oih_delete_subscriber', 'oih_token' ) . '" class="submitdelete">' . __( 'Delete', 'opt-in-hound' ) . '</a></span>';
		$output .= '</div>';

		return $output;

	}


	/**
	 * HTML display when there are no items in the table
	 *
	 */
	public function no_items() {

		echo '<p>' . __( 'No subscribers found.', 'opt-in-hound' ) . '</p>';

	}

}
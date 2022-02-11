<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Subscribers submenu page
 *
 */
Class OIH_Submenu_Page_Lists extends OIH_Submenu_Page {


	/**
     * Returns a message by the provided code.
     *
     * @param int $code
     *
     * @return string
     *
     */
	protected function get_message_by_code( $code = 0 ) {

		$messages = array(
			1 => __( 'List saved successfully.', 'opt-in-hound' ),
			2 => __( 'List deleted successfully.', 'opt-in-hound' ),
			3 => __( 'Subscriber saved successfully.', 'opt-in-hound' ),
			4 => __( 'Subscriber deleted successfully.', 'opt-in-hound' ),
		);

		return ( ! empty( $messages[$code] ) ? $messages[$code] : '' );

	}


	/**
	 * Handles the output for different cases
	 *
	 */
	public function output() {

		if( empty( $_GET['subpage'] ) ) {

			include 'views/view-submenu-page-lists.php';

		} elseif( $_GET['subpage'] == 'add_new_list' ) {

			include 'views/view-submenu-page-lists-subpage-add-list.php';

		} elseif( $_GET['subpage'] == 'edit_list' && ( ! empty( $_GET['list_id'] ) ) ) {

			include 'views/view-submenu-page-lists-subpage-edit-list.php';

		} elseif( $_GET['subpage'] == 'view_subscribers' && ( ! empty( $_GET['list_id'] ) ) ) {

			include 'views/view-submenu-page-lists-subscribers.php';

		} elseif( $_GET['subpage'] == 'add_new_subscriber' ) {

			include 'views/view-submenu-page-lists-subpage-add-edit-subscriber.php';

		} elseif( $_GET['subpage'] == 'edit_subscriber' && ( ! empty( $_GET['subscriber_id'] ) ) ) {

			include 'views/view-submenu-page-lists-subpage-add-edit-subscriber.php';

		} else {

			include 'views/view-submenu-page-lists.php';

		}

	}


	/**
	 * Listen for requests to manipulate list data
	 *
	 */
	public function request_listener() {

		if( empty( $_GET['page'] ) || $_GET['page'] != $this->menu_slug )
			return;

		/**
		 * Set up first list
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_set_up_first_list' ) ) {

			$lists = oih_get_lists( array( 'number' => 1 ) );

			if( ! empty( $lists ) )
				return;

			// Prepare list data
			$list_data = array(
				'name' 		  => __( 'My First List', 'opt-in-hound' ),
				'description' => __( 'This is your first list. You can of course change this information to suit your needs.', 'opt-in-hound' ),
				'date'		  => date( 'Y-m-d H:i:s' )
			);

			// Insert the first list
			$list_id = oih_insert_list( $list_data );

			if( empty( $list_id ) ) {
				$this->add_admin_notice( __( 'Something went wrong. Could not create the list.', 'opt-in-hound' ), 'error' );
				return;
			}


			global $wpdb;

			$db    			   = new OIH_Database();
			$table_subscribers = $wpdb->prefix . $db->get_prefix() . 'subscribers';

			$subscribers = oih_get_subscribers();

			// Update each subscriber and add the created list id if the subscriber doesn't have a list id added
			foreach( $subscribers as $subscriber ) {

				$subscriber_list_id = $subscriber->get('list_id');

				// Skip if the subscriber already has a list id attached
				if( ! empty( $subscriber_list_id ) )
					continue;

				$subscriber_id = $subscriber->get('id');

				// Update the subscriber with the list id
				$wpdb->query( $wpdb->prepare( "UPDATE {$table_subscribers} SET list_id = {$list_id} WHERE 1=%d AND id = {$subscriber_id}", 1 ) );

			}

			wp_redirect( add_query_arg( array( 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
			exit();

		}


		/**
		 * Add new list
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_add_new_list' ) ) {

			$post_fields = stripslashes_deep( $_POST );

			// Check to have name field
			if( empty( $post_fields['name'] ) ) {
				$this->add_admin_notice( __( 'Please add a name for your list.', 'opt-in-hound' ), 'error' );
				return;
			}

			$list_data = array(
				'name'		  => ( ! empty( $post_fields['name'] ) 	  	  ? sanitize_text_field( $post_fields['name'] ) : '' ),
				'description' => ( ! empty( $post_fields['description'] ) ? wp_kses_post( $post_fields['description'] ) : '' ),
				'date'		  => date( 'Y-m-d H:i:s' )
			);

			$list_id = oih_insert_list( $list_data );

			// Redirect to edit screen if all good
			if( ! empty( $list_id ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit_list', 'list_id' => $list_id, 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Edit list
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_edit_list' ) ) {

			$post_fields = stripslashes_deep( $_POST );

			if( empty( $_GET['list_id'] ) ) {
				$this->add_admin_notice( __( 'Something went wrong.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check to have name field
			if( empty( $post_fields['name'] ) ) {
				$this->add_admin_notice( __( 'Please add a name for your list.', 'opt-in-hound' ), 'error' );
				return;
			}

			$list_id = (int)$_GET['list_id'];

			$list_data = array(
				'name'		  => ( ! empty( $post_fields['name'] ) 	  	  ? sanitize_text_field( $post_fields['name'] ) : '' ),
				'description' => ( ! empty( $post_fields['description'] ) ? wp_kses_post( $post_fields['description'] ) : '' )
			);

			$updated = oih_update_list( $list_id, $list_data );

			if( ! empty( $updated ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit_list', 'list_id' => $list_id, 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Delete list
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_delete_list' ) ) {

			if( empty( $_GET['list_id'] ) )
				return;

			$list_id = (int)$_GET['list_id'];

			oih_delete_list( $list_id );

			wp_redirect( add_query_arg( array( 'message' => 2, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
			exit();

		}


		/**
		 * Add new subscriber
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_add_new_subscriber' ) ) {

			$post_fields = stripslashes_deep( $_POST );

			// Check to have email field
			if( empty( $post_fields['email'] ) ) {
				$this->add_admin_notice( __( 'Please add an email address.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check to be valid email address
			if( ! is_email( $post_fields['email'] ) ) {
				$this->add_admin_notice( __( 'The email address is not valid.', 'opt-in-hound' ), 'error' );
				return;	
			}

			// Check to have list id
			if( empty( $post_fields['list_id'] ) ) {
				$this->add_admin_notice( __( 'Something went wrong. Please try again.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check if the list exists
			$list = oih_get_list( (int)$post_fields['list_id'] );

			if( is_null( $list ) ) {
				$this->add_admin_notice( __( 'The list you are trying to add the subscriber to does not exist.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check to see if email already exists
			$subscriber = oih_get_subscriber_by_email( (int)$post_fields['list_id'], trim( $post_fields['email'] ) );

			if( ! is_null( $subscriber ) ) {
				$this->add_admin_notice( __( 'This email address already exists.', 'opt-in-hound' ), 'error' );
				return;	
			}

			$subscriber_data = array(
				'list_id'	 => ( ! empty( $post_fields['list_id'] ) 	? (int)$post_fields['list_id'] : '' ),
				'email'		 => ( ! empty( $post_fields['email'] ) 	    ? sanitize_text_field( $post_fields['email'] ) : '' ),
				'first_name' => ( ! empty( $post_fields['first_name'] ) ? sanitize_text_field( $post_fields['first_name'] ) : '' ),
				'last_name'  => ( ! empty( $post_fields['last_name'] )  ? sanitize_text_field( $post_fields['last_name'] ) : '' ),
				'ip_address' => '',
				'date'		 => date( 'Y-m-d H:i:s' ),
				'source'	 => 'manual'
			);

			$subscriber_id = oih_insert_subscriber( $subscriber_data );

			// Redirect to edit screen if all good
			if( ! empty( $subscriber_id ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit_subscriber', 'subscriber_id' => $subscriber_id, 'message' => 3, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Edit subscriber
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_edit_subscriber' ) ) {

			$post_fields = stripslashes_deep( $_POST );

			if( empty( $_GET['subscriber_id'] ) ) {
				$this->add_admin_notice( __( 'Something went wrong.', 'opt-in-hound' ), 'error' );
				return;
			}

			$subscriber_id = (int)$_GET['subscriber_id'];

			$subscriber_data = array(
				'first_name' => ( ! empty( $post_fields['first_name'] ) ? sanitize_text_field( $post_fields['first_name'] ) : '' ),
				'last_name'  => ( ! empty( $post_fields['last_name'] )  ? sanitize_text_field( $post_fields['last_name'] ) : '' )
			);

			$updated = oih_update_subscriber( $subscriber_id, $subscriber_data );

			if( ! empty( $updated ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit_subscriber', 'subscriber_id' => $subscriber_id, 'message' => 3, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Delete subscriber
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_delete_subscriber' ) ) {

			if( empty( $_GET['subscriber_id'] ) )
				return;

			$subscriber_id = (int)$_GET['subscriber_id'];
			$subscriber    = oih_get_subscriber_by_id( $subscriber_id );

			$list_id	   = $subscriber->get('list_id');

			oih_delete_subscriber( $subscriber_id );

			wp_redirect( add_query_arg( array( 'subpage' => 'view_subscribers', 'list_id' => $list_id, 'message' => 4, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
			exit();

		}


		/**
		 * Export subscribers
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_export_subscribers' ) ) {

			if( empty( $_GET['list_id'] ) )
				return;

			// Get all subscribers
			$subscribers = oih_get_subscribers( array( 'list_id' => (int)$_GET['list_id'] ) );

			if( empty( $subscribers ) )
				return;

			// Force to array
			foreach( $subscribers as $key => $subscriber ) {

				$subscriber_array = $subscriber->to_array();

				// Remove the list id
				unset( $subscriber_array['list_id'] );

				$subscribers[$key] = $subscriber_array;

			}
			

			$csv_file = tmpfile();

			$first_row = true;

		    foreach( $subscribers as $subscriber ) {

		        if ( $first_row ) {
		            fputcsv( $csv_file, array_keys( $subscriber ) );
		            $first_row = false;
		        }

		        fputcsv( $csv_file, array_values( $subscriber ) );
		    }

		    rewind( $csv_file );

		    $filestats 	= fstat( $csv_file );
		    $filesize   = $filestats['size'];
		    $filename	= 'opt-in-hound-subscribers-export-' . date( 'Y-m-d-H-i-s' ) . '.csv';

		    // disable caching
		    $now = gmdate("D, d M Y H:i:s");
		    header("Expires: Tue, 01 Jan 2001 00:00:01 GMT");
		    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		    header("Last-Modified: {$now} GMT");

		    // force download  
		    header("Content-Type: application/force-download");
		    header("Content-Type: application/octet-stream");
		    header("Content-Type: application/download");
		    header('Content-Type: text/x-csv');

		    // disposition / encoding on response body
		    if ( isset( $filename ) && strlen( $filename ) > 0 )
		        header("Content-Disposition: attachment;filename={$filename}");
		    if ( isset( $filesize ) )
		        header("Content-Length: ".$filesize);
		    header("Content-Transfer-Encoding: binary");
		    header("Connection: close");

		    fpassthru( $csv_file );
    		fclose( $csv_file );
    		exit;

		}

	}

}

/**
 * Lists submenu page initializer
 *
 */
function oih_add_submenu_page_lists() {

	new OIH_Submenu_Page_Lists( 'opt-in-hound', __( 'Subscriber Lists', 'opt-in-hound' ), __( 'Subscriber Lists', 'opt-in-hound' ), 'manage_options', 'oih-lists' );

}
add_action( 'init', 'oih_add_submenu_page_lists' );
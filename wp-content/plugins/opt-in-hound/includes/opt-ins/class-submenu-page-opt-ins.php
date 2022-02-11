<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Opt-ins submenu page
 *
 */
Class OIH_Submenu_Page_Opt_Ins extends OIH_Submenu_Page {


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
			1 => __( 'Opt-in saved successfully. If you have any form of caching, please delete the cache in order for the changes to take effect immediately.', 'opt-in-hound' ),
			2 => __( 'Opt-in deleted successfully.', 'opt-in-hound' ),
			3 => __( 'Opt-in successfully duplicated.', 'opt-in-hound' )
		);

		return ( ! empty( $messages[$code] ) ? $messages[$code] : '' );

	}


	/**
	 * Handles the output for different cases
	 *
	 */
	public function output() {

		wp_enqueue_media();

		if( empty( $_GET['subpage'] ) ) {

			include 'views/view-submenu-page-opt-ins.php';

		} elseif( $_GET['subpage'] == 'add_new' && ( empty( $_GET['opt_in_type'] ) ) ) {

			include 'views/view-submenu-page-opt-ins-subpage-add-new-type.php';

		} elseif( $_GET['subpage'] == 'add_new' && ( ! empty( $_GET['opt_in_type'] ) ) ) {

			include 'views/view-submenu-page-opt-ins-subpage-add-edit.php';

		} elseif( $_GET['subpage'] == 'edit' && ( ! empty( $_GET['opt_in_id'] ) ) ) {

			include 'views/view-submenu-page-opt-ins-subpage-add-edit.php';

		} else {

			include 'views/view-submenu-page-opt-ins.php';

		}

	}


	/**
	 * Listen for requests to manipulate opt-in data
	 *
	 */
	public function request_listener() {

		if( empty( $_GET['page'] ) || $_GET['page'] != $this->menu_slug )
			return;
		

		/**
		 * Add new opt-in
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_add_new_opt_in' ) ) {

			$post_fields 	 = stripslashes_deep( $_POST );

			// Check to have name field
			if( empty( $post_fields['name'] ) ) {
				$this->add_admin_notice( __( 'Please name your opt-in.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check to have subscriber lists
			if( empty( $post_fields['subscriber_lists'] ) ) {
				$this->add_admin_notice( __( 'Please select at least one subscriber list.', '' ), 'error' );
				return;
			}
			
			$opt_in_type 	 = ( ! empty( $_GET['opt_in_type'] ) ? sanitize_text_field( $_GET['opt_in_type'] ) : '' );
			$settings_fields = oih_get_opt_in_type_settings( $opt_in_type );

			$active_tab 	 = ( ! empty( $_POST['active_tab'] ) ? sanitize_text_field( $_POST['active_tab'] ) : '' );

			// Grab only the names of the fields and add them to an array
			$opt_in_type_fields = array();

			foreach( $settings_fields as $fields_section_key => $fields_section ) {
				foreach( $fields_section as $field_key => $field ) {

					if( ! isset( $field['name'] ) )
						continue;

					$opt_in_type_fields[ $field_key ] = $field;
					
				}
			}

			$opt_in_type_fields_names = array_keys( $opt_in_type_fields );

			// Remove any fields sent through POST that are not part of the opt-in type fields
			foreach( $post_fields as $key => $value ) {
				
				if( ! in_array( $key, $opt_in_type_fields_names ) )
					unset( $post_fields[$key] );

			}

			// Sanitize fields
			foreach( $post_fields as $key => $value ) {
				
				if( is_array( $value ) ) {

					$value = _oih_array_sanitize_text_field( $value );

				} else {

					if( $opt_in_type_fields[$key]['type'] == 'editor' || $opt_in_type_fields[$key]['type'] == 'textarea' )
						$post_fields[$key] = _oih_sanitize_textarea( $value );
					else
						$post_fields[$key] = sanitize_text_field( $value );

				}

			}

			// Set opt-in data and insert it into the db
			$opt_in_data = array();

			$opt_in_data['name']      = ( ! empty( $post_fields['name'] ) ? $post_fields['name'] : '' );
			$opt_in_data['type']      = $opt_in_type;
			$opt_in_data['active'] 	  = ( ! empty( $post_fields['active'] ) ? $post_fields['active'] : '' );
			$opt_in_data['test_mode'] = ( ! empty( $post_fields['test_mode'] ) ? $post_fields['test_mode'] : '' );

			// Remove the name, active and test_mode from the posted fields
			if( ! empty( $post_fields['name'] ) )
				unset( $post_fields['name'] );

			if( ! empty( $post_fields['active'] ) )
				unset( $post_fields['active'] );

			if( ! empty( $post_fields['test_mode'] ) )
				unset( $post_fields['test_mode'] );

			$opt_in_data['options'] = $post_fields;
			
			// Insert into the db
			$opt_in_id = oih_insert_opt_in( $opt_in_data );

			// Redirect to the edit screen if all good
			if( ! empty( $opt_in_id ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit', 'opt_in_id' => $opt_in_id, 'tab' => $active_tab, 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Edit opt-in
		 *
		 */
		if( ! empty( $_POST['oih_token'] ) && wp_verify_nonce( $_POST['oih_token'], 'oih_edit_opt_in' ) ) {

			$post_fields 	 = stripslashes_deep( $_POST );

			// Check to have name field
			if( empty( $post_fields['name'] ) ) {
				$this->add_admin_notice( __( 'Please name your opt-in.', 'opt-in-hound' ), 'error' );
				return;
			}

			// Check to have subscriber lists
			if( empty( $post_fields['subscriber_lists'] ) ) {
				$this->add_admin_notice( __( 'Please select at least one subscriber list.', '' ), 'error' );
				return;
			}

			$opt_in_id 		 = (int)$_GET['opt_in_id'];
			$opt_in 		 = oih_get_opt_in( $opt_in_id );
			$opt_in_type 	 = $opt_in->get('type');
			$settings_fields = oih_get_opt_in_type_settings( $opt_in_type );

			$active_tab 	 = ( ! empty( $_POST['active_tab'] ) ? sanitize_text_field( $_POST['active_tab'] ) : '' );

			// Grab only the names of the fields and add them to an array
			$opt_in_type_fields = array();

			foreach( $settings_fields as $fields_section_key => $fields_section ) {
				foreach( $fields_section as $field_key => $field ) {

					if( ! isset( $field['name'] ) )
						continue;

					$opt_in_type_fields[ $field_key ] = $field;
					
				}
			}

			$opt_in_type_fields_names = array_keys( $opt_in_type_fields );

			// Remove any fields sent through POST that are not part of the opt-in type fields
			foreach( $post_fields as $key => $value ) {
				
				if( ! in_array( $key, $opt_in_type_fields_names ) )
					unset( $post_fields[$key] );

			}

			// Sanitize fields
			foreach( $post_fields as $key => $value ) {
				
				if( is_array( $value ) ) {

					$value = _oih_array_sanitize_text_field( $value );

				} else {

					if( $opt_in_type_fields[$key]['type'] == 'editor' || $opt_in_type_fields[$key]['type'] == 'textarea' )
						$post_fields[$key] = _oih_sanitize_textarea( $value );
					else
						$post_fields[$key] = sanitize_text_field( $value );

				}

			}


			// Set opt-in data and insert it into the db
			$opt_in_data = array();

			$opt_in_data['name']      = ( ! empty( $post_fields['name'] ) ? $post_fields['name'] : '' );
			$opt_in_data['type']      = $opt_in_type;
			$opt_in_data['active'] 	  = ( ! empty( $post_fields['active'] ) ? $post_fields['active'] : '' );
			$opt_in_data['test_mode'] = ( ! empty( $post_fields['test_mode'] ) ? $post_fields['test_mode'] : '' );

			// Remove the name, active and test_mode from the posted fields
			if( ! empty( $post_fields['name'] ) )
				unset( $post_fields['name'] );

			if( ! empty( $post_fields['active'] ) )
				unset( $post_fields['active'] );

			if( ! empty( $post_fields['test_mode'] ) )
				unset( $post_fields['test_mode'] );

			$opt_in_data['options'] = $post_fields;

			// Insert into the db
			$updated = oih_update_opt_in( $opt_in->get('id'), $opt_in_data );

			if( ! empty( $updated ) ) {
				wp_redirect( add_query_arg( array( 'subpage' => 'edit', 'opt_in_id' => $opt_in_id, 'tab' => $active_tab, 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
				exit();
			}

		}


		/**
		 * Duplicate opt-in
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_duplicate_opt_in' ) ) {

			if( empty( $_GET['opt_in_id'] ) )
				return;

			$opt_in_id = (int)$_GET['opt_in_id'];

			// Get selected opt-in
			$opt_in 	  = oih_get_opt_in( $opt_in_id );
			$opt_in_array = $opt_in->to_array();

			// Remove the id
			unset( $opt_in_array['id'] );

			// Insert a new one with the same values in the db
			oih_insert_opt_in( $opt_in_array );

			wp_redirect( add_query_arg( array( 'message' => 3, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
			exit();

		}


		/**
		 * Delete opt-in
		 *
		 */
		if( ! empty( $_GET['oih_token'] ) && wp_verify_nonce( $_GET['oih_token'], 'oih_delete_opt_in' ) ) {

			if( empty( $_GET['opt_in_id'] ) )
				return;

			$opt_in_id = (int)$_GET['opt_in_id'];

			oih_delete_opt_in( $opt_in_id );

			wp_redirect( add_query_arg( array( 'message' => 2, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
			exit();

		}

	}

}

/**
 * Opt-ins submenu page initializer
 *
 */
function oih_add_submenu_page_opt_ins() {

	new OIH_Submenu_Page_Opt_Ins( 'opt-in-hound', __( 'Opt-in Forms', 'opt-in-hound' ), __( 'Opt-in Forms', 'opt-in-hound' ), 'manage_options', 'oih-opt-in-forms' );

}
add_action( 'init', 'oih_add_submenu_page_opt_ins' );
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Opt_In_Form_Handler {
	
	/**
	 * Initializes the form handler
	 *
	 */
	public static function init() {

		add_action( 'wp_ajax_oih_opt_in_form_submission', array( 'OIH_Opt_In_Form_Handler', 'handle_form_submission' ) );
		add_action( 'wp_ajax_nopriv_oih_opt_in_form_submission', array( 'OIH_Opt_In_Form_Handler', 'handle_form_submission' ) );

	}


	/**
	 * Handle form submission trough ajax. Adds subscriber to the db if everything is okay
	 *
	 */
	public static function handle_form_submission() {

		if( empty( $_POST['action'] ) || $_POST['action'] !== 'oih_opt_in_form_submission' ) {
			echo json_encode( array( 'error' => self::get_error_message( 'general' ) ) );
			wp_die();
		}

		if( empty( $_POST['opt_in_id'] ) ) {
			echo json_encode( array( 'error' => self::get_error_message( 'general' ) ) );
			wp_die();
		}

		$opt_in_id = (int)$_POST['opt_in_id'];

		if( empty( $_POST['oih_token'] ) || ! wp_verify_nonce( $_POST['oih_token'], 'oih_opt_in_form_subscribe_' . $opt_in_id ) ) {
			echo json_encode( array( 'error' => self::get_error_message( 'general' ) ) );
			wp_die();
		}

		if( true !== ( $error_code = self::validate_fields( $opt_in_id, $_POST ) ) ) {
			echo json_encode( array( 'error' => self::get_error_message( $error_code ) ) );
			wp_die();
		}

		// Get opt-in options
		$opt_in 		= oih_get_opt_in( $opt_in_id );
		$opt_in_options = $opt_in->get('options');

		// Set up subscriber data
		$subscriber_data = array(
			'email'		 => ( ! empty( $_POST['email'] ) 	  ? sanitize_text_field( $_POST['email'] ) : '' ),
			'first_name' => ( ! empty( $_POST['first_name'] ) ? sanitize_text_field( $_POST['first_name'] ) : '' ),
			'last_name'  => ( ! empty( $_POST['last_name'] )  ? sanitize_text_field( $_POST['last_name'] ) : '' ),
			'ip_address' => oih_get_user_ip_address(),
			'date'		 => date( 'Y-m-d H:i:s' ),
			'source'	 => 'opt_in_' . $opt_in_id
		);


		// Insert the subscriber in each list
		$insert_ids = oih_insert_subscriber_in_lists( $opt_in_options['subscriber_lists'], $subscriber_data );


		if( ! empty( $insert_ids ) ) {

			/**
			 * Hook for extra data handling if the subscriber is added successfuly
			 *
			 * @param array $_POST
			 *
			 */
			do_action( 'oih_handle_form_submission_success', $_POST );

			$return = array(
				'success' 	   			=> 1,
				'success_type' 			=> ( ! empty( $opt_in_options['opt_in_success_type'] ) ? $opt_in_options['opt_in_success_type'] : 'message' ),
				'success_redirect_page' => ( ! empty( $opt_in_options['opt_in_success_redirect_page_id'] ) ? get_permalink( (int)$opt_in_options['opt_in_success_redirect_page_id'] ) : '' )
			);

			echo json_encode( $return );

		} else {

			/**
			 * Hook for extra data handling if the subscriber was not added
			 *
			 * @param array $_POST
			 *
			 */
			do_action( 'oih_handle_form_submission_error', $_POST );

			// Return
			echo json_encode( array( 'error' => self::get_error_message( 'general' ) ) );

		}

		wp_die();

	}


	/**
	 * Returns the fields that are required to be completed in the front-end
	 *
	 * @param int $opt_in_id
	 *
	 * @return array
	 *
	 */
	public static function get_required_fields( $opt_in_id ) {

		$fields = array();

		$opt_in 		= oih_get_opt_in( $opt_in_id );
		$opt_in_options = $opt_in->get('options');

		// Add required first name field if set
		if( ! empty( $opt_in_options['form_fields']['first_name'] ) && ! empty( $opt_in_options['form_field_required_first_name'] ) )
			$fields[] = 'first_name';

		// Add required last name field if set
		if( ! empty( $opt_in_options['form_fields']['last_name'] ) && ! empty( $opt_in_options['form_field_required_last_name'] ) )
			$fields[] = 'last_name';

		/**
		 * Modify the required fields array
		 *
		 */
		$fields = apply_filters( 'oih_opt_in_form_required_fields', $fields, $opt_in_id );

		// E-mail is always required
		$fields[] = 'email';

		return $fields;

	}


	/**
	 * Checks to see if required fields are set and also validates each
	 * field individually
	 *
	 * @param int   $opt_in_id
	 * @param array $fields
	 *
	 * @return mixed - bool true | string $error_code
	 *
	 */
	private static function validate_fields( $opt_in_id = 0, $fields = array() ) {

		$error = '';

		// Check required fields
		if( empty( $fields ) )
			return 'fields_required';

		$required_fields = self::get_required_fields( $opt_in_id );

		foreach( $required_fields as $field_name ) {

			if( empty( $fields[$field_name] ) )
				return 'fields_required';

		}

		// Check email field validity
		if( ! is_email( $fields['email'] ) )
			return 'invalid_email';

		// Check opt-in validity
		$opt_in = oih_get_opt_in( $opt_in_id );

		if( is_null( $opt_in ) )
			return 'general';

		// Check lists validity
		$opt_in_options = $opt_in->get('options');

		if( empty( $opt_in_options['subscriber_lists'] ) || ! is_array( $opt_in_options['subscriber_lists'] ) )
			return 'general';

		// Check if already subscibed
		foreach( $opt_in_options['subscriber_lists'] as $list_id ) {

			$subscribers = oih_get_subscribers( array( 'list_id' => $list_id, 'email' => sanitize_text_field( $fields['email'] ) ) );

			if( ! empty( $subscribers ) )
				return 'already_subscribed';

		}

		return true;

	}


	/**
	 * Returns the error message by its code
	 *
	 * @param string $error_code
	 *
	 * @return string
	 *
	 */
	private static function get_error_message( $error_code = '' ) {

		$errors = array(
			'fields_required'    => __( 'Please fill in all the required fields.', 'opt-in-hound' ),
			'invalid_email'	  	 => __( 'The e-mail address introduced is invalid.', 'opt-in-hound' ),
			'already_subscribed' => __( 'The e-mail address introduced is already subscribed.', 'opt-in-hound' ),
			'general'		  	 => __( 'Something went wrong. We could not complete your request.', 'opt-in-hound' )
		);

		$errors = apply_filters( 'oih_opt_in_form_error_messages', $errors );

		return ( ! empty( $errors[ $error_code ] ) ? $errors[ $error_code ] : '' );

	}

}

OIH_Opt_In_Form_Handler::init();
<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Opt_In_Outputter_Type_Pop_Up extends OIH_Opt_In_Outputter_Base {

	protected $_meets_display_rules = null;

	/**
	 * Prints the template into the page
	 *
	 */
	public function render_template() {

		$opt_in_options = $this->_opt_in->get('options');

		$trigger_rules  = $this->build_trigger_data( $this->_trigger_rules );

		$extra_classes  = $this->get_wrapper_extra_classes( $opt_in_options );

		// The pop-up overlay over the body
		$template  = '<div id="opt-in-hound-opt-in-pop-up-overlay-' . esc_attr( $this->_opt_in->get( 'id' ) ) . '" class="opt-in-hound-opt-in-pop-up-overlay" data-id="' . esc_attr( $this->_opt_in->get( 'id' ) ) . '" data-type="' . esc_attr( $this->_opt_in->get( 'type' ) ) . '">';

			// The pop-up wrapper for the template
			$template .= '<div id="opt-in-hound-opt-in-pop-up-' . esc_attr( $this->_opt_in->get( 'id' ) ) . '" class="opt-in-hound-opt-in-pop-up ' . esc_attr( $extra_classes ) . '" data-id="' . esc_attr( $this->_opt_in->get( 'id' ) ) . '" data-type="' . esc_attr( $this->_opt_in->get( 'type' ) ) . '" ' . $trigger_rules . '>';
				$template .= '<a href="#" class="opt-in-hound-opt-in-close opt-in-hound-opt-in-pop-up-close" title="' . __( 'Close', 'opt-in-hound' ) . '"></a>';
				$template .= $this->get_template();
			$template .= '</div>';

		$template .= '</div>';

		echo $template;

	}


	/**
	 * Return extra classes for the pop-up wrapper
	 *
	 * @param array $opt_in_options
	 *
	 * @return string
	 *
	 */
	protected function get_wrapper_extra_classes( $opt_in_options ) {

		$extra_classes = array();

		// Intro animation
		if( ! empty( $opt_in_options['opt_in_intro_animation'] )  )
			$extra_classes[] = 'opt-in-hound-intro-animation-' . str_replace( '_', '-', $opt_in_options['opt_in_intro_animation'] );
		else
			$extra_classes[] = 'opt-in-hound-intro-animation-fade-in';

		// Close pop-up on overlay click
		if( ! empty( $opt_in_options['opt_in_close_overlay_click'] ) )
			$extra_classes[] = 'opt-in-hound-close-overlay-click';

		// Close pop-up on esc key press
		if( ! empty( $opt_in_options['opt_in_close_esc_key'] ) )
			$extra_classes[] = 'opt-in-hound-close-esc-key';

		return implode( ' ', $extra_classes );

	}


	/**
	 * Returns a CSS string with element styles based on the opt-in's options
	 *
	 * @param OIH_Opt_In $opt_in
	 *
	 * @return string
	 *
	 */
	protected function build_styles( $opt_in = null ) {

		if( is_null( $opt_in ) )
			return '';

		$opt_in_options = $opt_in->get('options');

		if( empty( $opt_in_options ) )
			return '';

		// Get styles created by the parent
		$styles = parent::build_styles( $opt_in );

		/**
		 * Box General
		 *
		 */
		$opt_in_wrapper_selector = '#opt-in-hound-opt-in-pop-up-' . $this->_opt_in->get('id');
		$wrapper_styles 		 = '';

		// Pop-up Width
		// The 65 pixels added are due to correct displaying on mobile devices, given that
		// we have box-sizing border-box, with padding left and right that summed up are equal to 65
		if( ! empty( $opt_in_options['opt_in_width'] ) )
			$wrapper_styles .= 'max-width: ' . ( (int)$opt_in_options['opt_in_width'] + 65 ) . 'px;';

		$styles .= $opt_in_wrapper_selector . '{' . $wrapper_styles . '}';

		return $styles;

	}
	

	/**
	 * Returns the concatenated string of trigger HTML custom data
	 *
	 * @param array $trigger_rules
	 *
	 * @return string
	 *
	 */
	protected function build_trigger_data( $trigger_rules = array() ) {

		if( empty( $trigger_rules ) )
			return '';

		$data_attributes = array();

		if( ! empty( $trigger_rules['page_load']['enabled'] ) )
			$data_attributes['page-load'] = 1;

		if( ! empty( $trigger_rules['user_scrolls']['enabled'] ) )
			$data_attributes['user-scrolls'] = ( ! empty( $trigger_rules['user_scrolls']['distance'] ) ? (int)$trigger_rules['user_scrolls']['distance'] : 0 );
		
		if( ! empty( $trigger_rules['time_on_page']['enabled'] ) )
			$data_attributes['time-on-page'] = ( ! empty( $trigger_rules['time_on_page']['time'] ) ? (int)$trigger_rules['time_on_page']['time'] : 0 );

		if( ! empty( $trigger_rules['display_per_session']['enabled'] ) )
			$data_attributes['session-length'] = ( ! empty( $trigger_rules['display_per_session']['session_length'] ) ? (int)$trigger_rules['display_per_session']['session_length'] : 0 );

		/**
		 * Filter the data attributes
		 *
		 * @param array 	 $data_attributes
		 * @param OIH_Opt_In $opt_in
		 *
		 */
		$data_attributes = apply_filters( 'oih_opt_in_outputter_trigger_data_attributes', $data_attributes, $this->_opt_in, $trigger_rules );


		// Transform the array to a string
		if( ! empty( $data_attributes ) ) {

			$data_attributes_string = '';

			foreach( $data_attributes as $key => $val ) {

				$data_attributes_string .= 'data-' . esc_attr( $key ) . '="' . esc_attr( $val ) . '" ';

			}

		} else
			$data_attributes_string = '';

		return $data_attributes_string;

	}

}
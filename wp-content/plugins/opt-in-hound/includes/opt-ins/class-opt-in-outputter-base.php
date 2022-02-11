<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class OIH_Opt_In_Outputter_Base {

	protected $_opt_in;

	protected $_display_rules;

	protected $_trigger_rules;

	protected $_styles;

	protected $_data_attributes;

	protected $_meets_display_rules = true;


	/**
	 * Constructor
	 *
	 * @param OIH_Opt_In $opt_in
	 *
	 */
	public function __construct( OIH_Opt_In $opt_in ) {

		$this->_opt_in = apply_filters( 'oih_opt_in_outputter_opt_in', $opt_in );

		$this->_display_rules   = $this->build_display_rules( $this->_opt_in );
		$this->_trigger_rules   = $this->build_trigger_rules( $this->_opt_in );
//		$this->_styles 		    = $this->build_styles( $this->_opt_in );
		$this->_data_attributes = $this->build_data_attributes( $this->_opt_in );

		if( $this->meets_display_rules() )
			add_action( 'wp_print_footer_scripts', array( $this, 'enqueue_styles' ), 9 );

	}


	/**
	 * Returns the display rules of the opt-in from all the opt-ins options
	 *
	 * @param OIH_Opt_In $opt_in
	 *
	 * @return array
	 *
	 */
	private function build_display_rules( $opt_in = null ) {

		if( is_null( $opt_in ) )
			return array();

		$opt_in_options = $opt_in->get('options');
		
		if( empty( $opt_in_options ) )
			return array();
		
		$rules = array();

		foreach( $opt_in_options as $key => $option ) {

			if( false === strpos( $key, 'display_rule_' ) )
				continue;

			$rules[ str_replace( 'display_rule_', '', $key ) ] = $option;

		}

		return $rules;

	}


	/**
	 * Returns the trigger rules of the opt-in from all the opt-ins options
	 *
	 * @param OIH_Opt_In $opt_in
	 *
	 * @return array
	 *
	 */
	private function build_trigger_rules( $opt_in = null ) {

		if( is_null( $opt_in ) )
			return array();

		$opt_in_options = $opt_in->get('options');

		if( empty( $opt_in_options ) )
			return array();

		
		$rules = array();

		foreach( $opt_in_options as $key => $option ) {

			if( false === strpos( $key, 'trigger_rule_' ) )
				continue;

			$rules[ str_replace( 'trigger_rule_', '', $key ) ] = $option;

		}

		return $rules;

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

		$styles = '';

		/**
		 * Box General
		 *
		 */
		$opt_in_box_selector = '#opt-in-hound-opt-in-' . $this->_opt_in->get('id');
		$box_styles 		 = '';

		// Background color
		if( ! empty( $opt_in_options['opt_in_background_color'] ) )
			$box_styles .= 'background-color: ' . $opt_in_options['opt_in_background_color'] . ';';

		// Border / Corner radius
		if( ! empty( $opt_in_options['opt_in_corner_radius'] ) )
			$box_styles .= 'border-radius: ' . str_replace( 'px' , '', $opt_in_options['opt_in_corner_radius'] ) . 'px;';

		$styles .= $opt_in_box_selector . '{' . $box_styles . '}';

		// Heading color
		if( ! empty( $opt_in_options['opt_in_heading_color'] ) ) {
			$styles .= $opt_in_box_selector . ' .opt-in-hound-opt-in-content-wrapper .opt-in-hound-opt-in-heading { color: ' . $opt_in_options['opt_in_heading_color'] . ';}';
			$styles .= $opt_in_box_selector . ' .opt-in-hound-opt-in-success-message-wrapper .opt-in-hound-opt-in-success-message-heading { color: ' . $opt_in_options['opt_in_heading_color'] . ';}';
		}

		// Content color
		if( ! empty( $opt_in_options['opt_in_content_color'] ) ) {
			$styles .= $opt_in_box_selector . ' .opt-in-hound-opt-in-content-wrapper { color: ' . $opt_in_options['opt_in_content_color'] . ';}';
			$styles .= $opt_in_box_selector . ' .opt-in-hound-opt-in-success-message-wrapper { color: ' . $opt_in_options['opt_in_content_color'] . ';}';
		}

		/**
		 * Box image
		 *
		 */
		if( isset( $opt_in_options['opt_in_image_size'] ) ) {

			$styles .= $opt_in_box_selector . ' .opt-in-hound-opt-in-image-wrapper img { width: ' . (int)$opt_in_options['opt_in_image_size'] . '%;}';

		}


		/**
		 * Form
		 *
		 */
		$form_selector = $opt_in_box_selector . ' .opt-in-hound-opt-in-form-wrapper';

		// Background color
		if( ! empty( $opt_in_options['form_background_color'] ) )
			$styles .= $form_selector . ' { background-color: ' . $opt_in_options['form_background_color'] . ';}';

		/**
		 * Form fields normal state
		 */
		$fields_selector = $form_selector . ' .opt-in-hound-opt-in-form-input input';
		$fields_styles   = '';

		// Fields background color
		if( ! empty( $opt_in_options['form_fields_background_color'] ) )
			$fields_styles .= 'background-color: ' . $opt_in_options['form_fields_background_color'] . ';';

		// Fields text color
		if( ! empty( $opt_in_options['form_fields_text_color'] ) )
			$fields_styles .= 'color: ' . $opt_in_options['form_fields_text_color'] . ';';

		// Fields border/corner radius
		if( ! empty( $opt_in_options['form_fields_corner_radius'] ) )
			$fields_styles .= 'border-radius: ' . str_replace( 'px' , '', $opt_in_options['form_fields_corner_radius'] ) . 'px;';

		// Fields border width
		if( ! empty( $opt_in_options['form_fields_border_width'] ) ) {
			$fields_styles .= 'border-style: solid;';
			$fields_styles .= 'border-width: ' . str_replace( 'px' , '', $opt_in_options['form_fields_border_width'] ) . 'px;';
		}

		// Fields border color
		if( ! empty( $opt_in_options['form_fields_border_color'] ) )
			$fields_styles .= 'border-color: ' . $opt_in_options['form_fields_border_color'] . ';';

		$styles .= $fields_selector . '{' . $fields_styles . '}';

		/**
		 * Form fields focus state
		 */
		$fields_selector = $form_selector . ' .opt-in-hound-opt-in-form-input input:focus';
		$fields_styles   = '';

		// Fields background color
		if( ! empty( $opt_in_options['form_fields_background_color_focus'] ) )
			$fields_styles .= 'background-color: ' . $opt_in_options['form_fields_background_color_focus'] . ';';

		// Fields text color
		if( ! empty( $opt_in_options['form_fields_text_color_focus'] ) )
			$fields_styles .= 'color: ' . $opt_in_options['form_fields_text_color_focus'] . ';';

		// Fields border width
		if( ! empty( $opt_in_options['form_fields_border_width_focus'] ) ) {
			$fields_styles .= 'border-style: solid;';
			$fields_styles .= 'border-width: ' . str_replace( 'px' , '', $opt_in_options['form_fields_border_width_focus'] ) . 'px;';
		}

		// Fields border color
		if( ! empty( $opt_in_options['form_fields_border_color_focus'] ) )
			$fields_styles .= 'border-color: ' . $opt_in_options['form_fields_border_color_focus'] . ';';

		$styles .= $fields_selector . '{' . $fields_styles . '}';


		/**
		 * Form button normal state
		 */
		$button_selector = $form_selector . ' .opt-in-hound-opt-in-form-button button';
		$button_styles   = '';

		// Button background color
		if( ! empty( $opt_in_options['form_button_background_color'] ) )
			$button_styles .= 'background-color: ' . $opt_in_options['form_button_background_color'] . ';';

		// Button text color
		if( ! empty( $opt_in_options['form_button_text_color'] ) )
			$button_styles .= 'color: ' . $opt_in_options['form_button_text_color'] . ';';

		// Button border/corner radius
		if( ! empty( $opt_in_options['form_button_corner_radius'] ) )
			$button_styles .= 'border-radius: ' . str_replace( 'px' , '', $opt_in_options['form_button_corner_radius'] ) . 'px;';

		// Button border width
		if( ! empty( $opt_in_options['form_button_border_width'] ) ) {
			$button_styles .= 'border-style: solid;';
			$button_styles .= 'border-width: ' . str_replace( 'px' , '', $opt_in_options['form_button_border_width'] ) . 'px;';
		}

		// Button border color
		if( ! empty( $opt_in_options['form_button_border_color'] ) )
			$button_styles .= 'border-color: ' . $opt_in_options['form_button_border_color'] . ';';

		$styles .= $button_selector . '{' . $button_styles . '}';

		/**
		 * Form button hover state
		 */
		$button_selector = $form_selector . ' .opt-in-hound-opt-in-form-button button:hover';
		$button_styles   = '';

		// Button hover background color
		if( ! empty( $opt_in_options['form_button_background_color_hover'] ) )
			$button_styles .= 'background-color: ' . $opt_in_options['form_button_background_color_hover'] . ';';

		// Button hover text color
		if( ! empty( $opt_in_options['form_button_text_color_hover'] ) )
			$button_styles .= 'color: ' . $opt_in_options['form_button_text_color_hover'] . ';';

		// Button border width
		if( ! empty( $opt_in_options['form_button_border_width_hover'] ) ) {
			$button_styles .= 'border-style: solid;';
			$button_styles .= 'border-width: ' . str_replace( 'px' , '', $opt_in_options['form_button_border_width_hover'] ) . 'px;';
		}

		// Button border color
		if( ! empty( $opt_in_options['form_button_border_color_hover'] ) )
			$button_styles .= 'border-color: ' . $opt_in_options['form_button_border_color_hover'] . ';';

		$styles .= $button_selector . '{' . $button_styles . '}';
		

		/**
		 * Extra custom CSS
		 *
		 */
		if( ! empty( $opt_in_options['use_custom_css'] ) ) {

			$styles .= $opt_in_options['custom_css'];

		}

		/**
		 * Filter the CSS styles
		 *
		 * @param string 	 $styles
		 * @param OIH_Opt_In $opt_in
		 *
		 */
//		$styles = apply_filters( 'oih_opt_in_outputter_styles', $styles, $this->_opt_in );

//		return $styles;

	}


	/**
	 * Returns a string with custom HTML data attributes based on the opt-in's options
	 *
	 * @param OIH_Opt_In $opt_in
	 *
	 * @return string
	 *
	 */
	protected function build_data_attributes( $opt_in = null ) {

		if( is_null( $opt_in ) )
			return '';

		$data_attributes = array(
			'id'   => $this->_opt_in->get('id'),
			'type' => $this->_opt_in->get('type')
		);

		/**
		 * Filter the data attributes
		 *
		 * @param array 	 $data_attributes
		 * @param OIH_Opt_In $opt_in
		 *
		 */
		$data_attributes = apply_filters( 'oih_opt_in_outputter_data_attributes', $data_attributes, $this->_opt_in );

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


	/**
	 * Checks to see if the opt-in should be inserted into the page
	 *
	 * @return bool
	 *
	 */
	public function meets_display_rules() {

		// If test mode return early for non-admins
		if( $this->_opt_in->get('test_mode') ) {

			if( ! current_user_can( 'manage_options' ) )
				return false;

		} else {

			// If not active return early
			if( ! $this->_opt_in->get('active') )
				return false;

		}


		// If meets display rules is not cached go through the rules validator
		if( $this->_meets_display_rules == null ) {

			// Grab all rule validators
			$rule_validators = array();

			if( ! empty( $this->_display_rules ) ) {
				foreach( $this->_display_rules as $rule_type => $rule_args ) {

					$rule_validator = OIH_Display_Rule_Validator_Factory::build( $rule_type, $rule_args );

					if( is_null( $rule_validator ) )
						continue;

					$rule_validators[] = $rule_validator;

				}
			}

			$display = false;

			// Handle "any" rules case
			foreach( $rule_validators as $rule_validator ) {

				if( $rule_validator->is_strict() )
					continue;

				$display = $display || $rule_validator->is_displayable();

			}

			// Handle "all" rules case
			foreach( $rule_validators as $rule_validator ) {

				if( ! $rule_validator->is_strict() )
					continue;

				$display = $display && $rule_validator->is_displayable();

			}


			// Cache the meets display rules result
			$this->_meets_display_rules = $display;

		}
		
		/**
		 * Add extra display validation rules
		 *
		 * @param bool $meets_display_rules
		 * @param OIH_Opt_In $opt_in
		 *
		 */
		return apply_filters( 'oih_opt_in_outputter_meets_display_rules', $this->_meets_display_rules, $this->_opt_in );

	}


	/**
	 * Returns the HTML template of the opt-in
	 *
	 * @return string
	 *
	 */
	public function get_template() {

		ob_start();

		include OIH_PLUGIN_DIR . 'includes/opt-ins/templates/template-opt-in.php';

		$template = ob_get_contents();

		ob_end_clean();

		return $template;

	}


	/**
	 * Prints the template into the page
	 *
	 */
	public function render_template() {

		echo $this->get_template();

	}


	/**
	 * Injects the custom styles at the bottom of the page
	 *
	 */
	public function enqueue_styles() {

		if( empty( $this->_styles ) )
			return;

		echo '<style id="opt-in-hound-opt-in-styles-' . esc_attr( $this->_opt_in->get('id') ) . '">' . esc_html( $this->_styles ) . '</style>';

	}

}
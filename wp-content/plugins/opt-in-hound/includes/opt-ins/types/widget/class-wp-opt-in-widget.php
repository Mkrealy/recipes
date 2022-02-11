<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates a widget where the admin can select an opt-in form to display
 * in the front-end
 *
 */
class OIH_WP_Opt_In_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		parent::__construct(
			'oih_opt_in_widget',
			__( 'Opt-In Hound Opt-In Widget', 'opt-in-hound' ),
			array( 'description' => __( 'Select an opt-in to display in a widget.', 'opt-in-hound' ) )
		);
		
	}


	/**
	 * Outputs the content of the widget in the front-end
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 */
	public function widget( $args, $instance ) {

		if( empty( $instance['opt_in_id'] ) )
			return;

		$opt_in = oih_get_opt_in( (int)$instance['opt_in_id'] );

		if( is_null( $opt_in ) )
			return;

		$opt_in_outputter = OIH_Opt_In_Outputter_Factory::build( $opt_in );

		if( $opt_in_outputter->meets_display_rules() ) {

			// Echo the beggining of the wrapper
			echo ( ! empty( $args['before_widget'] ) ? $args['before_widget'] : '' );

			// Render the opt-in template
			$opt_in_outputter->render_template();

			// Echo the end of the wrapper
			echo ( ! empty( $args['after_widget'] ) ? $args['after_widget'] : '' );

		}

	}


	/**
	 * Outputs the options form in the back-end
	 *
	 * @param array $instance The widget options
	 *
	 */
	public function form( $instance ) {

		// Set saved values
		$title 			 = ( !empty( $instance['title'] )  ? $instance['title'] : '' );
		$selected_opt_in = ( !empty( $instance['opt_in_id'] ) ? $instance['opt_in_id'] : '' );
		
		// Widget title
		echo '<p>';
			echo '<label class="oih-widget-section-title" for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . __( 'Title:', 'opt-in-hound' ) . '</label>';
			echo '<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" value="' . esc_attr( $title ) . '" />';
		echo '</p>';

		// Widget select opt-in
		$opt_ins = oih_get_opt_ins( array( 'type' => 'widget' ) );
		
		echo '<p>';
			echo '<label class="oih-widget-section-title" for="' . esc_attr( $this->get_field_id( 'opt_in_id' ) ) . '">' . __( 'Opt-In:', 'opt-in-hound' ) . '</label>';
			echo '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'opt_in' ) ) . '" name="' . esc_attr( $this->get_field_name( 'opt_in_id' ) ) . '">';
				echo '<option value="0">' . __( 'Select...', 'opt-in-hound' ) . '</option>';

				if( ! empty( $opt_ins ) ) {
					foreach( $opt_ins as $opt_in ) {
						echo '<option value="' . esc_attr( $opt_in->get('id') ) . '" ' . ( $selected_opt_in == $opt_in->get('id') ? 'selected' : '' ) . '>' . esc_attr( $opt_in->get('name') ) . '</option>';
					}
				}

			echo '</select>';
		echo '</p>';

	}


	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance - The new options
	 * @param array $old_instance - The previous options
	 *
	 */
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] 	   = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['opt_in_id'] = ( ! empty( $new_instance['opt_in_id'] ) ) ? (int)$new_instance['opt_in_id'] : '';

		return $instance;

	}

}

register_widget( "OIH_WP_Opt_In_Widget" );
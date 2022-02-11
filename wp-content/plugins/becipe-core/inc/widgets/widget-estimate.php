<?php

/**
 * Plugin Name: Estimate Widget
 * Description: A widget that show estimate info.
 * Version: 1.0
 * Author: Frenify
 * Author URI: http://themeforest.net/user/frenify
 *
 */


/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Estimate extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'estimate', // Base ID
			esc_html__( 'Frenify Estimate', 'becipe' ), // Name
			array( 'description' => esc_html__( 'A widget that show estimate info.', 'becipe' ), ) // Args
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'Estimate' );
        });
	}
	

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		$estimate_content		= '';
		$estimate_link_text		= '';
		$estimate_link_url		= '';
		$estimate_image_url		= '';
		
		/* Our variables from the widget settings. */
		if ( !empty( $instance[ 'estimate_content' ] ) ) {
			$estimate_content 	= $instance[ 'estimate_content' ];
		}
		if ( !empty( $instance[ 'estimate_link_text' ] ) ) {
			$estimate_link_text = $instance[ 'estimate_link_text' ];
		}
		if ( !empty( $instance[ 'estimate_link_url' ] ) ) {
			$estimate_link_url 	= $instance[ 'estimate_link_url' ];
		}
		if ( !empty( $instance[ 'estimate_image' ] ) ) {
			$estimate_image_url = $instance[ 'estimate_image' ];
		}
		
		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);?>
           	<div class="becipe_fn_widget_estimate">
				<div class="img_holder">
					<span class="helper1"></span>
					<span class="helper2"></span>
					<span class="helper3"></span>
					<span class="helper4"></span>
					<span class="helper5"></span>
					<span class="helper6"></span>
					<div class="abs_img" data-fn-bg-img="<?php echo esc_url($estimate_image_url);?>"></div>
				</div>
				<div class="bfwe_inner">
					<p><?php echo esc_html($estimate_content); ?></p>
                	<a href="<?php echo wp_kses_post($estimate_link_url); ?>"><?php echo wp_kses_post($estimate_link_text); ?></a>
                </div>
            </div>
            
		<?php 
		/* After widget (defined by themes). */
		echo wp_kses_post($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = array();
 
        $instance['estimate_content'] = ( !empty( $new_instance['estimate_content'] ) ) ? strip_tags( $new_instance['estimate_content'] ) : '';
        $instance['estimate_link_text'] = ( !empty( $new_instance['estimate_link_text'] ) ) ? strip_tags( $new_instance['estimate_link_text'] ) : '';
        $instance['estimate_link_url'] = ( !empty( $new_instance['estimate_link_url'] ) ) ? strip_tags( $new_instance['estimate_link_url'] ) : '';
        $instance['estimate_image'] = ( !empty( $new_instance['estimate_image'] ) ) ? strip_tags( $new_instance['estimate_image'] ) : '';
 
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		
		/* Set up some default widget settings. */
		
		$content 	= ! empty( $instance['estimate_content'] ) ? $instance['estimate_content'] : esc_html__('Lets get started! Contact us for a free quote on your next home improvement project.', 'becipe');
		$image 		= ! empty( $instance['estimate_image'] ) ? $instance['estimate_image'] : '';
		$link_text 	= ! empty( $instance['estimate_link_text'] ) ? $instance['estimate_link_text'] : esc_html__('Request an Estimate', 'becipe');
		$link_url 	= ! empty( $instance['estimate_link_url'] ) ? $instance['estimate_link_url'] : '#';
		
		
		?>

		<!-- Widget Title: Text Input -->
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'estimate_image' )); ?>"><?php esc_html_e('Image', 'becipe'); ?></label><br />
            <img src="<?php echo esc_url($image); ?>" class="widefat fn_img"  /><br />
            <input class="fn_widget_add_button" type="button" value="<?php esc_html_e('Add Photo', 'becipe'); ?>" />
			<input type="hidden" class="estimate_image becipe_fn_width100" id="<?php echo esc_attr($this->get_field_id( 'estimate_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'estimate_image' )); ?>" value="<?php echo esc_attr($image); ?>"/>
		</p> 
       <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'estimate_content' )); ?>"><?php esc_html_e('Description', 'becipe'); ?></label><br />
			<textarea id="<?php echo esc_attr($this->get_field_id( 'estimate_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'estimate_content' )); ?>" class="becipe_fn_width100" rows="4" cols="4"><?php echo wp_kses_post($content); ?></textarea>
		</p> 
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'estimate_link_text' )); ?>"><?php esc_html_e('Link Text', 'becipe'); ?></label><br />
			<input id="<?php echo esc_attr($this->get_field_id( 'estimate_link_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'estimate_link_text' )); ?>" value="<?php echo esc_attr($link_text); ?>" class="becipe_fn_width100" />
		</p> 
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'estimate_link_url' )); ?>"><?php esc_html_e('Link URL', 'becipe'); ?></label><br />
			<input id="<?php echo esc_attr($this->get_field_id( 'estimate_link_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'estimate_link_url' )); ?>" value="<?php echo esc_attr($link_url); ?>" class="becipe_fn_width100" />
		</p> 

	<?php
	}
}

$my_widget = new Estimate();
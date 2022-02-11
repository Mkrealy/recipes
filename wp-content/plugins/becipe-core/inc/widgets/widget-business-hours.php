<?php

/**
 * Plugin Name: Business Hours Widget
 * Description: A widget that show business hours of your company.
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
class Businesshours extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'businesshours', // Base ID
			esc_html__( 'Frenify Business Hours', 'becipe' ), // Name
			array( 'description' => esc_html__( 'A widget that displays business hours of your company', 'becipe' ), ) // Args
		);
		add_action( 'widgets_init', function() {
            register_widget( 'Businesshours' );
        });
	}
	

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		/* Our variables from the widget settings. */
		
		$title					= '';
		if ( !empty( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; }
		$title 					= apply_filters(esc_html__('Business Hours', 'becipe'), $title );
		
		$description 			= '';
		$day1 					= '';
		$day1_hours 			= '';
		$day2 					= '';
		$day2_hours 			= '';
		$day3 					= '';
		$day3_hours 			= '';
		$day4 					= '';
		$day4_hours 			= '';
		$day5 					= '';
		$day5_hours 			= '';
		$day6 					= '';
		$day6_hours 			= '';
		$day7 					= '';
		$day7_hours 			= '';
		
		if ( !empty( $instance[ 'description' ] ) ) { $description = $instance[ 'description' ]; }
		
		if ( !empty( $instance[ 'day1' ] ) ) { $day1 = $instance[ 'day1' ]; }
		if ( !empty( $instance[ 'day1_hours' ] ) ) { $day1_hours = $instance[ 'day1_hours' ]; }
		
		if ( !empty( $instance[ 'day2' ] ) ) { $day2 = $instance[ 'day2' ]; }
		if ( !empty( $instance[ 'day2_hours' ] ) ) { $day2_hours = $instance[ 'day2_hours' ]; }
		
		if ( !empty( $instance[ 'day3' ] ) ) { $day3 = $instance[ 'day3' ]; }
		if ( !empty( $instance[ 'day3_hours' ] ) ) { $day3_hours = $instance[ 'day3_hours' ]; }
		
		if ( !empty( $instance[ 'day4' ] ) ) { $day4 = $instance[ 'day4' ]; }
		if ( !empty( $instance[ 'day4_hours' ] ) ) { $day4_hours = $instance[ 'day4_hours' ]; }
		
		if ( !empty( $instance[ 'day5' ] ) ) { $day5 = $instance[ 'day5' ]; }
		if ( !empty( $instance[ 'day5_hours' ] ) ) { $day5_hours = $instance[ 'day5_hours' ]; }
		
		if ( !empty( $instance[ 'day6' ] ) ) { $day6 = $instance[ 'day6' ]; }
		if ( !empty( $instance[ 'day6_hours' ] ) ) { $day6_hours = $instance[ 'day6_hours' ]; }
		
		if ( !empty( $instance[ 'day7' ] ) ) { $day7 = $instance[ 'day7' ]; }
		if ( !empty( $instance[ 'day7_hours' ] ) ) { $day7_hours = $instance[ 'day7_hours' ]; }
		

		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);
		if ( $title ) { echo wp_kses_post($before_title . $title . $after_title);  }?>
           	<div class="becipe_fn_widget_business_hours">
                <div class="fn_desc">
                	<p><?php echo wp_kses_post($description); ?></p>
                </div>
                
                <div class="fn_days">
                	<ul>
                		<?php if($day1 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day1); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day1_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day2 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day2); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day2_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day3 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day3); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day3_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day4 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day4); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day4_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day5 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day5); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day5_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day6 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day6); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day6_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($day7 !== ''){ ?>
                		<li>
                			<div class="day_item">
                				<span class="day"><?php echo wp_kses_post($day7); ?></span>
                				<span class="hours"><?php echo wp_kses_post($day7_hours); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                	</ul>
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
		/* Strip tags for title and name to remove HTML (important for text inputs). */		
		$instance = array();
 
        $instance['title'] 			= ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] 	= ( !empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		
        $instance['day1'] 			= ( !empty( $new_instance['day1'] ) ) ? strip_tags( $new_instance['day1'] ) : '';
        $instance['day1_hours'] 	= ( !empty( $new_instance['day1_hours'] ) ) ? strip_tags( $new_instance['day1_hours'] ) : '';
		
        $instance['day2'] 			= ( !empty( $new_instance['day2'] ) ) ? strip_tags( $new_instance['day2'] ) : '';
        $instance['day2_hours'] 	= ( !empty( $new_instance['day2_hours'] ) ) ? strip_tags( $new_instance['day2_hours'] ) : '';
		
        $instance['day3'] 			= ( !empty( $new_instance['day3'] ) ) ? strip_tags( $new_instance['day3'] ) : '';
        $instance['day3_hours'] 	= ( !empty( $new_instance['day3_hours'] ) ) ? strip_tags( $new_instance['day3_hours'] ) : '';
		
        $instance['day4'] 			= ( !empty( $new_instance['day4'] ) ) ? strip_tags( $new_instance['day4'] ) : '';
        $instance['day4_hours'] 	= ( !empty( $new_instance['day4_hours'] ) ) ? strip_tags( $new_instance['day4_hours'] ) : '';
		
        $instance['day5'] 			= ( !empty( $new_instance['day5'] ) ) ? strip_tags( $new_instance['day5'] ) : '';
        $instance['day5_hours'] 	= ( !empty( $new_instance['day5_hours'] ) ) ? strip_tags( $new_instance['day5_hours'] ) : '';
		
        $instance['day6'] 			= ( !empty( $new_instance['day6'] ) ) ? strip_tags( $new_instance['day6'] ) : '';
        $instance['day6_hours'] 	= ( !empty( $new_instance['day6_hours'] ) ) ? strip_tags( $new_instance['day6_hours'] ) : '';
		
        $instance['day7'] 			= ( !empty( $new_instance['day7'] ) ) ? strip_tags( $new_instance['day7'] ) : '';
        $instance['day7_hours'] 	= ( !empty( $new_instance['day7_hours'] ) ) ? strip_tags( $new_instance['day7_hours'] ) : '';
 
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		
		
		/* Set up some default widget settings. */		
		
		$title 			= ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Business Hours', 'becipe');
		$description 	= ! empty( $instance['description'] ) ? $instance['description'] : '';
		
		$day1 			= ! empty( $instance['day1'] ) ? $instance['day1'] : esc_html__('Monday-Friday:', 'becipe');
		$day1_hours 	= ! empty( $instance['day1_hours'] ) ? $instance['day1_hours'] : esc_html__('9am to 5pm', 'becipe');
		
		$day2 			= ! empty( $instance['day2'] ) ? $instance['day2'] : esc_html__('Saturday:', 'becipe');
		$day2_hours 	= ! empty( $instance['day2_hours'] ) ? $instance['day2_hours'] : esc_html__('10am to 3pm', 'becipe');
		
		$day3 			= ! empty( $instance['day3'] ) ? $instance['day3'] : esc_html__('Sunday:', 'becipe');
		$day3_hours 	= ! empty( $instance['day3_hours'] ) ? $instance['day3_hours'] : esc_html__('Closed', 'becipe');
		
		$day4 			= ! empty( $instance['day4'] ) ? $instance['day4'] : '';
		$day4_hours 	= ! empty( $instance['day4_hours'] ) ? $instance['day4_hours'] : '';
		
		$day5 			= ! empty( $instance['day5'] ) ? $instance['day5'] : '';
		$day5_hours 	= ! empty( $instance['day5_hours'] ) ? $instance['day5_hours'] : '';
		
		$day6 			= ! empty( $instance['day6'] ) ? $instance['day6'] : '';
		$day6_hours 	= ! empty( $instance['day6_hours'] ) ? $instance['day6_hours'] : '';
		
		$day7 			= ! empty( $instance['day7'] ) ? $instance['day7'] : '';
		$day7_hours 	= ! empty( $instance['day7_hours'] ) ? $instance['day7_hours'] : '';

		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'becipe'); ?></label><br />
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="becipe_fn_width100" />
		</p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e('Description', 'becipe'); ?></label><br />
			<textarea id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" class="becipe_fn_width100" rows="6" cols="12"><?php echo wp_kses_post($description); ?></textarea>
		</p>
		
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day1' )); ?>"><?php esc_html_e('Day 1', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day1' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day1' )); ?>" value="<?php echo esc_attr($day1); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day1_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day1_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day1_hours' )); ?>" value="<?php echo esc_attr($day1_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day2' )); ?>"><?php esc_html_e('Day 2', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day2' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day2' )); ?>" value="<?php echo esc_attr($day2); ?>" class="becipe_fn_width100" />
			</p>
		
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day2_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day2_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day2_hours' )); ?>" value="<?php echo esc_attr($day2_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day3' )); ?>"><?php esc_html_e('Day 3', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day3' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day3' )); ?>" value="<?php echo esc_attr($day3); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day3_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day3_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day3_hours' )); ?>" value="<?php echo esc_attr($day3_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day4' )); ?>"><?php esc_html_e('Day 4', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day4' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day4' )); ?>" value="<?php echo esc_attr($day4); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day4_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day4_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day4_hours' )); ?>" value="<?php echo esc_attr($day4_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day5' )); ?>"><?php esc_html_e('Day 5', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day5' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day5' )); ?>" value="<?php echo esc_attr($day5); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day5_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day5_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day5_hours' )); ?>" value="<?php echo esc_attr($day5_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day6' )); ?>"><?php esc_html_e('Day 6', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day6' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day6' )); ?>" value="<?php echo esc_attr($day6); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day6_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day6_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day6_hours' )); ?>" value="<?php echo esc_attr($day6_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_bh_days">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day7' )); ?>"><?php esc_html_e('Day 7', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day7' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day7' )); ?>" value="<?php echo esc_attr($day7); ?>" class="becipe_fn_width100" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'day7_hours' )); ?>"><?php esc_html_e('Hours', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'day7_hours' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'day7_hours' )); ?>" value="<?php echo esc_attr($day7_hours); ?>" class="becipe_fn_width100" />
			</p>
		</div>
	<?php
	}
}
$my_widget = new Businesshours();
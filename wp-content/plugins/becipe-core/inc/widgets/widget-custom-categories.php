<?php

/**
 * Plugin Name: Recipe Categories
 * Description: A widget that show Recipe Categories
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
class Becipe_Custom_Categories extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'Becipe_Custom_Categories', // Base ID
			esc_html__( 'Frenify Custom Categories', 'becipe' ), // Name
			array( 'description' => esc_html__( 'Recipe Categories', 'becipe' ), ) // Args
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'Becipe_Custom_Categories' );
        });
	}
	

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		
		$title		= '';
		$count		= 3;
				
		
		/* Our variables from the widget settings. */
		if ( !empty( $instance[ 'title' ] ) ) { 
			$title 	= $instance[ 'title' ];
		}
		$title 		= apply_filters(esc_html__('Categories', 'becipe'), $title );
		
		if ( !empty( $instance[ 'count' ] ) ) {$count = $instance[ 'count' ];}
		
		$count = (int)$count;
		if($count < 1){
			$count = 1;
		}
		
		
		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);
		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title); 
		}
		
		$list = '';
		$terms = get_terms(array ( 'taxonomy' => 'recipe_category', 'hide_empty' => false, 'parent' => 0, 'orderby' => 'description', 'order' => 'ASC' ));
		if($terms){
			$list .= '<ul>';
			foreach($terms as $key => $term){
				if($key+2 > $count){
					break;
				}
				$name        	= $term->name;
				$term_count		= $term->count;
				$cat_link    	= get_term_link( $term->slug, 'recipe_category' );
				$list .= '<li><a href="'.$cat_link.'">'.$name.'</a><span class="count">'.$term_count.'</span></li>';
			}
			$list .= '</ul>';
		}
		?>
           	<div class="becipe_fn_custom_categories">
				<?php echo wp_kses_post($list); ?>
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
 
        $instance['title'] 			= ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] 			= ( !empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
 
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$title 			= ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Categories', 'becipe');
		$count 			= ! empty( $instance['count'] ) ? $instance['count'] : 999;
		
		?>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'becipe'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="becipe_fn_width100" />
		</p>
		<p class="becipe_fn_social_paragraph">
			<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e('Post Count:', 'becipe'); ?></label>
			<input min="1" type="number" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="<?php echo esc_attr($count); ?>" class="becipe_fn_width100" />
		</p>

	<?php
	}
}

$my_widget = new Becipe_Custom_Categories();
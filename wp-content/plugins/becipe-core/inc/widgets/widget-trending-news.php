<?php

/**
 * Plugin Name: Trending News
 * Description: A widget that show trending news
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
class Becipe_News extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'becipe_news', // Base ID
			esc_html__( 'Frenify News', 'becipe' ), // Name
			array( 'description' => esc_html__( 'Trending news', 'becipe' ), ) // Args
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'Becipe_News' );
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
		$title 		= apply_filters(esc_html__('Trending Now', 'becipe'), $title );
		
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
		
		$query_args = array(
			'post_type' 			=> 'post',
			'posts_per_page' 		=> $count,
			'post_status' 			=> 'publish',
			'orderby' 				=> 'comment_count',
			'order' 				=> 'DESC',
		);
		
		
		
		$becipe_post_loop = new \WP_Query($query_args);
		$list = '<ul>';
		foreach ( $becipe_post_loop->posts as $key => $fn_post ) {
			setup_postdata( $fn_post );
			$post_id 			= $fn_post->ID;
			$post_permalink 	= get_permalink($post_id);
			$post_title			= $fn_post->post_title;
			$post_img			= get_the_post_thumbnail_url($post_id, 'becipe_fn_thumb-1400-0');
			$title 				= '<h3><span>'.$post_title.'</span></h3>';
			$count				= get_comments_number( $post_id );
			$commentCount		= sprintf( _n( '%s Comment', '%s Comments', $count, 'becipe' ), number_format_i18n( $count ) );

			$post_time			= '<p><span class="post_time">'. get_the_time(get_option('date_format'), $post_id) .'</span><span class="post_com_count">'.$commentCount.'</span></p>';
			//get_comments_number($post_id)
			$img_holder 		= '';
			$myKey				= '<span class="fn_key">'.($key + 1).'</span>';
			if($key == 0){
				$img_holder 	= '<div class="img_holder"><img src="'.$post_img.'" alt="" /></div>';
			}
			if($post_img == ''){
				$post_img 		= 'yes';
			}else{
				$post_img 		= 'no';
			}
			$title_holder		= '<div class="title_holder">'.$myKey.$title.$post_time.'</div>';
			$list .= '<li class="item_'.$key.'" data-has-image="'.$post_img.'"><div class="item"><a href="'.$post_permalink.'"></a>'.$img_holder.$title_holder.'</div></li>';
			wp_reset_postdata();
		}
		$list .= '</ul>';
		?>
           	<div class="becipe_fn_widget_trending">
				<?php echo $list; ?>
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
		$title 			= ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Trending Now', 'becipe');
		$count 			= ! empty( $instance['count'] ) ? $instance['count'] : 3;
		
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

$my_widget = new Becipe_News();
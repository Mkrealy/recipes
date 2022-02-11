<?php

/**
 * Plugin Name: Brochure Widget
 * Description: A widget that show brochures.
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
class Brochure extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		parent::__construct(
			'brochure', // Base ID
			esc_html__( 'Frenify Brochure', 'becipe' ), // Name
			array( 'description' => esc_html__( 'A widget that show brochures', 'becipe' ), ) // Args
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'Brochure' );
        });
	}
	

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		/* Our variables from the widget settings. */
		$title		= '';
		if ( !empty( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; }
		$title 		= apply_filters(esc_html__('Company Presentation', 'becipe'), $title );
		
		$a1_type 	= '';
		$a1_text 	= '';
		$a1_link 	= '';
		
		$a2_type 	= '';
		$a2_text 	= '';
		$a2_link 	= '';
		
		$a3_type 	= '';
		$a3_text 	= '';
		$a3_link 	= '';
		
		$a4_type 	= '';
		$a4_text 	= '';
		$a4_link 	= '';
		
		$a5_type 	= '';
		$a5_text 	= '';
		$a5_link 	= '';
		
		$a6_type 	= '';
		$a6_text 	= '';
		$a6_link 	= '';
		
		$a7_type 	= '';
		$a7_text 	= '';
		$a7_link 	= '';
		
		if ( !empty( $instance[ 'a1_type' ] ) ) { $a1_type = $instance[ 'a1_type' ]; }
		if ( !empty( $instance[ 'a1_text' ] ) ) { $a1_text = $instance[ 'a1_text' ]; }
		if ( !empty( $instance[ 'a1_link' ] ) ) { $a1_link = $instance[ 'a1_link' ]; }
		
		if ( !empty( $instance[ 'a2_type' ] ) ) { $a2_type = $instance[ 'a2_type' ]; }
		if ( !empty( $instance[ 'a2_text' ] ) ) { $a2_text = $instance[ 'a2_text' ]; }
		if ( !empty( $instance[ 'a2_link' ] ) ) { $a2_link = $instance[ 'a2_link' ]; }
		
		if ( !empty( $instance[ 'a3_type' ] ) ) { $a3_type = $instance[ 'a3_type' ]; }
		if ( !empty( $instance[ 'a3_text' ] ) ) { $a3_text = $instance[ 'a3_text' ]; }
		if ( !empty( $instance[ 'a3_link' ] ) ) { $a3_link = $instance[ 'a3_link' ]; }
		
		if ( !empty( $instance[ 'a4_type' ] ) ) { $a4_type = $instance[ 'a4_type' ]; }
		if ( !empty( $instance[ 'a4_text' ] ) ) { $a4_text = $instance[ 'a4_text' ]; }
		if ( !empty( $instance[ 'a4_link' ] ) ) { $a4_link = $instance[ 'a4_link' ]; }
		
		if ( !empty( $instance[ 'a5_type' ] ) ) { $a5_type = $instance[ 'a5_type' ]; }
		if ( !empty( $instance[ 'a5_text' ] ) ) { $a5_text = $instance[ 'a5_text' ]; }
		if ( !empty( $instance[ 'a5_link' ] ) ) { $a5_link = $instance[ 'a5_link' ]; }
		
		if ( !empty( $instance[ 'a6_type' ] ) ) { $a6_type = $instance[ 'a6_type' ]; }
		if ( !empty( $instance[ 'a6_text' ] ) ) { $a6_text = $instance[ 'a6_text' ]; }
		if ( !empty( $instance[ 'a6_link' ] ) ) { $a6_link = $instance[ 'a6_link' ]; }
		
		if ( !empty( $instance[ 'a7_type' ] ) ) { $a7_type = $instance[ 'a7_type' ]; }
		if ( !empty( $instance[ 'a7_text' ] ) ) { $a7_text = $instance[ 'a7_text' ]; }
		if ( !empty( $instance[ 'a7_link' ] ) ) { $a7_link = $instance[ 'a7_link' ]; }
		
		
		

		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);
		if ( $title ) { echo wp_kses_post($before_title . $title . $after_title);  }?>
           	<div class="becipe_fn_widget_brochure">
                
                
<?php 
	$icon1 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a1_type.'.svg'.'" alt="" />';
	$icon2 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a2_type.'.svg'.'" alt="" />';
	$icon3 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a3_type.'.svg'.'" alt="" />';
	$icon4 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a4_type.'.svg'.'" alt="" />';
	$icon5 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a5_type.'.svg'.'" alt="" />';
	$icon6 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a6_type.'.svg'.'" alt="" />';
	$icon7 = '<img class="becipe_fn_svg" src="'.get_template_directory_uri() .'/framework/svg/file-'.$a7_type.'.svg'.'" alt="" />';
?>
                
                <div class="fn_brochures">
                	<ul>
                		<?php if($a1_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a1_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon1);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a1_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a2_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a2_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon2);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a2_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a3_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a3_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon3);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a3_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a4_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a4_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon4);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a4_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a5_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a5_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon5);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a5_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a6_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a6_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon6);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a6_text); ?></span>
                			</div>
                		</li>
                		<?php } ?>
                		<?php if($a7_text !== ''){ ?>
                		<li>
                			<div class="br_item">
                				<a href="<?php echo esc_url($a7_link); ?>" download></a>
                				<span class="icon">
                					<?php echo wp_kses_post($icon7);?>
                				</span>
                				<span class="text"><?php echo wp_kses_post($a7_text); ?></span>
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
			
		
		$instance = array();
 
        $instance['title'] 	 = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
        $instance['a1_type'] = ( !empty( $new_instance['a1_type'] ) ) ? strip_tags( $new_instance['a1_type'] ) : '';
        $instance['a1_text'] = ( !empty( $new_instance['a1_text'] ) ) ? strip_tags( $new_instance['a1_text'] ) : '';
        $instance['a1_link'] = ( !empty( $new_instance['a1_link'] ) ) ? strip_tags( $new_instance['a1_link'] ) : '';
		
        $instance['a2_type'] = ( !empty( $new_instance['a2_type'] ) ) ? strip_tags( $new_instance['a2_type'] ) : '';
        $instance['a2_text'] = ( !empty( $new_instance['a2_text'] ) ) ? strip_tags( $new_instance['a2_text'] ) : '';
        $instance['a2_link'] = ( !empty( $new_instance['a2_link'] ) ) ? strip_tags( $new_instance['a2_link'] ) : '';
		
        $instance['a3_type'] = ( !empty( $new_instance['a3_type'] ) ) ? strip_tags( $new_instance['a3_type'] ) : '';
        $instance['a3_text'] = ( !empty( $new_instance['a3_text'] ) ) ? strip_tags( $new_instance['a3_text'] ) : '';
        $instance['a3_link'] = ( !empty( $new_instance['a3_link'] ) ) ? strip_tags( $new_instance['a3_link'] ) : '';
		
        $instance['a4_type'] = ( !empty( $new_instance['a4_type'] ) ) ? strip_tags( $new_instance['a4_type'] ) : '';
        $instance['a4_text'] = ( !empty( $new_instance['a4_text'] ) ) ? strip_tags( $new_instance['a4_text'] ) : '';
        $instance['a4_link'] = ( !empty( $new_instance['a4_link'] ) ) ? strip_tags( $new_instance['a4_link'] ) : '';
		
        $instance['a5_type'] = ( !empty( $new_instance['a5_type'] ) ) ? strip_tags( $new_instance['a5_type'] ) : '';
        $instance['a5_text'] = ( !empty( $new_instance['a5_text'] ) ) ? strip_tags( $new_instance['a5_text'] ) : '';
        $instance['a5_link'] = ( !empty( $new_instance['a5_link'] ) ) ? strip_tags( $new_instance['a5_link'] ) : '';
		
        $instance['a6_type'] = ( !empty( $new_instance['a6_type'] ) ) ? strip_tags( $new_instance['a6_type'] ) : '';
        $instance['a6_text'] = ( !empty( $new_instance['a6_text'] ) ) ? strip_tags( $new_instance['a6_text'] ) : '';
        $instance['a6_link'] = ( !empty( $new_instance['a6_link'] ) ) ? strip_tags( $new_instance['a6_link'] ) : '';
		
        $instance['a7_type'] = ( !empty( $new_instance['a7_type'] ) ) ? strip_tags( $new_instance['a7_type'] ) : '';
        $instance['a7_text'] = ( !empty( $new_instance['a7_text'] ) ) ? strip_tags( $new_instance['a7_text'] ) : '';
        $instance['a7_link'] = ( !empty( $new_instance['a7_link'] ) ) ? strip_tags( $new_instance['a7_link'] ) : '';
 
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */		
		
		$title 		= ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Company Presentation', 'becipe');
		
		$a1_type 	= ! empty( $instance['a1_type'] ) ? $instance['a1_type'] : 'pdf';
		$a1_text 	= ! empty( $instance['a1_text'] ) ? $instance['a1_text'] : esc_html__('Download .PDF', 'becipe');
		$a1_link 	= ! empty( $instance['a1_link'] ) ? $instance['a1_link'] : '#';
		
		$a2_type 	= ! empty( $instance['a2_type'] ) ? $instance['a2_type'] : 'zip';
		$a2_text 	= ! empty( $instance['a2_text'] ) ? $instance['a2_text'] : esc_html__('Download .ZIP', 'becipe');
		$a2_link 	= ! empty( $instance['a2_link'] ) ? $instance['a2_link'] : '#';
		
		$a3_type 	= ! empty( $instance['a3_type'] ) ? $instance['a3_type'] : 'doc';
		$a3_text 	= ! empty( $instance['a3_text'] ) ? $instance['a3_text'] : esc_html__('Download .DOC', 'becipe');
		$a3_link 	= ! empty( $instance['a3_link'] ) ? $instance['a3_link'] : '#';
		
		$a4_type 	= ! empty( $instance['a4_type'] ) ? $instance['a4_type'] : '';
		$a4_text 	= ! empty( $instance['a4_text'] ) ? $instance['a4_text'] : '';
		$a4_link 	= ! empty( $instance['a4_link'] ) ? $instance['a4_link'] : '';
		
		$a5_type 	= ! empty( $instance['a5_type'] ) ? $instance['a5_type'] : '';
		$a5_text 	= ! empty( $instance['a5_text'] ) ? $instance['a5_text'] : '';
		$a5_link 	= ! empty( $instance['a5_link'] ) ? $instance['a5_link'] : '';
		
		$a6_type 	= ! empty( $instance['a6_type'] ) ? $instance['a6_type'] : '';
		$a6_text 	= ! empty( $instance['a6_text'] ) ? $instance['a6_text'] : '';
		$a6_link 	= ! empty( $instance['a6_link'] ) ? $instance['a6_link'] : '';
		
		$a7_type 	= ! empty( $instance['a7_type'] ) ? $instance['a7_type'] : '';
		$a7_text 	= ! empty( $instance['a7_text'] ) ? $instance['a7_text'] : '';
		$a7_link 	= ! empty( $instance['a7_link'] ) ? $instance['a7_link'] : '';

		?>



		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'becipe'); ?></label><br />
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="becipe_fn_width100" />
		</p>
		
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a1_type' )); ?>"><?php esc_html_e('Type1', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a1_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a1_type' )); ?>" value="<?php echo esc_attr($a1_type); ?>" class="becipe_fn_width100" >
					<option selected>pdf</option>
					<option>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a1_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a1_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a1_text' )); ?>" value="<?php echo esc_attr($a1_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a1_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a1_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a1_link' )); ?>" value="<?php echo esc_attr($a1_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a2_type' )); ?>"><?php esc_html_e('Type2', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a2_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a2_type' )); ?>" value="<?php echo esc_attr($a2_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option selected>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>
		
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a2_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a2_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a2_text' )); ?>" value="<?php echo esc_attr($a2_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a2_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a2_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a2_link' )); ?>" value="<?php echo esc_attr($a2_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a3_type' )); ?>"><?php esc_html_e('Type3', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a3_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a3_type' )); ?>" value="<?php echo esc_attr($a3_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option>zip</option>
					<option selected>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a3_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a3_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a3_text' )); ?>" value="<?php echo esc_attr($a3_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a3_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a3_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a3_link' )); ?>" value="<?php echo esc_attr($a3_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a4_type' )); ?>"><?php esc_html_e('Type4', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a4_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a4_type' )); ?>" value="<?php echo esc_attr($a4_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a4_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a4_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a4_text' )); ?>" value="<?php echo esc_attr($a4_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a4_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a4_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a4_link' )); ?>" value="<?php echo esc_attr($a4_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a5_type' )); ?>"><?php esc_html_e('Type5', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a5_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a5_type' )); ?>" value="<?php echo esc_attr($a5_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a5_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a5_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a5_text' )); ?>" value="<?php echo esc_attr($a5_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a5_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a5_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a5_link' )); ?>" value="<?php echo esc_attr($a5_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a6_type' )); ?>"><?php esc_html_e('Type6', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a6_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a6_type' )); ?>" value="<?php echo esc_attr($a6_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a6_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a6_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a6_text' )); ?>" value="<?php echo esc_attr($a6_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a6_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a6_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a6_link' )); ?>" value="<?php echo esc_attr($a6_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
		<div class="becipe_fn_widget_broch">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a7_type' )); ?>"><?php esc_html_e('Type7', 'becipe'); ?></label><br />
				<select id="<?php echo esc_attr($this->get_field_id( 'a7_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a7_type' )); ?>" value="<?php echo esc_attr($a7_type); ?>" class="becipe_fn_width100" >
					<option>pdf</option>
					<option>zip</option>
					<option>doc</option>
					<option>ppt</option>
					<option>xls</option>
					<option>mp4</option>
					<option>mp3</option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a7_text' )); ?>"><?php esc_html_e('Text', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a7_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a7_text' )); ?>" value="<?php echo esc_attr($a7_text); ?>" class="becipe_fn_width100" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'a7_link' )); ?>"><?php esc_html_e('Download URL', 'becipe'); ?></label><br />
				<input id="<?php echo esc_attr($this->get_field_id( 'a7_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a7_link' )); ?>" value="<?php echo esc_attr($a7_link); ?>" class="becipe_fn_width100" />
			</p>
		</div>
	<?php
	}
}
$my_widget = new Brochure();
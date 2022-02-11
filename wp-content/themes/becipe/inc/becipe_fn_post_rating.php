<?php
/*
Name: BecipePostRating
Description: Custom Rating Posts
Author: Frenify
Author URI: http://themeforest.net/user/frenify
*/


//add_action( 'wp_enqueue_scripts', 'becipe_fn_rating_styles' );
//function becipe_fn_rating_styles() {
//
//	wp_register_style( 'ci-comment-rating-styles', plugins_url( '/', __FILE__ ) . 'assets/style.css' );
//
//	wp_enqueue_style( 'dashicons' );
//	wp_enqueue_style( 'ci-comment-rating-styles' );
//}

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'becipe_fn_rating_rating_field' );
add_action( 'comment_form_after_fields', 'becipe_fn_rating_rating_field' );
function becipe_fn_rating_rating_field () {
	if(get_post_type() == 'becipe-recipe'){
		$svg_empty 		= becipe_fn_getSVG_theme('star-empty', 'fn_empty');
		$svg_full 		= becipe_fn_getSVG_theme('star-full', 'fn_full');
		$icon			= '<span class="fn_icon">'.$svg_empty.$svg_full.'</span>';
		$extra_class 	= 'rating-5 rating-4 rating-3 rating-2 rating-1 rating-0';
	?>
	
		<fieldset class="comments-rating">
			<span class="rating-container">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<?php $extra_class = str_replace(' rating-'.($i-1), "", $extra_class); ?>
					<span class="fn_radio <?php echo esc_attr( $extra_class ); ?>"><input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo wp_kses($icon, 'post'); ?></label></span>
				<?php endfor; ?>
			</span>
		</fieldset>
	<?php 
	 }
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'becipe_fn_rating_save_comment_rating' );
function becipe_fn_rating_save_comment_rating( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
	$rating = intval( $_POST['rating'] );
	add_comment_meta( $comment_id, 'rating', $rating );
}

//Make the rating required.
//add_filter( 'preprocess_comment', 'becipe_fn_rating_require_rating' );
function becipe_fn_rating_require_rating( $commentdata ) {
	if ( ! is_admin() && ( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
	wp_die( esc_html__( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.', 'becipe' ) );
	return $commentdata;
}

//Display the rating on a submitted comment.
function becipe_fn_rating_display_rating(  ){

	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$svg_empty 		= becipe_fn_getSVG_theme('star-empty', 'fn_empty');
		$svg_full 		= becipe_fn_getSVG_theme('star-full', 'fn_full');
		$stars = '';
		for ( $i = 1; $i <= $rating; $i++ ) {
			$full 	= '<span class="fn_full_icon">'.$svg_full.'</span>';
			$stars .= '<span class="fn_rating_item">'.$full.'</span>';
		}
		for ($i = 1; $i <= (5-$rating); $i++){
			$stars .= '<span class="fn_rating_item"><span class="fn_empty_icon">'.$svg_empty.'</span></span>';
		}
		
		$stars = '<span class="fn_rating" title="'.esc_attr($rating).'">'.$stars.'</span>';
		
		return $stars;
	}
	return '';
}

//Get the average rating of a post.
function becipe_fn_rating_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i = 0;
		$total = 0;
		foreach( $comments as $comment ){
			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
			if( isset( $rate ) && '' !== $rate ) {
				$i++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}

//Display the average rating above the content.
//add_filter( 'the_content', 'becipe_fn_rating_display_average_rating' );
function becipe_fn_rating_display_average_rating( $content = '' ) {

	global $post;

	if ( false === becipe_fn_rating_get_average_ratings( $post->ID ) ) {
		return $content;
	}
	
	$svg_empty 		= becipe_fn_getSVG_theme('star-empty', 'fn_empty');
	$svg_full 		= becipe_fn_getSVG_theme('star-full', 'fn_full');
	$svg_width		= 14;
	
	$stars   = '';
	$average = becipe_fn_rating_get_average_ratings( $post->ID );

	for ( $i = 1; $i <= $average + 1; $i++ ) {
		
		$width = intval( $i - $average > 0 ? $svg_width - ( ( $i - $average ) * $svg_width ) : $svg_width );

		if ( 0 === $width ) {
			continue;
		}
		$empty 	= '';
		$full 	= '<span style="width:' . $width . 'px" class="fn_full_icon">'.$svg_full.'</span>';


		if ( $i - $average > 0 ) {
			$empty 	= '<span style="width:' . ($svg_width-$width) . 'px;" class="fn_empty_icon not_full"><span>'.$svg_empty.'</span></span>';
		}
		$stars .= '<span class="fn_rating_item">'.$full.$empty.'</span>';
	}
	for ($i = 5; $i > $average; $i--){
		if((intval($average) == ($i-1)) && ($average - floor($average)) > 0){
			continue;
		}
		$stars .= '<span class="fn_rating_item"><span class="fn_empty_icon">'.$svg_empty.'</span></span>';
	}
	
	$stars = '<span class="fn_rating" title="'.esc_attr($average).'">'.$stars.'</span>';
	
	$output  = $stars;
	$output .= $content;
	return $output;
}
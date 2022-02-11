<?php
/*
Name: BecipeLike
Description: Custom Love Posts
Author: Frenify
Author URI: http://themeforest.net/user/frenify
*/


class BecipeLike {
	
	 function __construct()   {	
        add_action('wp_ajax_becipe_fn_like', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_becipe_fn_like', array(&$this, 'ajax'));
	}
	
	
	
	function ajax($postID) {
		
		//  -- update
		if( isset($_POST['ID']) ) {
			$postID 	= str_replace('becipe_fn_like_', '', $_POST['ID']);
			$likeAction = '';
			if( isset($_POST['likeAction']) ) {
				$likeAction = $_POST['likeAction'];
			}
			echo wp_kses($this->like_post($postID, 'update', $likeAction), 'post');
		} 
		
		//  -- get
		else {
			$postID = str_replace('becipe_fn_like_', '', $_POST['ID']);
			echo wp_kses($this->like_post($postID, 'get'), 'post');
		}
		
		exit;
	}
	
	
	function like_post($postID, $action = 'get', $likeAction = '') 
	{
		if(!is_numeric($postID)) return;
		if($likeAction == 'not-rated'){
			$likeCount = get_post_meta($postID, '_becipe_fn_like', true);
			if( !isset($_COOKIE['becipe_fn_like_'.$postID]) ){
				$likeCount++;
				update_post_meta($postID, '_becipe_fn_like', $likeCount);
				setcookie('becipe_fn_like_'. $postID, $postID, time()*20, '/');
			}
			$svgURL		= get_template_directory_uri().'/framework/svg/like-full.svg';
			$title 		= esc_html__('You already liked this!', 'becipe');
			$countShort = becipe_fn_number_format_short($likeCount);
			$likeText 	= sprintf( _n('like', 'likes', $likeCount, 'becipe'), $likeCount );
		}else if($likeAction == 'liked'){
			unset($_COOKIE['becipe_fn_like_'.$postID]); 
			setcookie('becipe_fn_like_'.$postID, null, -1, '/');
			$likeCount = get_post_meta($postID, '_becipe_fn_like', true);
			if(!$likeCount ){
				$likeCount = 0;
				add_post_meta($postID, '_becipe_fn_like', $likeCount, true);
			}else{
				$likeCount--;
				update_post_meta($postID, '_becipe_fn_like', $likeCount);
			}
			$svgURL		= get_template_directory_uri().'/framework/svg/like-empty.svg';
  			$title 		= esc_html__('Like this', 'becipe');
			$likeText 	= sprintf( _n('Like', 'Likes', $likeCount, 'becipe'), $likeCount );
			$countShort = becipe_fn_number_format_short($likeCount);
		}else{
			$likeCount = get_post_meta($postID, '_becipe_fn_like', true);
			if( !$likeCount ){
				$likeCount = 0;
				add_post_meta($postID, '_becipe_fn_like', $likeCount, true);
			}
			$likeText 	= sprintf( _n('Like', 'Likes', $likeCount, 'becipe'), $likeCount );
			$countShort = becipe_fn_number_format_short($likeCount);
			return wp_kses('<span class="becipe_fn_like_count like_count"><span class="count">'. $countShort .'</span><span class="text">'.$likeText.'</span></span>', 'post');
		}
		
		
	 	$search = array(
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s'       // shorten multiple whitespace sequences
		);
		$replace = array(
			'>',
			'<',
			'\\1'
		);
		$buffy = preg_replace($search, $replace, $buffy);

		$buffyArray = array(
			'data'		=> $buffy,
			'count' 	=> $countShort,
			'like_text' => $likeText,
			'like' 		=> $like,
			'action' 	=> $action,
			'svg' 		=> $svgURL,
			'title' 	=> $title,
		);
		
		if ( 'update' === $action ){
			die(json_encode($buffyArray));
		}
	}


	function add_like($postID) {
		global $post;

		$count = $this->like_post($postID);
  
  		$class = 'becipe_fn_like not-rated';
  		$title = esc_html__('Like this', 'becipe');
		
		$svgURL			= get_template_directory_uri().'/framework/svg/like-empty.svg';
		
		if( isset($_COOKIE['becipe_fn_like_'. $postID]) ){
			$class 		= 'becipe_fn_like liked';
			$title 		= esc_html__('You already liked this!', 'becipe');
			$svgURL		= get_template_directory_uri().'/framework/svg/like-full.svg';
		}
		
		
		$svg	= '<img class="becipe_w_fn_svg" src="'.$svgURL.'" alt="'.esc_attr__('svg', 'becipe').'" />';
		
		return wp_kses('<a href="#" class="'. $class .'" data-id="becipe_fn_like_'. $postID .'" title="'. $title .'">'.$svg.$count.'</a>', 'post');
	}
	
}


global $becipe_fn_like;
$becipe_fn_like = new BecipeLike();

// main function 
function becipe_fn_like($postID, $return = '') {
	global $becipe_fn_like;
	
	if($return == 'return') {
		return wp_kses($becipe_fn_like->add_like($postID), 'post'); 
	} else {
		echo wp_kses($becipe_fn_like->add_like($postID), 'post'); 
	}
} 
?>

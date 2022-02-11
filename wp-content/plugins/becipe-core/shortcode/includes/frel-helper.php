<?php

namespace Frel;

// Exit if accessed directly. 
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Helper Class
class Frel_Helper
{
	
	public static function frel_open_wrap(){
		return '<div class="cons_w_wrapper">';
	}
	public static function frel_close_wrap(){
		return '</div>';
	}
	public static function frel_read_more($text,$permalink){
		return '<div class="becipe_fn_read_holder"><a href="'.$permalink.'"><span class="text">'.esc_html($text).'</span><span class="abs_text">'.esc_html($text).'</span><span class="arrow"></span><span class="bg"></span></a></div>';
	}
	
	public static function get_deprecated_text($shortcode = ''){
		$output = '';
		$output .= '<div class="fn_cs_deprecated_text">';
			$output .= '<div class="inner">';
				$output .= '<span class="icon_holder"><i class="xcon-info"></i></span>';
				$output .= '<h5>'.esc_html__('Info','frenify-core').'</h5>';
				$output .= '<p>'.sprintf( esc_html__( 'Please, use %s%s%s shortcode instead that. This shortcode has been deprecated. Don\'t worry, this message will not be shown to other users.','frenify-core' ), '<span>', $shortcode, '</span>' ).'</p>';
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
    // Get Post Types
    public static function post_types()
    {
		$selectedPostTypes = [];
		$args = array('public' => true);
		
		// includes
		foreach ( get_post_types( $args, 'names' ) as $post_type ) 
		{
			$title = str_replace( '-', ' ', $post_type );
			$title = ucwords( str_replace( '_', ' ', $title ) );
			
			$selectedPostTypes[$post_type] = $title;
		}
		
		// excludes
		unset($selectedPostTypes['attachment']);
		unset($selectedPostTypes['elementor_library']);
		
		return $selectedPostTypes;
		
    }
	
	public static function post_terms_beta($post_type,$extraMeta = '')
	{	
		$selectedPostTerms = [];

		// post cats
		if( $post_type == 'post' )
		{
			$terms = get_categories();
			foreach ( $terms as $term ) 
			{
				$selectedPostTerms[$term->slug] = $term->name;
			}
		}
		else if( $post_type == 'page' )
		{
			// do nothing
		}
		else if( $post_type != '' )
		{
			$taxonomys = get_object_taxonomies( $post_type );
			$exclude = array( 'post_tag', 'post_format' );

//			var_dump($taxonomys);
			if($taxonomys != '')
			{
				foreach($taxonomys as $taxonomy)
				{
					if($extraMeta != ''){
						if($taxonomy == $extraMeta){
							// exclude post tags
							if( in_array( $taxonomy, $exclude ) ) { continue; }

							$terms = get_terms($taxonomy, array('hide_empty' => true));
							foreach ( $terms as $term ) 
							{
								$selectedPostTerms[$term->slug] = $term->name;
							}	
						}
					}else{
						// exclude post tags
						if( in_array( $taxonomy, $exclude ) ) { continue; }

						$terms = get_terms($taxonomy, array('hide_empty' => true));
						foreach ( $terms as $term ) 
						{
							$selectedPostTerms[$term->slug] = $term->name;
						}
					}
					
				}
			}
		}

		// custom post cats
		return $selectedPostTerms;
	}
	
	
	
	
	public static function post_taxanomy($post_type)
	{	
		$selectedPostTaxonomies = [];
		
		if( $post_type == 'page' )
		{
			
		}
		else if( $post_type != '' )
		{
			$taxonomys = get_object_taxonomies( $post_type );
			$exclude = array( 'post_tag', 'post_format' );

			if($taxonomys != '')
			{
				foreach($taxonomys as $key => $taxonomy)
				{
					// exclude post tags
					if( in_array( $taxonomy, $exclude ) ) { continue; }

					$selectedPostTaxonomies[$key] = $taxonomy;
				}
			}
		}
		else
		{

		}

		// custom post cats
		return $selectedPostTaxonomies;
	}
	
	
	public static function frel_fn_excerpt($limit = 10, $postID = '', $splice = 0) {
		if($limit == 0){
			return '';
		}
		$limit++;
		$excerpt = explode(' ', wp_trim_excerpt('', $postID), $limit);

		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			array_splice($excerpt, 0, $splice);
			$excerpt = implode(" ",$excerpt);
		} 
		else{
			$excerpt = implode(" ",$excerpt);
		} 
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);

		return esc_html($excerpt);
	}
	
	
	// POST TERMS
	public static function post_term_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' , '){
		
		$terms = $termlist = $term_link = $cat_count = '';
		$terms = get_the_terms($postid, $taxanomy);

		if($terms != ''){

			$cat_count = sizeof($terms);
			if($cat_count >= $max){$cat_count = $max;}

			for($i = 0; $i < $cat_count; $i++){
				$term_link = get_term_link( $terms[$i]->slug, $taxanomy );
				$termlist .= '<a href="'.$term_link.'"><span class="extra"></span>'.$terms[$i]->name.'</a>'.$seporator;
			}
			$termlist = trim($termlist, $seporator);
		}

		if($echo == true){
			echo wp_kses_post($termlist);
		}else{
			return wp_kses_post($termlist);
		}
	}
	
	
	public static function post_term_list_second($postid, $taxanomy, $url = false, $separator = ' ', $space = false){
		
		$terms = $termlist = $term_link = $cat_count = '';
		$terms = get_the_terms($postid, $taxanomy);

		if($terms != ''){

			$cat_count = sizeof($terms);

			for($i = 0; $i < $cat_count; $i++){
				$termLink 	= get_term_link( $terms[$i]->slug, $taxanomy );
				$termName	= $terms[$i]->name;
				if($space == true){
					$termName = strtolower($termName);
					$termName = str_replace(' ', '_', $termName);
				}
				if($url == true){
					$termlist .= '<a href="'.$termLink.'">'.$termName.'</a>'.$separator;
				}else{
					$termlist .= $termName.$separator;
				}				
			}
			$termlist = trim($termlist, $separator);
		}
		return wp_kses_post($termlist);
	}
	
	
	public static function ifUrlIsVideo($url){
		if (strpos($url, '.mp4') !== false || strpos($url, '.mov') !== false || strpos($url, '.wmv') !== false || strpos($url, '.avi') !== false || strpos($url, '.mpg') !== false || strpos($url, '.ogv') !== false || strpos($url, '.3gp') !== false || strpos($url, '.3g2') !== false) {
			return true;
		}
		return false;
	}
	
	
	function fn_get_thumbnail($width, $height, $post_id, $link = true) {
    	
		$becipe_fn__output = NULL; 
		if ( has_post_thumbnail( $post_id ) ) {

			if($link === true)
			{
				$becipe_fn__output .= '<a href="'. get_permalink($post_id) .'">';
			}
			
			$becipe_fn__featured_image = get_the_post_thumbnail( $post_id, 'becipe_fn__thumb-'. esc_html($width). '-' . esc_html($height) );
			$becipe_fn__output .= $becipe_fn__featured_image;
			
			if($link === true)
			{
				$becipe_fn__output .= '</a>';
			}
		}
		
		
		
		return  wp_kses_post($becipe_fn__output);
    }
	
	public static function frenify_icons(){
		return [					
					'birthday-1'			=> __( 'Birthday #1', 'frenify-core' ),
					'birthday-2'			=> __( 'Birthday #2', 'frenify-core' ),
					'birthday-3'			=> __( 'Birthday #3', 'frenify-core' ),
					'birthday-4'			=> __( 'Birthday #4', 'frenify-core' ),
					
					'browser-1'				=> __( 'Browser #1', 'frenify-core' ),
					'browser-2'				=> __( 'Browser #2', 'frenify-core' ),
					'browser-3'				=> __( 'Browser #3', 'frenify-core' ),
					'browser-4'				=> __( 'Browser #4', 'frenify-core' ),
					'browser-5'				=> __( 'Browser #5', 'frenify-core' ),
					'browser-6'				=> __( 'Browser #6', 'frenify-core' ),
					'browser-7'				=> __( 'Browser #7', 'frenify-core' ),
					
					'calendar-1'			=> __( 'Calendar #1', 'frenify-core' ),
					'calendar-2'			=> __( 'Calendar #2', 'frenify-core' ),
					'calendar-3'			=> __( 'Calendar #3', 'frenify-core' ),
					'calendar-4'			=> __( 'Calendar #4', 'frenify-core' ),
					
					'call-1'				=> __( 'Call #1', 'frenify-core' ),
					'call-2'				=> __( 'Call #2', 'frenify-core' ),
					'call-3'				=> __( 'Call #3', 'frenify-core' ),
					'call-4'				=> __( 'Call #4', 'frenify-core' ),
					'call-5'				=> __( 'Call #5', 'frenify-core' ),
					'call-6'				=> __( 'Call #6', 'frenify-core' ),
					'call-7'				=> __( 'Call #7', 'frenify-core' ),
					'call-8'				=> __( 'Call #8', 'frenify-core' ),
					'call-9'				=> __( 'Call #9', 'frenify-core' ),
					'call-10'				=> __( 'Call #10', 'frenify-core' ),
					
					'category-1'			=> __( 'Category #1', 'frenify-core' ),
					'category-2'			=> __( 'Category #2', 'frenify-core' ),
					
					'client-1'				=> __( 'Client #1', 'frenify-core' ),
					'client-2'				=> __( 'Client #2', 'frenify-core' ),
					'client-3'				=> __( 'Client #3', 'frenify-core' ),
					'client-4'				=> __( 'Client #4', 'frenify-core' ),
					'client-5'				=> __( 'Client #5', 'frenify-core' ),
					'client-6'				=> __( 'Client #6', 'frenify-core' ),
					'client-7'				=> __( 'Client #7', 'frenify-core' ),
					
					'degree-1'				=> __( 'Degree #1', 'frenify-core' ),
					'degree-2'				=> __( 'Degree #2', 'frenify-core' ),
					'degree-3'				=> __( 'Degree #3', 'frenify-core' ),
					'degree-4'				=> __( 'Degree #4', 'frenify-core' ),
					'degree-5'				=> __( 'Degree #5', 'frenify-core' ),
					'degree-6'				=> __( 'Degree #6', 'frenify-core' ),
					'degree-7'				=> __( 'Degree #7', 'frenify-core' ),
					
					'down-1'				=> __( 'Down #1', 'frenify-core' ),
					'down-2'				=> __( 'Down #2', 'frenify-core' ),
					'down-3'				=> __( 'Down #3', 'frenify-core' ),
					
					'facebook-1'			=> __( 'Facebook #1', 'frenify-core' ),
					'facebook-2'			=> __( 'Facebook #2', 'frenify-core' ),
					'facebook-3'			=> __( 'Facebook #3', 'frenify-core' ),
					'facebook-4'			=> __( 'Facebook #4', 'frenify-core' ),
					'facebook-5'			=> __( 'Facebook #5', 'frenify-core' ),
					'facebook-6'			=> __( 'Facebook #6', 'frenify-core' ),
					
					'hobby-1'				=> __( 'Hobby #1', 'frenify-core' ),
					'hobby-2'				=> __( 'Hobby #2', 'frenify-core' ),
					'hobby-3'				=> __( 'Hobby #3', 'frenify-core' ),
					'hobby-4'				=> __( 'Hobby #4', 'frenify-core' ),
					'hobby-5'				=> __( 'Hobby #5', 'frenify-core' ),
					'hobby-6'				=> __( 'Hobby #6', 'frenify-core' ),
					
					'instagram-1'			=> __( 'Instagram #1', 'frenify-core' ),
					'instagram-2'			=> __( 'Instagram #2', 'frenify-core' ),
					'instagram-3'			=> __( 'Instagram #3', 'frenify-core' ),
					'instagram-4'			=> __( 'Instagram #4', 'frenify-core' ),
					
					'linkedin-1'			=> __( 'Linkedin #1', 'frenify-core' ),
					'linkedin-2'			=> __( 'Linkedin #2', 'frenify-core' ),
					'linkedin-3'			=> __( 'Linkedin #3', 'frenify-core' ),
					'linkedin-4'			=> __( 'Linkedin #4', 'frenify-core' ),
					
					'location-1'			=> __( 'Location #1', 'frenify-core' ),
					'location-2'			=> __( 'Location #2', 'frenify-core' ),
					'location-3'			=> __( 'Location #3', 'frenify-core' ),
					'location-4'			=> __( 'Location #4', 'frenify-core' ),
					'location-5'			=> __( 'Location #5', 'frenify-core' ),
					
					'message-1'				=> __( 'Message #1', 'frenify-core' ),
					'message-2'				=> __( 'Message #2', 'frenify-core' ),
					'message-3'				=> __( 'Message #3', 'frenify-core' ),
					'message-4'				=> __( 'Message #4', 'frenify-core' ),
					'message-5'				=> __( 'Message #5', 'frenify-core' ),
					
					'ok-1'					=> __( 'Classmates #1', 'frenify-core' ),
					'ok-2'					=> __( 'Classmates #2', 'frenify-core' ),
					'ok-3'					=> __( 'Classmates #3', 'frenify-core' ),
					
					'pinterest-1'			=> __( 'Pinterest #1', 'frenify-core' ),
					'pinterest-2'			=> __( 'Pinterest #2', 'frenify-core' ),
					'pinterest-3'			=> __( 'Pinterest #3', 'frenify-core' ),
					
					'portfolio-1'			=> __( 'Portfolio #1', 'frenify-core' ),
					'portfolio-2'			=> __( 'Portfolio #2', 'frenify-core' ),
					'portfolio-3'			=> __( 'Portfolio #3', 'frenify-core' ),
					'portfolio-4'			=> __( 'Portfolio #4', 'frenify-core' ),
					'portfolio-5'			=> __( 'Portfolio #5', 'frenify-core' ),
					'portfolio-6'			=> __( 'Portfolio #6', 'frenify-core' ),
					
					'quote-1'				=> __( 'Quote #1', 'frenify-core' ),
					'quote-2'				=> __( 'Quote #2', 'frenify-core' ),
					'quote-3'				=> __( 'Quote #3', 'frenify-core' ),
					'quote-4'				=> __( 'Quote #4', 'frenify-core' ),
					'quote-5'				=> __( 'Quote #5', 'frenify-core' ),
					'quote-6'				=> __( 'Quote #6', 'frenify-core' ),
					'quote-7'				=> __( 'Quote #7', 'frenify-core' ),
					'quote-8'				=> __( 'Quote #8', 'frenify-core' ),
					'quote-9'				=> __( 'Quote #9', 'frenify-core' ),
					
					'responsive-1'			=> __( 'Responsive #1', 'frenify-core' ),
					'responsive-2'			=> __( 'Responsive #2', 'frenify-core' ),
					'responsive-3'			=> __( 'Responsive #3', 'frenify-core' ),
					'responsive-4'			=> __( 'Responsive #4', 'frenify-core' ),
					'responsive-5'			=> __( 'Responsive #5', 'frenify-core' ),
					
					'skype-1'				=> __( 'Skype #1', 'frenify-core' ),
					'skype-2'				=> __( 'Skype #2', 'frenify-core' ),
					
					'snapchat-1'			=> __( 'Snapchat #1', 'frenify-core' ),
					'snapchat-2'			=> __( 'Snapchat #2', 'frenify-core' ),
					
					'study-1'				=> __( 'Study #1', 'frenify-core' ),
					'study-2'				=> __( 'Study #2', 'frenify-core' ),
					'study-3'				=> __( 'Study #3', 'frenify-core' ),
					'study-4'				=> __( 'Study #4', 'frenify-core' ),
					'study-5'				=> __( 'Study #5', 'frenify-core' ),
					
					'support-1'				=> __( 'Support #1', 'frenify-core' ),
					'support-2'				=> __( 'Support #2', 'frenify-core' ),
					'support-3'				=> __( 'Support #3', 'frenify-core' ),
					'support-4'				=> __( 'Support #4', 'frenify-core' ),
					'support-5'				=> __( 'Support #5', 'frenify-core' ),
					'support-6'				=> __( 'Support #6', 'frenify-core' ),
					'support-7'				=> __( 'Support #7', 'frenify-core' ),
					
					'twitter-1'				=> __( 'Twitter #1', 'frenify-core' ),
					'twitter-2'				=> __( 'Twitter #2', 'frenify-core' ),
					'twitter-3'				=> __( 'Twitter #3', 'frenify-core' ),
					'twitter-4'				=> __( 'Twitter #4', 'frenify-core' ),
			
					'user-1'				=> __( 'User #1', 'frenify-core' ),
					
					'vk-1'					=> __( 'Vkontakte #1', 'frenify-core' ),
					'vk-2'					=> __( 'Vkontakte #2', 'frenify-core' ),
					'vk-3'					=> __( 'Vkontakte #3', 'frenify-core' ),
					'vk-4'					=> __( 'Vkontakte #4', 'frenify-core' ),
					
					'wechat-1'				=> __( 'Wechat #1', 'frenify-core' ),
					'wechat-2'				=> __( 'Wechat #2', 'frenify-core' ),
					
					'whatsapp-1'			=> __( 'Whatsapp #1', 'frenify-core' ),
					'whatsapp-2'			=> __( 'Whatsapp #2', 'frenify-core' ),
					'whatsapp-3'			=> __( 'Whatsapp #3', 'frenify-core' ),
					'whatsapp-4'			=> __( 'Whatsapp #4', 'frenify-core' ),
					
					'youtube-1'				=> __( 'Youtube #1', 'frenify-core' ),
					'youtube-2'				=> __( 'Youtube #2', 'frenify-core' ),
					'youtube-3'				=> __( 'Youtube #3', 'frenify-core' ),
					'youtube-4'				=> __( 'Youtube #4', 'frenify-core' ),
					// since 2.1
					'f-code'				=> __( 'Code', 'frenify-core' ),
					'f-contact'				=> __( 'Contact', 'frenify-core' ),
					'f-google'				=> __( 'Google', 'frenify-core' ),
					'f-images'				=> __( 'Images', 'frenify-core' ),
					'f-settings'			=> __( 'Settings', 'frenify-core' ),
					'f-web'					=> __( 'web', 'frenify-core' ),
				];
	}

	public static function getAllCategories( $taxonomy, $empty_choice = false, $empty_choice_label = 'Default' ) {
		$post_categories = array();
		if( $empty_choice == true ) {
			$post_categories[''] = $empty_choice_label;
		}
		$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);
		if( ! is_wp_error( $get_categories ) ) {
			if( $get_categories && is_array($get_categories) ) {
				foreach ( $get_categories as $cat ) {
					if( property_exists( $cat, 'slug' ) && 
						property_exists( $cat, 'name' ) 
					) {
						$post_categories[$cat->slug] = $cat->name;
					}
				}
			}
			if( isset( $post_categories ) ) {
				return $post_categories;
			}
		}
		return array();
	}
	
	public static function getAllPosts($post_type = 'post'){
		$query_args = array(
			'post_type' 			=> $post_type,
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
		);
		
		$loop 						= new \WP_Query($query_args);
		
		$array = array();

		foreach ( $loop->posts as $key => $fn_post ) {
			setup_postdata( $fn_post );
			$array[$fn_post->ID] 	= ($key+1).'. '.$fn_post->post_title;
			wp_reset_postdata();
		}
		return $array;
	}
	
	
	public static function getAllPortfolioItems(){
		$query_args = array(
			'post_type' 			=> 'becipe-recipe',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
		);
		
		$becipe_post_loop 			= new \WP_Query($query_args);
		
		$array = array();

		foreach ( $becipe_post_loop->posts as $key => $fn_post ) {
			setup_postdata( $fn_post );
			$post_id 			= $fn_post->ID;
			$post_title			= $fn_post->post_title;
			$array[$post_id] 	= $post_title;
			wp_reset_postdata();
		}
		return $array;
	}
	
	
	
	public static function getAllFilter($escText,$loop){
		$filterText 		= $escText[0];
		$allCategoriesText 	= $escText[1];
		$typeText 			= $escText[2];
		$difficultyText		= $escText[3];
		$countryText		= $escText[4];
		
		$filterText 		= '<div class="fn_filter_label">'.$filterText.'</div>';
		
		$filter__category		= self::filter__category($allCategoriesText,$loop,$typeText);
		$filter__difficulty		= self::filter__difficulty($difficultyText,$typeText);
		$filter__country		= self::filter__country($countryText,$typeText);
		
		return '<div class="filter_section"><div class="filter_section_in">'.$filterText.$filter__category.$filter__country.$filter__difficulty.'</div></div>';
	}
	
	public static function filter__country($countryText,$typeText){
		
		$html  = '<div class="fn_filter_wrap country_filter">';
			$html  .= '<div class="filter_in">';
				$html .= '<div class="input_wrapper">';
					$html .= '<input type="text" autocomplete="off" data-type="'.$typeText.'" data-placeholder="'.$countryText.'" placeholder="'.$countryText.'" value="" />';
					$html .= '<span class="icon">
								'.becipe_fn_getSVG_core('down').'
								<span class="loader small">
									<span class="loader_process">
										<span class="ball"></span>
										<span class="ball"></span>
										<span class="ball"></span>
									</span>
								</span>
								<span class="reset"></span>
							</span>';
					$html .= self::filter__get_country_filter_popup();
				$html  .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
	public static function filter__difficulty($difficultyText,$typeText){
		
		$html  = '<div class="fn_filter_wrap difficulty_filter">';
			$html  .= '<div class="filter_in">';
				$html .= '<div class="input_wrapper">';
					$html .= '<input type="text" autocomplete="off" data-type="'.$typeText.'" data-placeholder="'.$difficultyText.'" placeholder="'.$difficultyText.'" value="" />';
					$html .= '<span class="icon">
								'.becipe_fn_getSVG_core('down').'
								<span class="loader small">
									<span class="loader_process">
										<span class="ball"></span>
										<span class="ball"></span>
										<span class="ball"></span>
									</span>
								</span>
								<span class="reset"></span>
							</span>';
					$html .= self::filter__get_difficulty_filter_popup();
				$html  .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
	public static function filter__category($allText,$loop,$typeText){
		
		$html  = '<div class="fn_filter_wrap category_filter">';
			$html  .= '<div class="filter_in">';
				$html .= '<div class="input_wrapper">';
					$html .= '<span class="new_value"></span>';
					$html .= '<input type="text" autocomplete="off" data-type="'.$typeText.'" data-placeholder="'.$allText.'" placeholder="'.$allText.'" value="" />';
					$html .= '<input class="category_filters" type="hidden" value="" />';
					$html .= '<span class="icon">
								'.becipe_fn_getSVG_core('down').'
								<span class="loader small">
									<span class="loader_process">
										<span class="ball"></span>
										<span class="ball"></span>
										<span class="ball"></span>
									</span>
								</span>
								<span class="reset"></span>
							</span>';
					$html .= self::filter__get_category_filter_popup($loop);
				$html  .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
	public static function filter__get_country_filter_popup(){
		global $becipe_fn_option;
		$fn_filter = '';
		
		$svg 		= '<span class="checked_icon">'.becipe_fn_getSVG_theme('checked').'</span>';
		$categories = self::post_terms_beta('becipe-recipe','recipe_country');
		foreach($categories as $key => $cat){
			$fn_filter .= '<div class="item" data-filter="'.$key.'" data-name="'.$cat.'"><span>'.$cat.$svg.'</span></div>';
		}
		
			
		$html 		= '<div class="filter_popup_list country">
							<div class="filter_popup_list_in">';
		
		$html .= $fn_filter;
		
		$html 	   .= '</div></div>';
		return $html;
	}
	
	public static function filter__get_difficulty_filter_popup(){
		global $becipe_fn_option;
		$fn_filter = '';
		
		$svg 		= '<span class="checked_icon">'.becipe_fn_getSVG_theme('checked').'</span>';
		if(isset($becipe_fn_option['recipe_position'])){
			$positions = $becipe_fn_option['recipe_position'];
			foreach($positions as $key => $pos){
				$name = $becipe_fn_option['recipe_difficulty_'.$key];
				$color = $becipe_fn_option['recipe_difficulty_'.$key.'_color'];
				$fn_filter .= '<div class="item" data-filter="'.$key.'" data-name="'.$name.'"><span>'.$name.'<span class="fn_color" style="background-color:'.$color.'"></span>'.$svg.'</span></div>';
			}
		}
		
			
		$html 		= '<div class="filter_popup_list difficulty">
							<div class="filter_popup_list_in">';
		
		$html .= $fn_filter;
		
		$html 	   .= '</div></div>';
		return $html;
	}
	
	public static function filter__get_category_filter_popup($loop){
		$fn_filter 	= $cats = '';
		$svg 		= '<span class="checked_icon">'.becipe_fn_getSVG_theme('checked').'</span>';
		foreach ( $loop->posts as $key => $fnPost ) {
			setup_postdata( $fnPost );
			$postID 			= $fnPost->ID;
			$cats__liClass		= self::post_term_list_second($postID, 'recipe_category', false, ' ', true);
			$cats .= $cats__liClass.' ';

			wp_reset_postdata();
		}
		
		$removedLastCharacter 	= rtrim($cats,' '); 					// remove last character from string
		$stringToArray 			= explode(" ", $removedLastCharacter);	// string to array
		$removeUniqueElements 	= array_unique($stringToArray);			// remove unique elements from array
		asort($removeUniqueElements);
		foreach($removeUniqueElements as $cat){
			$categoryName 		 = ucfirst($cat);
			$categoryName		 = str_replace('_', ' ', $categoryName);
			$fn_filter 			.= '<div class="item" data-filter="'.$cat.'" data-name="'.$categoryName.'"><span>'.$categoryName.$svg.'</span></div>';
		}
		$html 		= '<div class="filter_popup_list category">
							<div class="filter_popup_list_in">';
		
		$html .= $fn_filter;
		
		$html 	   .= '</div></div>';
		return $html;
	}
	
}

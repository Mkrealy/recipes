<?php

get_header();

global $post, $becipe_fn_option;

$currentAuthor 	= get_userdata(get_query_var('author'));
$becipe_fn_pagestyle 		= 'ws';
if(!becipe_fn_if_has_sidebar()){
	$becipe_fn_pagestyle	= 'full';
}
$recipe_archive_title		= esc_html__('All Recipes', 'becipe');
if(isset($becipe_fn_option['recipe_archive_title'])){
	$recipe_archive_title = $becipe_fn_option['recipe_archive_title'];
}

$seo_recipe_search_title 	= 'h3';
if(isset($becipe_fn_option['seo_recipe_search_title'])){
	$seo_recipe_search_title = $becipe_fn_option['seo_recipe_search_title'];
}
	
$search_term		= '';
$post_perpage 		= 1;
$post_order 		= 'desc';
$post_orderby 		= '';
$paged 				= 1;
$post_perpage 		= get_option('posts_per_page');



$read_more			= esc_html__('Read More', 'becipe');
$filterText			= esc_html__('Filter','becipe');
$allCategoriesText	= esc_html__('All Categories','becipe');
$typeText			= esc_html__('Type Something...','becipe');
$difficultyText		= esc_html__('Difficulty','becipe');
$countryText		= esc_html__('Country','becipe');



$hiddenFilter 		= '<input type="hidden" class="hidden_info search_term" value="'.$search_term.'" />';


$query_args = array(
	'post_type' 			=> 'becipe-recipe',
	'paged' 				=> $paged,
	'posts_per_page' 		=> $post_perpage,
	'post_status' 			=> 'publish',
	'order' 				=> $post_order,
	'orderby' 				=> $post_orderby,
);
$query_args2 = array(
	'post_type' 			=> 'becipe-recipe',
	'posts_per_page' 		=> -1,
	'post_status' 			=> 'publish',
	'order' 				=> $post_order,
	'orderby' 				=> $post_orderby,
);

add_filter( 'posts_where', 'becipe_fn_find_recipe_in_title', 10, 2 );
$loop 			= new \WP_Query($query_args);
$loop2 			= new \WP_Query($query_args2);

$allCount 		= count($loop2->posts);

$pagination		= becipe_fn_filter_pagination($allCount,$post_perpage,$paged);



$queryItems = "";

$callBackImage = becipe_fn_callback_thumbs('square');

foreach ( $loop->posts as $key => $fnPost ) {
	setup_postdata( $fnPost );
	$postID 			= $fnPost->ID;
	$postPermalink 		= get_permalink($postID);
	$postImage 			= get_the_post_thumbnail_url( $postID, 'full' );
	$postTitle			= $fnPost->post_title;
	$category			= becipe_fn_post_term_list($postID, 'recipe_category', false, 1);
	$postTitle 			= preg_replace("/(" .$search_term . ")/i", "<span>$1</span>", $postTitle); 

	$authorMeta			= becipe_fn_get_author_meta($postID);
	$extraMeta			= becipe_fn_get_extra_met_by_post_id($postID);
	$readMore			= becipe_fn_read_more($read_more, $postPermalink);

	$image				= $callBackImage.'<div class="abs_img" data-fn-bg-img="'.$postImage.'"></div>';
	$queryItems .= '<li><div class="item">';
		$queryItems .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$postPermalink.'">'.$image.'</a></div><span>'.$category.'</span></div></div>';
		$queryItems .= '<div class="title_holder"><'.$seo_recipe_search_title.' class="fn__title"><a href="'.$postPermalink.'">'.$postTitle.'</a></'.$seo_recipe_search_title.'></div>';
		$queryItems .= $authorMeta;
		$queryItems .= $readMore;
		$queryItems .= $extraMeta;
	$queryItems .= '</div></li>';

	wp_reset_postdata();
}

$escText 		= array($filterText,$allCategoriesText,$typeText,$difficultyText,$countryText);
$filter_section = becipe_fn_get_custom_search_filter($escText,$loop2,$search_term);


if($search_term == ''){
	$top_text = '<div class="top_title"><p></p></div>';
}else{
	$top_text = '<div class="top_title"><p>'.sprintf( esc_html__('Search results for: "%s"', 'becipe'), '<span>'.$search_term ).'</p></div>';
}

$preloader = '<div class="my_loader"></div>';

$list = '<ul>'.$queryItems.'</ul>';

if($queryItems == ''){
	$nothing  = '<div class="nothing_found">';
		$nothing .= '<div class="nothing_found_in">';
			$nothing .= '<span class="icon_holder">'.becipe_fn_getSVG_theme('notfound').'</span>';
			$nothing .= '<h3>'.esc_html__('Nothing Found', 'becipe').'</h3>';
			$nothing .= '<p>'.esc_html__('Unfortunately, we could not find anything related to your search terms. Please, try other terms. ', 'becipe').'</p>';
		$nothing .= '</div>';
	$nothing .= '</div>';
	$list = $nothing;
}


$list_section	= '<div class="post_section">';
	$list_section .= '<div class="post_section_in">';
		$list_section .= $top_text;
		$list_section .= '<div class="my_list">';
			$list_section .= $list;
		$list_section .= '</div>';
		$list_section .= $pagination;
	$list_section .= '</div>';
$list_section .= '</div>';



$html = '<div class="becipe_fn_search_recipes">'.$hiddenFilter;
		$html .= '<div class="inner">';
			$html .= $filter_section;
			$html .= $list_section;
		$html .= '</div>';

$html .= '</div>';
echo wp_kses($html, 'post');
?>
        
<?php get_footer(); ?>   
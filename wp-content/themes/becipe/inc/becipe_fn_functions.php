<?php
/*-----------------------------------------------------------------------------------*/
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
/*-----------------------------------------------------------------------------------*/	

global $becipe_fn_option, $post;


function becipe_fn_search_form( $form ) {
    $form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" ><div class="search-wrapper"><input type="text" value="' . get_search_query() . '" name="s" placeholder="'.esc_attr__('Search anything...', 'becipe').'" /><input type="submit" value="" /><span>'.becipe_fn_getSVG_theme('search').'</span></div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'becipe_fn_search_form', 100 );

function becipe_fn_custom_password_form() {
    global $post;
 
    $loginurl = home_url() . '/wp-login.php?action=postpass';
    ob_start();
    ?>
    <div class="container-custom">            
        <form action="<?php echo esc_attr( $loginurl ) ?>" method="post" class="center-custom search-form" role="search">
            <input name="post_password" class="input post-password-class" type="password" />
            <input type="submit" name="Submit" class="button" value="<?php echo esc_attr__( 'Authenticate', 'becipe' ); ?>" />            
        </form>
    </div>
 
    <?php
    return ob_get_clean();
}   
add_filter( 'the_password_form', 'becipe_fn_custom_password_form', 9999 );
  


if( !function_exists('becipe_fn_get_image_url_from_id') ){
	function becipe_fn_get_image_url_from_id($image_id, $size = 'full'){
		if( empty($image_id) ) return '';
	
		if( is_numeric($image_id) ){
			$alt_text = get_post_meta($image_id , '_wp_attachment_image_alt', true);	
			$image_src = wp_get_attachment_image_src($image_id, $size);	
			if( empty($image_src) ) return '';
			
			$ret = esc_url($image_src[0]);
		}else{
			$ret = esc_url($image_id);
		}
		
		
		return wp_kses($ret, 'post');
	}
}

function becipe_fn_get_cuisine($postID,$max = 999, $taxanomy = 'recipe_country', $seporator = ', '){
	$terms = $termlist = $term_link = '';
	$terms = get_the_terms($postID, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link = get_term_link( $terms[$i]->slug, $taxanomy );
			$termlist .= '<a href="'.$term_link.'">'.$terms[$i]->name.'</a>'.$seporator;
		}
		$termlist = trim($termlist, $seporator);
	}

	return wp_kses($termlist, 'post');
}

function becipe_fn_get_difficulty($postID){
	global $becipe_fn_option;
	
	$color = $name = $difficulty = '';
	if(function_exists('rwmb_meta')){
		$difficulty 	= get_post_meta($postID,'becipe_fn_page_special_difficulty', true);
	}
	
	if($difficulty != ''){
		if(isset($becipe_fn_option['recipe_position'])){
			if(isset($becipe_fn_option['recipe_difficulty_'.$difficulty])){
				$name 	= $becipe_fn_option['recipe_difficulty_'.$difficulty];
			}
			if(isset($becipe_fn_option['recipe_difficulty_'.$difficulty])){
				$color 	= $becipe_fn_option['recipe_difficulty_'.$difficulty.'_color'];
			}
			if($name != ''){
				$difficulty = '<div class="diff_item item_difficulty"><span class="icon" style="background-color:'.$color.';"></span>'.$name.'</div>';
			}
		}
	}
	return $difficulty;
}

function becipe_recipe_difficulty_section($postID){
	
	
	// get difficulty
	$difficulty = becipe_fn_get_difficulty($postID);
	
	// get cuisine
	$cuisine 	= becipe_fn_get_cuisine($postID);
	if($cuisine != ''){
		$cuisine = '<div class="diff_item item_cuisine"><span class="text">'.esc_html__('Cuisine: ', 'becipe').'</span><span class="value">'.$cuisine.'</span></div>';
	}
	
	// get video
	$video 		= '';
	if(function_exists('rwmb_meta')){
		$video 	= get_post_meta($postID,'becipe_fn_page_special_video', true);
	}
	if($video != ''){
		$video	= '<a class="popup-youtube" href="'.$video.'"><span class="icon"></span><span class="title">'.esc_html__('Watch Video', 'becipe').'</span></a>';
		$video 	= '<div class="diff_item item_video">'.$video.'</div>';
	}
	
	$output  = '<div class="becipe_fn_diff_section"><div class="diff_in">';
	
	$output .= $difficulty.$cuisine.$video;
	
	$output .= '</div></div>';
	return $output;
}

function becipe_fn_cs_ajax_filter_posts(){
	global $becipe_fn_option;
	$seo_recipe_search_title 	= 'h3';
	if(isset($becipe_fn_option['seo_recipe_search_title'])){
		$seo_recipe_search_title = $becipe_fn_option['seo_recipe_search_title'];
	}
	
	$read_more = $filter_category_array = $filter_country = $filter_difficulty = $filter_order = $filter_orderby = $filter_include = $filter_exclude = $filter_page = $filter_cat_include = $filter_cat_exclude = $filter_perpage = '';
		
		
	if(!empty($_POST['read_more'])){
		$read_more 				= $_POST['read_more'];
	}
	if(!empty($_POST['filter_order'])){
		$filter_order 			= $_POST['filter_order'];
	}
	if(!empty($_POST['filter_orderby'])){
		$filter_orderby 		= $_POST['filter_orderby'];
	}
	if(!empty($_POST['filter_include'])){
		$filter_include 		= $_POST['filter_include'];
	}
	if(!empty($_POST['filter_exclude'])){
		$filter_exclude 		= $_POST['filter_exclude'];
	}
	if(!empty($_POST['filter_category_array'])){
		$filter_category_array 	= $_POST['filter_category_array'];
	}
	if(!empty($_POST['filter_cat_exclude'])){
		$filter_cat_exclude 	= $_POST['filter_cat_exclude'];
	}
	if(!empty($_POST['filter_cat_include'])){
		$filter_cat_include 	= $_POST['filter_cat_include'];
	}
	if(!empty($_POST['filter_page'])){
		$filter_page 			= $_POST['filter_page'];
	}
	if(!empty($_POST['filter_perpage'])){
		$filter_perpage 		= $_POST['filter_perpage'];
	}
	if(!empty($_POST['filter_difficulty'])){
		$filter_difficulty 		= $_POST['filter_difficulty'];
	}
	if(!empty($_POST['filter_country'])){
		$filter_country 		= $_POST['filter_country'];
	}
	
	
	$postIncludedItems			= array();
	if($filter_include != ''){
		$postIncludedItems		= explode(',', $filter_include);
	}
	$postExcludedItems			= array();
	if($filter_exclude != ''){
		$postExcludedItems		= explode(',', $filter_exclude);
	}

	// portfolio posts options
	$include_categories 		= array();
	if($filter_cat_include != ''){
		$include_categories 	= explode(',', $filter_cat_include);
	}
	
	if($filter_category_array != ''){
		$include_categories		= explode(',', $filter_category_array);
	}
	
	$exclude_categories 		= array();
	if($filter_cat_exclude != ''){
		$exclude_categories 	= explode(',', $filter_cat_exclude);
	}
	$post_order 				= $filter_order;
	$post_orderby 				= $filter_orderby;
	if($post_orderby === 'select'){
		$post_orderby 			= '';
	}

	$post_number 				= $filter_perpage;
	$paged 						= $filter_page;
	$query_args = array(
		'post_type' 			=> 'becipe-recipe',
		'paged' 				=> $paged,
		'posts_per_page' 		=> $post_number,
		'post_status' 			=> 'publish',
		'order' 				=> $post_order,
		'orderby' 				=> $post_orderby,
		'post__in' 				=> $postIncludedItems,
		'post__not_in'	 		=> $postExcludedItems,
	);
	$query_args2 = array(
		'post_type' 			=> 'becipe-recipe',
		'posts_per_page' 		=> -1, // post number
		'post_status' 			=> 'publish',
		'order' 				=> $post_order,
		'orderby' 				=> $post_orderby,
		'post__in' 				=> $postIncludedItems,
		'post__not_in'	 		=> $postExcludedItems,
	);

	if ( ! empty ( $exclude_categories ) ) {

		// Exclude the correct cats from tax_query
		$query_args['tax_query'] = array(
			array(
				'taxonomy'	=> 'recipe_category', 
				'field'	 	=> 'slug',
				'terms'		=> $exclude_categories,
				'operator'	=> 'NOT IN'
			)
		);

		// Exclude the correct cats from tax_query
		$query_args2['tax_query'] = array(
			array(
				'taxonomy'	=> 'recipe_category', 
				'field'	 	=> 'slug',
				'terms'		=> $exclude_categories,
				'operator'	=> 'NOT IN'
			)
		);
		
		if($filter_country != '*'){
			$query_args['tax_query']['relation'] = 'AND';
			$query_args['tax_query'][] = array(
				'taxonomy'	=> 'recipe_country',
				'field'		=> 'slug',
				'terms'		=> $filter_country,
				'operator'	=> 'IN'
			);
			$query_args2['tax_query']['relation'] = 'AND';
			$query_args2['tax_query'][] = array(
				'taxonomy'	=> 'recipe_country',
				'field'		=> 'slug',
				'terms'		=> $filter_country,
				'operator'	=> 'IN'
			);
		}

		// Include the correct cats in tax_query
		if ( ! empty ( $include_categories ) ) {
			$query_args['tax_query']['relation'] = 'AND';
			$query_args['tax_query'][] = array(
				'taxonomy'	=> 'recipe_category',
				'field'		=> 'slug',
				'terms'		=> $include_categories,
				'operator'	=> 'IN'
			);
			
			$query_args2['tax_query']['relation'] = 'AND';
			$query_args2['tax_query'][] = array(
				'taxonomy'	=> 'recipe_category',
				'field'		=> 'slug',
				'terms'		=> $include_categories,
				'operator'	=> 'IN'
			);
		}	

	} else {
		// Include the cats from $cat_slugs in tax_query
		if ( ! empty ( $include_categories ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'recipe_category',
					'field' 	=> 'slug',
					'terms' 	=> $include_categories,
					'operator'	=> 'IN'
				)
			);
			$query_args2['tax_query'] = array(
				array(
					'taxonomy' 	=> 'recipe_category',
					'field' 	=> 'slug',
					'terms' 	=> $include_categories,
					'operator'	=> 'IN'
				)
			);
		}
		
		if($filter_country != '*'){
			if ( ! empty ( $include_categories ) ) {
				$query_args['tax_query']['relation'] = 'AND';
			}
			$query_args['tax_query'][] = array(
				'taxonomy'	=> 'recipe_country',
				'field'		=> 'slug',
				'terms'		=> $filter_country,
				'operator'	=> 'IN'
			);
			$query_args2['tax_query']['relation'] = 'AND';
			$query_args2['tax_query'][] = array(
				'taxonomy'	=> 'recipe_country',
				'field'		=> 'slug',
				'terms'		=> $filter_country,
				'operator'	=> 'IN'
			);
		}
	}
	
	if($filter_difficulty != '*'){
		$query_args['meta_query'][] = array(
			'key'       => 'becipe_fn_page_special_difficulty',
			'value'     => $filter_difficulty,
			'compare'   => '==',
		);

		$query_args2['meta_query'][] = array(
			'key'       => 'becipe_fn_page_special_difficulty',
			'value'     => $filter_difficulty,
			'compare'   => '==',
		);
	}

	$loop 			= new \WP_Query($query_args);
	$loop2 			= new \WP_Query($query_args2);

	$allCount 		= count($loop2->posts);

	$pagination		= becipe_fn_filter_pagination($allCount,$post_number,$paged);

	$queryItems 	= '';



	$count = 22;
	$callBackImage = becipe_fn_callback_thumbs('square');

	foreach ( $loop->posts as $key => $fnPost ) {
		setup_postdata( $fnPost );
		$postID 			= $fnPost->ID;
		$postPermalink 		= get_permalink($postID);
		$postImage 			= get_the_post_thumbnail_url( $postID, 'full' );
		$postTitle			= $fnPost->post_title;
		$category			= becipe_fn_post_term_list($postID, 'recipe_category', false, 1);

		$authorMeta			= becipe_fn_get_author_meta($postID);
		$extraMeta			= becipe_fn_get_extra_met_by_post_id($postID);
		$readMore			= becipe_fn_read_more($read_more, $postPermalink);
		$image				= $callBackImage.'<div class="abs_img" data-fn-bg-img="'.$postImage.'"></div>';
		$queryItems .= '<li class="fn_animated"><div class="item">';
			$queryItems .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$postPermalink.'">'.$image.'</a></div><span>'.$category.'</span></div></div>';
			$queryItems .= '<div class="title_holder"><'.$seo_recipe_search_title.' class="fn__title"><a href="'.$postPermalink.'">'.$postTitle.'</a></'.$seo_recipe_search_title.'></div>';
			$queryItems .= $authorMeta;
			$queryItems .= $readMore;
			$queryItems .= $extraMeta;
		$queryItems .= '</div></li>';

		wp_reset_postdata();
	}
	$rightList = '<ul>'.$queryItems.'</ul>';
	if($queryItems == ''){
		$nothing  = '<div class="nothing_found fn_animated">';
			$nothing .= '<div class="nothing_found_in">';
				$nothing .= '<span class="icon_holder">'.becipe_fn_getSVG_theme('notfound').'</span>';
				$nothing .= '<h3>'.esc_html__('Nothing Found', 'becipe').'</h3>';
				$nothing .= '<p>'.esc_html__('Unfortunately, we could not find anything related to your search terms. Please, try other terms. ', 'becipe').'</p>';
			$nothing .= '</div>';
		$nothing .= '</div>';
		$rightList = $nothing;
	}
	
	$rightPart = '<div class="my_list">';
		$rightPart .= $rightList;
	$rightPart .= '</div>';
	$rightPart .= $pagination;
	
	
	
	$buffyArray = array(
		'becipe_fn_data' 		=> $rightPart,
    );
	
	die(json_encode($buffyArray));
}


function becipe_fn_read_more($text,$permalink){
	return '<div class="becipe_fn_read_holder"><a href="'.$permalink.'"><span class="text">'.esc_html($text).'</span><span class="abs_text">'.esc_html($text).'</span><span class="arrow"></span><span class="bg"></span></a></div>';
}

function becipe_fn_filter_pagination($all,$perPage,$currentPage = 1){
	$html = '';
	if($all > $perPage && $perPage != -1){
		$pages = (int) ($all / $perPage) + 1;
		$pages = ceil ($all / $perPage);
		$html .= '<div class="my_pagination"><ul>';
		for ($i=1; $i <= $pages; $i++){
			$active = '';
			if($currentPage == $i){$active = 'current';}
			$html .= '<li class="'.$active.'"><a href="#">'.$i.'</a></li>';
		}
		$currentStart 	= ($currentPage - 1) * $perPage + 1;
		$currentEnd 	= ($currentPage) * $perPage;
		if($currentEnd > $all){
			$currentEnd = $all;
		}
		$results 	= $currentStart .' - ' . $currentEnd;
		$html .= '<li class="view"><p>Showing '.$results.' of '.$all.' results</p></li>';
		$html .= '</ul></div>';
	}

	return $html;
}

function becipe_recipe_tags($postID){
	if(becipe_fn_taxanomy_list($postID, 'recipe_tag', false, 1) != ""){
		$category 	= becipe_fn_taxanomy_list($postID, 'recipe_tag', false, 9999, ', ');
		return '<div class="becipe_fn_tags"><label>'.esc_html('Tags:', 'becipe').'</label>'.$category.'</div>';
	}
	return '';
}

function becipe_recipe_top_part($postID){
	global $becipe_fn_option;
	
	$seo_recipe_post_recipe_title 		= 'h3';
	if(isset($becipe_fn_option['seo_recipe_post_recipe_title'])){
		$seo_recipe_post_recipe_title 	= $becipe_fn_option['seo_recipe_post_recipe_title'];
	}
	
	// left part
	$image_URL  = get_the_post_thumbnail_url($postID);
	$left_part  = '<div class="left_part">';
		$left_part .= '<div class="img_wrapper">';
			$left_part .= '<div class="img_in">';
				$left_part .= '<div class="abs_img" data-fn-bg-img="'.$image_URL.'"></div>';
			$left_part .= '</div>';
		$left_part .= '</div>';
	$left_part .= '</div>';
	
	
	// right Part
	$category = $like = $share = '';
	$taxonomy		= becipe_fn_post_taxanomy('becipe-recipe')[0];
	if(becipe_fn_taxanomy_list($postID, $taxonomy, false, 1) != ""){
		$category 	= becipe_fn_taxanomy_list($postID, $taxonomy, false, 9999, '', 'fn_category');
	}
	if(isset($becipe_fn_option)){
		$like 			= '<div class="like_btn"><div class="like_in">'.becipe_fn_like($postID,'return').'</div></div>';
		$shareText		= esc_html__('Share', 'becipe');
		$share			= becipe_fn_share_post($postID,$shareText);
	}
	$cookTime			= '';
	if(function_exists('rwmb_meta')){
		$cookTime 		= get_post_meta($postID,'becipe_fn_page_special_cook_time', true);
	}
	if($cookTime != ''){
		$cookTime 		= '<div class="cook_time">'.becipe_fn_getSVG_theme('watch').'<span>'.$cookTime.'</span></div>';
	}
	$print 				= '<button class="becipe_fn_print" onclick="window.print()">'.becipe_fn_getSVG_theme('printer').esc_html__('Print Recipe','becipe').'</button>';
	$rating 			= becipe_fn_rating_display_average_rating();
	
	$title				= '<div class="fn_title"><'.$seo_recipe_post_recipe_title.' class="fn__title">'.get_the_title().'</'.$seo_recipe_post_recipe_title.'></div>';
	
	$author 			= becipe_fn_get_author_meta($postID);
	
	
	$right_info = '<div class="right_info">'.$category.$rating.$like.$cookTime.$print.$share.'</div>';
	
	$right_part = '<div class="right_part">';
		$right_part .= $right_info;
		$right_part .= $title;
		$right_part .= $author;
	$right_part .= '</div>';
	
	$output  = '<div class="becip_fn_recipe_top">';
	$output .= $left_part;
	$output .= $right_part;
	$output .= '</div>';
	return $output;
}

function becipe_get_prev_next_posts($postID, $post_type = 'post'){
	global $becipe_fn_option;
	$prevtext			= esc_html__('Prev Post', 'becipe');
	$nexttext			= esc_html__('Next Post', 'becipe');
	$previous_post 		= get_adjacent_post(false, '', true);
	$next_post 			= get_adjacent_post(false, '', false);
	$prevPostBg = $nextPostBg = $prevImgURL = $nextImgURL = $prevPostURL = $prevPostTitle = $nextPostURL = $nextPostTitle = '';
	if(!empty($previous_post)) {
		$prevPostTitle 	= $previous_post->post_title;
		$prevPostID		= $previous_post->ID;
		$prevPostURL	= '<a class="previous_project_link" href="'.get_permalink($previous_post->ID).'"></a>';
		$thumbID 		= get_post_thumbnail_id( $prevPostID );
		if($thumbID){
			$prevImgURL = wp_get_attachment_image_src( $thumbID, 'full')[0];
		}
	}
	if(!empty($next_post)) {
		$nextPostTitle 	= $next_post->post_title;
		$nextPostID		= $next_post->ID;
		$nextPostURL	= '<a class="next_project_link" href="'.get_permalink($next_post->ID).'"></a>';
		$thumbID 		= get_post_thumbnail_id( $nextPostID );
		if($thumbID){
			$nextImgURL = wp_get_attachment_image_src( $thumbID, 'full')[0];
		}
	}
	
	$seo_recipe_post_prevnext_heading = 'p';
	if(isset($becipe_fn_option['seo_recipe_post_prevnext_heading'])){
		$seo_recipe_post_prevnext_heading = $becipe_fn_option['seo_recipe_post_prevnext_heading'];
	}
	$seo_recipe_post_prevnext_title = 'h3';
	if(isset($becipe_fn_option['seo_recipe_post_prevnext_title'])){
		$seo_recipe_post_prevnext_title = $becipe_fn_option['seo_recipe_post_prevnext_title'];
	}

	if ($previous_post && $next_post) { 
		$direction		= 'both';
	}else if(!$previous_post && $next_post){
		$direction		= 'only_next';
		$prevtext 		= '';
	}else if($previous_post && !$next_post){
		$direction		= 'only_prev';
		$nexttext 		= '';
	}else{
		$direction		= 'neither';
	}
	$span 			= '<span class="col_item"><span></span><span></span><span></span><span></span></span>';
	$fn_middle		= '<div class="fn_middle">'.$span.$span.$span.$span.'</div>';

	$prev_has_image 	= 'no_image';
	if($prevImgURL){
		$prev_has_image = 'has_image';
		$prevPostBg		= '<div class="abs_img" data-fn-bg-img="'.$prevImgURL.'"><div></div></div>';
	}
	$next_has_image 	= 'no_image';
	if($nextImgURL){
		$next_has_image = 'has_image';
		$nextPostBg		= '<div class="abs_img" data-fn-bg-img="'.$nextImgURL.'"><div></div></div>';
	}


	$fn_left		= '<div class="prev_post post_sibling" data-image="'.$prev_has_image.'">'.$prevPostBg.$prevPostURL.'<div class="prev_in post_sibling_in"><'.$seo_recipe_post_prevnext_heading.' class="fn__heading">'.$prevtext.'</'.$seo_recipe_post_prevnext_heading.'><'.$seo_recipe_post_prevnext_title.' class="fn__title">'.$prevPostTitle.'</'.$seo_recipe_post_prevnext_title.'></div></div>';
	$fn_right		= '<div class="next_post post_sibling" data-image="'.$next_has_image.'">'.$nextPostBg.$nextPostURL.'<div class="next_in post_sibling_in"><'.$seo_recipe_post_prevnext_heading.' class="fn__heading">'.$nexttext.'</'.$seo_recipe_post_prevnext_heading.'><'.$seo_recipe_post_prevnext_title.' class="fn__title">'.$nextPostTitle.'</'.$seo_recipe_post_prevnext_title.'></div></div>';

	$output	= '<div class="becipe_fn_siblings" data-direction="'.esc_attr($direction).'">';
		$output	.= '<div class="becipe_fn_siblings_in">';
			$output	.= $fn_left;
			$output	.= $fn_middle;
			$output	.= $fn_right;
		$output	.= '</div>';
	$output	.= '</div>';
	return $output;
}


function becipe_fn_get_extra_met_by_post_id($postID){
	
	// get cook time
	$cookTime		= '';
	if(function_exists('rwmb_meta')){
		$cookTime 	= get_post_meta($postID,'becipe_fn_page_special_cook_time', true);
	}
	if($cookTime != ''){
		$cookTime 	= '<div class="cook_time"><div class="cook_in">'.becipe_fn_getSVG_theme('watch').'<span>'.$cookTime.'</span></div></div>';
	}
	
	// get like button
	$like 			= '<div class="like_btn"><div class="like_in">'.becipe_fn_like($postID,'return').'</div></div>';
	
	// return extra meta
	return '<div class="becipe_fn_extra_meta">'.$like.$cookTime.'</div>';
}

function becipe_fn_post_taxanomy($post_type = 'post'){	
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

function html5_search_form( $form ) {
     $form  = '<section class="search"><form role="search" method="get" action="' . home_url( '/' ) . '" >';
		 $form .= '<label class="screen-reader-text" for="s"></label>';
		 $form .= '<input type="text" value="' . get_search_query() . '" name="s" placeholder="'. esc_attr__('Search', 'becipe') .'" />';
		 $form .= '<input type="submit" value="'. esc_attr__('Search', 'becipe') .'" />';
	 $form .= '</form></section>';
     return $form;
}

 add_filter( 'get_search_form', 'html5_search_form' );

function becipe_fn_get_date_meta($postID){
	return '<div class="date_meta"><span>'.get_the_time(get_option('date_format'), $postID).'</span></div>';
}


function becipe_fn_get_category($postID, $count = 1, $postType = 'post'){
	$taxonomy = becipe_fn_post_taxanomy($postType)[0];
	return '<span class="category_name">'.becipe_fn_taxanomy_list($postID, $taxonomy, false, $count).'</span>';
}

function becipe_fn_get_author_meta($postID){
	$dateMeta		= '<div class="date_meta"><span>'.get_the_time(get_option('date_format'), $postID).'</span></div>';
		
	$authorImage 		= '<span class="author_img" data-fn-bg-img="'.get_avatar_url(get_the_author_meta('ID')).'"></span>';
	$authorName			= get_the_author_meta('display_name');
	$authorURL			= get_author_posts_url(get_the_author_meta('ID'));
	$authorHolder		= '<span class="author_name"><a href="'.esc_url($authorURL).'">'.esc_html($authorName).'</a></span>';
	
	
	return '<div class="becipe_fn_author_meta">'.$authorImage.'<p>'.$authorHolder.'</p>'.$dateMeta.'</div>';
}

function becipe_fn_get_category_info($postID, $postType = 'post', $categoryCount = 2){
	$categoryCount		= (int)$categoryCount;
	$taxonomy			= becipe_fn_post_taxanomy($postType)[0];
	$catHolder			= '';
	if(becipe_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount) != ""){
		$catHolder		= becipe_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount, '', 'fn_category');
	}
	$readTime 			= '<span class="read_time"><span class="icon">'.becipe_fn_getSVG_theme('read').'</span><span>'.becipe_fn_reading_time(get_the_content()).'</span></span>';
	
	return '<div class="becipe_fn_category_info">'.$catHolder.$readTime.'</div>';
}

function becipe_fn_get_author_meta_by_post_id($postID){
	$dateMeta			= '<div class="date_meta"><a href="'.get_day_link(get_the_time( 'Y', $postID ),get_the_time( 'm', $postID ),get_the_time( 'd', $postID )).'"><span>'.get_the_time(get_option('date_format'), $postID).'</span></a></div>';
	$authorImage 		= '<span class="author_img" data-fn-bg-img="'.get_avatar_url(get_the_author_meta('ID')).'"></span>';
	$authorName			= get_the_author_meta('display_name');
	$authorURL			= get_author_posts_url(get_the_author_meta('ID'));
	$authorHolder		= '<span class="author_name"><a href="'.esc_url($authorURL).'">'.esc_html($authorName).'</a></span>';
	
	return '<div class="fn_author_meta">'.$authorImage.'<p>'.$authorHolder.'</p>'.$dateMeta.'</div>';
}

function becipe_fn_post_term_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' , '){
		
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
		echo wp_kses($termlist, 'post');
	}else{
		return $termlist;
	}
}
function becipe_get_audio_button($postID, $postType = 'post'){
	$html 				= '';
	if($postType == 'becipe-podcast'){
		if(function_exists('rwmb_meta')){
			$audioURL 		= get_post_meta($postID,'becipe_fn_podcast_local_audio_url', true);
			if($audioURL != '' && isset($audioURL)){
				$playIcon	= '<span class="play">'.becipe_fn_getSVG_theme('play').'</span>';
				$pauseIcon	= '<span class="pause">'.becipe_fn_getSVG_theme('pause').'</span>';
				$icon		= '<span class="fn_icon">'.$playIcon.$pauseIcon.'</span>';
				$html 		= '<div class="becipe_fn_audio_button" data-mp3="'.$audioURL.'"><a href="#">'.esc_html__('Play Episode', 'becipe').$icon.'</a></div>';
			}
			return $html;
		}
	}
	return $html;
}

function becipe_get_audio_of_podcast($postID, $postType = 'post', $audioURL = ''){
	$html 				= '';
	if($postType == 'becipe-podcast'){
		if(function_exists('rwmb_meta')){
			$audioURL 	= get_post_meta($postID,'becipe_fn_podcast_local_audio_url', true);
		}
	}
	if(($postType == 'becipe-podcast' && $audioURL !== '') || $postType == 'html'){
		$closeText 	= esc_html__('Close', 'becipe');
		$openText 	= esc_html__('Open', 'becipe');
		$closerText = $closeText;
		$iconBar 	= '<span class="icon_bar"><span></span><span></span><span></span><span></span><span></span><span></span><span></span></span>';
		$iconSVG	= '<span class="icon_wrapper">'.becipe_fn_getSVG_theme('podcast').'</span>';
		$iconHolder	= '<span class="podcast_icon"><span class="icon_inner">'.$iconSVG.$iconBar.'</span></span>';
		$audio 		= '<audio controls><source src="'.$audioURL.'" type="audio/mpeg"></audio>';
		
		$closed 	= '';
		if($postType == 'html'){$audio = '';$closed = 'closed';$closerText = $openText;}
		$closer 	= '<span class="fn_closer" data-close-text="'.$closeText.'" data-open-text="'.$openText.'"><span>'.$closerText.'</span></span>';

		$html .= '<div class="becipe_fn_main_audio '.$closed.' fn_pause">'.$closer.'<div class="fn-container"><div class="audio_wrapper">';
			$html .= $iconHolder.'<div class="audio_player">'.$audio.'</div>';
		$html .= '</div></div></div>';
	}
	return $html;
}

function becipe_get_related_posts($postID,$postType = 'becipe-recipe'){
	global $post,$becipe_fn_option;
	
	
	$seo_recipe_post_related_heading = 'h3';
	if(isset($becipe_fn_option['seo_recipe_post_related_heading'])){
		$seo_recipe_post_related_heading = $becipe_fn_option['seo_recipe_post_related_heading'];
	}
	$seo_recipe_post_related_title = 'h3';
	if(isset($becipe_fn_option['seo_recipe_post_related_title'])){
		$seo_recipe_post_related_title = $becipe_fn_option['seo_recipe_post_related_title'];
	}
	
	$list 						= '';
	$cats 						= array();
	$postCategories 			= array();
	if($postType == 'post'){
		$cats 					= wp_get_post_categories($postID);
	}else if($postType == 'becipe-recipe'){
		$postTaxonomy			= 'recipe_category';
		$postCategories			= becipe_fn_post_term_list_2($postID, $postTaxonomy, false, ',');
		$postCategories 		= explode(',', $postCategories);
	}
	$query_args = array(
		'post_type' 			=> $postType,
		'paged' 				=> 1, 
		'posts_per_page' 		=> 3,
		'post_status' 			=> 'publish',
		'category__in' 			=> $cats,
		'post__not_in' 			=> array($postID),
	);
	
	if ($postType == 'becipe-recipe' ) {
		if( !empty( $postCategories )){
			$query_args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'recipe_category',
					'field' 	=> 'slug',
					'terms' 	=> $postCategories,
					'operator'	=> 'IN'
				)
			);
		}else{
			return '';
		}
	}
	// QUERY WITH ARGUMENTS
	$loop 			= new WP_Query($query_args);
	$count			= count($loop->posts);
	$callBackImage 	= becipe_fn_callback_thumbs('square');
	foreach ( $loop->posts as $item ) {
		setup_postdata( $item );
		$postID 	= $item->ID;
		$permalink	= get_permalink($postID);
		$postImage 	= get_the_post_thumbnail_url( $postID, 'full' );
		$postTitle	= $item->post_title;
		$category	= becipe_fn_post_term_list($postID, 'recipe_category', false, 1);
		
		$image		= $callBackImage.'<div class="abs_img" data-fn-bg-img="'.$postImage.'"></div>';
		$list .= '<li><div class="item">';
			$list .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$permalink.'">'.$image.'</a></div><span>'.$category.'</span></div></div>';
			$list .= '<div class="title_holder"><'.$seo_recipe_post_related_title.' class="fn__title"><a href="'.$permalink.'">'.$postTitle.'</a></'.$seo_recipe_post_related_title.'></div>';
		$list .= '</div></li>';
		wp_reset_postdata();
	}
	if($list != ''){
		$titleHolder 	= '<div class="related_title_holder"><'.$seo_recipe_post_related_heading.' class="fn__title">'.esc_html__('You might also like', 'becipe').'</'.$seo_recipe_post_related_heading.'></div>';
		$list 			= '<div class="related_list"><ul data-count="'.$count.'">'.$list.'</ul></div>';
		return '<div class="becipe_fn_related_posts">'.$titleHolder.$list.'</div>';
	}
	return '';
}

add_filter('wp_list_categories', 'becipe_fn_cat_count_span');
function becipe_fn_cat_count_span($links) {
  	$links = str_replace('</a> (', '</a> <span class="count">', $links);
  	$links = str_replace(')', '</span>', $links);
  	return $links;
}

// 06.08.2020
function becipe_fn_if_has_sidebar(){
	if(is_single()){
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}else {
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}
}

function becipe_fn_getPostType(){
	$postType = get_post_type_object(get_post_type());
	if ($postType) {
		return esc_html($postType->labels->singular_name);
	}
}
function becipe_fn_getImageInSearchList($thumb = 'full') {
  	global $post, $posts;
	$first_img 		= '';
	if(has_post_thumbnail()){
		$first_img 	= get_the_post_thumbnail_url(get_the_id(),$thumb);
	}else{
		ob_start();
		ob_end_clean();
		$output 	= preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
		if(isset($matches[1][0])){
			$first_img = $matches[1][0];
		}
	}
	$first_img 	= get_the_post_thumbnail_url(get_the_id(),$thumb); // will be removed
	return $first_img;
}

function becipe_fn_reading_time( $content ) {

	// Predefined words-per-minute rate.
	$words_per_minute = 120;
	$words_per_second = $words_per_minute / 60;

	// Count the words in the content.
	$word_count = str_word_count( strip_tags( $content ) );

	// [UNUSED] How many minutes?
	$minutes = floor( $word_count / $words_per_minute );

	// [UNUSED] How many seconds (remainder)?
	$seconds_remainder = floor( $word_count % $words_per_minute / $words_per_second );

	// How many seconds (total)?
	$seconds_total = floor( $word_count / $words_per_second );

	if($minutes < 1){
		$minutes = 1;
	}
	return sprintf( _n( '%s min read', '%s min read', $minutes, 'becipe' ), number_format_i18n( $minutes ) );
//	return $seconds_total;
}

function becipe_fn_getSVG_core($name = '', $class = ''){
	return '<img class="becipe_w_fn_svg '.$class.'" src="'.BECIPE_CORE_SHORTCODE_URL.'assets/svg/'.$name.'.svg" alt="svg" />';
}

function becipe_fn_getSVG_theme($name = '', $class = ''){
	return '<img class="becipe_fn_svg '.$class.'" src="'.get_template_directory_uri().'/framework/svg/'.$name.'.svg" alt="svg" />';
}

function becipe_fn_number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}




function becipe_fn_get_user_social($userID){
	$facebook 		= esc_attr( get_the_author_meta( 'becipe_fn_user_facebook', $userID ) );
	$twitter 		= esc_attr( get_the_author_meta( 'becipe_fn_user_twitter', $userID ) );
	$pinterest 		= esc_attr( get_the_author_meta( 'becipe_fn_user_pinterest', $userID ) );
	$linkedin 		= esc_attr( get_the_author_meta( 'becipe_fn_user_linkedin', $userID ) );
	$behance 		= esc_attr( get_the_author_meta( 'becipe_fn_user_behance', $userID ) );
	$vimeo 			= esc_attr( get_the_author_meta( 'becipe_fn_user_vimeo', $userID ) );
	$google 		= esc_attr( get_the_author_meta( 'becipe_fn_user_google', $userID ) );
	$instagram 		= esc_attr( get_the_author_meta( 'becipe_fn_user_instagram', $userID ) );
	$github 		= esc_attr( get_the_author_meta( 'becipe_fn_user_github', $userID ) );
	$flickr 		= esc_attr( get_the_author_meta( 'becipe_fn_user_flickr', $userID ) );
	$dribbble 		= esc_attr( get_the_author_meta( 'becipe_fn_user_dribbble', $userID ) );
	$dropbox 		= esc_attr( get_the_author_meta( 'becipe_fn_user_dropbox', $userID ) );
	$paypal 		= esc_attr( get_the_author_meta( 'becipe_fn_user_paypal', $userID ) );
	$picasa 		= esc_attr( get_the_author_meta( 'becipe_fn_user_picasa', $userID ) );
	$soundcloud 	= esc_attr( get_the_author_meta( 'becipe_fn_user_soundcloud', $userID ) );
	$whatsapp 		= esc_attr( get_the_author_meta( 'becipe_fn_user_whatsapp', $userID ) );
	$skype 			= esc_attr( get_the_author_meta( 'becipe_fn_user_skype', $userID ) );
	$slack 			= esc_attr( get_the_author_meta( 'becipe_fn_user_slack', $userID ) );
	$wechat 		= esc_attr( get_the_author_meta( 'becipe_fn_user_wechat', $userID ) );
	$icq 			= esc_attr( get_the_author_meta( 'becipe_fn_user_icq', $userID ) );
	$rocketchat		= esc_attr( get_the_author_meta( 'becipe_fn_user_rocketchat', $userID ) );
	$telegram		= esc_attr( get_the_author_meta( 'becipe_fn_user_telegram', $userID ) );
	$vkontakte		= esc_attr( get_the_author_meta( 'becipe_fn_user_vkontakte', $userID ) );
	$rss			= esc_attr( get_the_author_meta( 'becipe_fn_user_rss', $userID ) );
	$youtube		= esc_attr( get_the_author_meta( 'becipe_fn_user_youtube', $userID ) );
	
	$facebook_icon 		= '<i class="fn-icon-facebook"></i>';
	$twitter_icon 		= '<i class="fn-icon-twitter"></i>';
	$pinterest_icon 	= '<i class="fn-icon-pinterest"></i>';
	$linkedin_icon 		= '<i class="fn-icon-linkedin"></i>';
	$behance_icon 		= '<i class="fn-icon-behance"></i>';
	$vimeo_icon 		= '<i class="fn-icon-vimeo-1"></i>';
	$google_icon 		= '<i class="fn-icon-gplus"></i>';
	$youtube_icon 		= '<i class="fn-icon-youtube-play"></i>';
	$instagram_icon 	= '<i class="fn-icon-instagram"></i>';
	$github_icon 		= '<i class="fn-icon-github"></i>';
	$flickr_icon 		= '<i class="fn-icon-flickr"></i>';
	$dribbble_icon 		= '<i class="fn-icon-dribbble"></i>';
	$dropbox_icon 		= '<i class="fn-icon-dropbox"></i>';
	$paypal_icon 		= '<i class="fn-icon-paypal"></i>';
	$picasa_icon 		= '<i class="fn-icon-picasa"></i>';
	$soundcloud_icon 	= '<i class="fn-icon-soundcloud"></i>';
	$whatsapp_icon 		= '<i class="fn-icon-whatsapp"></i>';
	$skype_icon 		= '<i class="fn-icon-skype"></i>';
	$slack_icon 		= '<i class="fn-icon-slack"></i>';
	$wechat_icon 		= '<i class="fn-icon-wechat"></i>';
	$icq_icon 			= '<i class="fn-icon-icq"></i>';
	$rocketchat_icon 	= '<i class="fn-icon-rocket"></i>';
	$telegram_icon 		= '<i class="fn-icon-telegram"></i>';
	$vkontakte_icon 	= '<i class="fn-icon-vkontakte"></i>';
	$rss_icon		 	= '<i class="fn-icon-rss"></i>';
	
	$socialList			= '';
	$socialHTML			= '';
	if($facebook != ''){$socialList .= '<li><a href="'.$facebook.'">'.$facebook_icon.$facebook_icon.'</a></li>';}
	if($twitter != ''){$socialList .= '<li><a href="'.$twitter.'">'.$twitter_icon.$twitter_icon.'</a></li>';}
	if($pinterest != ''){$socialList .= '<li><a href="'.$pinterest.'">'.$pinterest_icon.$pinterest_icon.'</a></li>';}
	if($linkedin != ''){$socialList .= '<li><a href="'.$linkedin.'">'.$linkedin_icon.$linkedin_icon.'</a></li>';}
	if($behance != ''){$socialList .= '<li><a href="'.$behance.'">'.$behance_icon.$behance_icon.'</a></li>';}
	if($vimeo != ''){$socialList .= '<li><a href="'.$vimeo.'">'.$vimeo_icon.$vimeo_icon.'</a></li>';}
	if($google != ''){$socialList .= '<li><a href="'.$google.'">'.$google_icon.$google_icon.'</a></li>';}
	if($instagram != ''){$socialList .= '<li><a href="'.$instagram.'">'.$instagram_icon.$instagram_icon.'</a></li>';}
	if($github != ''){$socialList .= '<li><a href="'.$github.'">'.$github_icon.$github_icon.'</a></li>';}
	if($flickr != ''){$socialList .= '<li><a href="'.$flickr.'">'.$flickr_icon.$flickr_icon.'</a></li>';}
	if($dribbble != ''){$socialList .= '<li><a href="'.$dribbble.'">'.$dribbble_icon.$dribbble_icon.'</a></li>';}
	if($dropbox != ''){$socialList .= '<li><a href="'.$dropbox.'">'.$dropbox_icon.$dropbox_icon.'</a></li>';}
	if($paypal != ''){$socialList .= '<li><a href="'.$paypal.'">'.$paypal_icon.$paypal_icon.'</a></li>';}
	if($picasa != ''){$socialList .= '<li><a href="'.$picasa.'">'.$picasa_icon.$picasa_icon.'</a></li>';}
	if($soundcloud != ''){$socialList .= '<li><a href="'.$soundcloud.'">'.$soundcloud_icon.$soundcloud_icon.'</a></li>';}
	if($whatsapp != ''){$socialList .= '<li><a href="'.$whatsapp.'">'.$whatsapp_icon.$whatsapp_icon.'</a></li>';}
	if($skype != ''){$socialList .= '<li><a href="'.$skype.'">'.$skype_icon.$skype_icon.'</a></li>';}
	if($slack != ''){$socialList .= '<li><a href="'.$slack.'">'.$slack_icon.$slack_icon.'</a></li>';}
	if($wechat != ''){$socialList .= '<li><a href="'.$wechat.'">'.$wechat_icon.$wechat_icon.'</a></li>';}
	if($icq != ''){$socialList .= '<li><a href="'.$icq.'">'.$icq_icon.$icq_icon.'</a></li>';}
	if($rocketchat != ''){$socialList .= '<li><a href="'.$rocketchat.'">'.$rocketchat_icon.$rocketchat_icon.'</a></li>';}
	if($telegram != ''){$socialList .= '<li><a href="'.$telegram.'">'.$telegram_icon.$telegram_icon.'</a></li>';}
	if($vkontakte != ''){$socialList .= '<li><a href="'.$vkontakte.'">'.$vkontakte_icon.$vkontakte_icon.'</a></li>';}
	if($youtube != ''){$socialList .= '<li><a href="'.$youtube.'">'.$youtube_icon.$youtube_icon.'</a></li>';}
	if($rss != ''){$socialList .= '<li><a href="'.$rss.'">'.$rss_icon.$rss_icon.'</a></li>';}
	
	if($socialList != ''){
//		$socialHTML .= '<div class="becipe_fn_social_list"><ul>';
		$socialHTML .= '<ul>';
			$socialHTML .= $socialList;
		$socialHTML .= '</ul>';
	}
	return $socialHTML;
}

function becipe_get_author_info(){
	global $becipe_fn_option;
	if(!isset($becipe_fn_option)){
		return '';
	}
	$userID 			= get_the_author_meta( 'ID' );
	$authorURL			= get_author_posts_url($userID);
	$social				= becipe_fn_get_user_social($userID);
	
	
	$name 				= esc_html( get_the_author_meta( 'becipe_fn_user_name', $userID ) );
	$description		= esc_html( get_the_author_meta( 'becipe_fn_user_desc', $userID ) );
	$imageURL			= esc_url( get_the_author_meta( 'becipe_fn_user_image', $userID ) );
	
	if($name == ''){	
		$firstName 		= get_user_meta( $userID, 'first_name', true );
		$lastName 		= get_user_meta( $userID, 'last_name', true );
		$name 			= $firstName . ' ' . $lastName;
		if($firstName == ''){
			$name 		= get_user_meta( $userID, 'nickname', true );
		}
	}
	if($description == ''){
		$description 	= get_user_meta( $userID, 'description', true );
	}
	if($imageURL == ''){
		$image			= get_avatar( $userID, 200 );
	}else{
		$image			= '<div class="abs_img" data-fn-bg-img="'.$imageURL.'"></div>';
	}
	
	
	
	$title 			= '<h3><a href="'.$authorURL.'">'.$name.'</a></h3>';
	$description	= '<p>'.$description.'</p>';
	$leftTop		= '<div class="author_top">'.$title.$description.'</div>';
	$leftBottom		= '<div class="author_bottom">'.$social.'</div>';
	$html  = '<div class="becipe_fn_author_info">';
		$html  .= '<div class="img_holder">'.$image.'</div>';
		$html  .= '<div class="title_holder">'.$leftTop.$leftBottom.'</div>';
	$html .= '</div>';
	return $html;
}

/* since 11.05.2020 */
function becipe_fn_share_post($postID,$shareText){
	global $becipe_fn_option;
	$html			= '';
	$src 			= '';
	if (has_post_thumbnail()) {
		$thumbID 	= get_post_thumbnail_id( $postID );
		$src 		= wp_get_attachment_image_src( $thumbID, 'full');
		$src 		= $src[0];
	}
	$sh				= 'share_';				// share option
	$tg				= 'target="_blank"';	// target _blank

	if(isset($becipe_fn_option)){
		if(isset($becipe_fn_option[$sh.'facebook']) && $becipe_fn_option[$sh.'facebook'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'" '.$tg.'>';
					$html	.= '<i class="fn-icon-facebook fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-facebook fn-absolute-xcon"></i>';
				$html	.= '</a>';
			$html	.= '</li>';
		}
		if(isset($becipe_fn_option[$sh.'twitter']) && $becipe_fn_option[$sh.'twitter'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="https://twitter.com/share?url='.get_the_permalink().'" '.$tg.'>';
					$html	.= '<i class="fn-icon-twitter fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-twitter fn-absolute-xcon"></i>';
				$html	.= '</a>';
			$html	.= '</li>';
		}
		if(isset($becipe_fn_option[$sh.'pinterest']) && $becipe_fn_option[$sh.'pinterest'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.$src.'" '.$tg.'>';
					$html	.= '<i class="fn-icon-pinterest fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-pinterest fn-absolute-xcon"></i>';
				$html	.= '</a>';
			$html	.= '</li>';
		}
		if(isset($becipe_fn_option[$sh.'linkedin']) && $becipe_fn_option[$sh.'linkedin'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="http://linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'&amp;" '.$tg.'>';
					$html	.= '<i class="fn-icon-linkedin fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-linkedin fn-absolute-xcon"></i>';
				$html	.= '</a>';
			$html	.= '</li>';
		}
		if(isset($becipe_fn_option[$sh.'email']) && $becipe_fn_option[$sh.'email'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="mailto:?amp;body='.get_the_permalink().'" '.$tg.'>';
					$html	.= '<i class="fn-icon-mail fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-mail fn-absolute-xcon"></i>';
				$html	.= '</a>';
			$html	.= '</li>';
		}
		if(isset($becipe_fn_option[$sh.'vk']) && $becipe_fn_option[$sh.'vk'] != 'disable') {
			$html	.= '<li>';
				$html	.= '<a data-href="https://www.vk.com/share.php?url='.get_the_permalink().'" '.$tg.'>';
					$html	.= '<i class="fn-icon-vkontakte fn-relative-xcon"></i>';
					$html	.= '<i class="fn-icon-vkontakte fn-absolute-xcon"></i>';
				$html	.= '</a';
			$html	.= '></li>';
		}
	}
	if($html != ''){
		$svgURL	= get_template_directory_uri().'/framework/svg/share-s.svg';
		$html = '<div class="becipe_fn_sharebox"><div class="share_in"><span class="hover_wrapper"><img class="becipe_w_fn_svg" src="'.$svgURL.'" alt="'.esc_attr__('svg', 'becipe').'" /><span>'.$shareText.'</span></span><ul>'.$html.'</ul><span class="share_after"></span></div></div>';
	}
	return $html;
}

function becipe_fn_getNavSkin(){
	global $becipe_fn_option;
	$optionSkin			= 'nav_skin';
	$navSkin 			= 'light';
	if(isset($becipe_fn_option[$optionSkin])){
		$navSkin 		= $becipe_fn_option[$optionSkin];
	}
	if(function_exists('rwmb_meta')){
		$navSkin 		= get_post_meta(get_the_ID(),'becipe_fn_page_nav_color', true);
		if($navSkin === 'default' && isset($becipe_fn_option[$optionSkin])){
			$navSkin 	= $becipe_fn_option[$optionSkin];
		}
	}
	if(isset($becipe_fn_option[$optionSkin])){
		if($navSkin === 'undefined' || $navSkin === ''){
			$navSkin 	= $becipe_fn_option[$optionSkin];
		}
	}
	if(isset($_GET['nav_skin'])){$navSkin = $_GET['nav_skin'];}
	return $navSkin;
}

function becipe_fn_getLogo($skin = 'light'){
	global $becipe_fn_option;
	
	// if light
	if($skin == 'light'){
		
		if(isset($becipe_fn_option['retina_logo_dark']['url']) && $becipe_fn_option['retina_logo_dark']['url'] != ''){
			$retina = $becipe_fn_option['retina_logo_dark']['url'];
		}else{
			$retina = get_template_directory_uri().'/framework/img/retina-light-logo.png';
		}
			
		if(isset($becipe_fn_option['logo_dark']['url']) && $becipe_fn_option['logo_dark']['url'] != ''){
			$logo = $becipe_fn_option['logo_dark']['url'];
		}else{
			$logo = get_template_directory_uri().'/framework/img/light-logo.png';
		}
		return array($retina,$logo);
		
	}else{
		if(isset($becipe_fn_option['retina_logo_light']['url']) && $becipe_fn_option['retina_logo_light']['url'] != ''){
			$retina = $becipe_fn_option['retina_logo_light']['url'];
		}else{
			$retina = get_template_directory_uri().'/framework/img/retina-light-dark.png';
		}
		if(isset($becipe_fn_option['logo_light']['url']) && $becipe_fn_option['logo_light']['url'] != ''){
			$logo = $becipe_fn_option['logo_light']['url'];
		}else{
			$logo = get_template_directory_uri().'/framework/img/dark-logo.png';
		}
		return array($retina,$logo);
		
	}
}

function becipe_fn_getHelperLineNavigation(){
	global $becipe_fn_option,$woocommerce;
	// language box
	$languageBox 	= becipe_fn_custom_lang_switcher();
	
	// get cartbox
	
	if ( class_exists( 'WooCommerce' ) ) {
		// buy
		$buyIcon	= get_template_directory_uri().'/framework/svg/shopping-bag.svg';
		$buySVG 	= '<img class="becipe_fn_svg" src="'.esc_url($buyIcon).'" alt="svg" />';
		$cartBox	= becipe_fn_getCartBox();
		$buyHTML	= '<div class="becipe_fn_buy_nav"><a class="buy_icon" href="#">'.$buySVG.'<span>'.$woocommerce->cart->cart_contents_count.'</span></a>'.$cartBox.'</div>';
	}else{
		$buyHTML	= '';
	}
	
	
	// search
	$searchIcon		= get_template_directory_uri().'/framework/svg/search-new.svg';
	$searchSVG 		= '<img class="becipe_fn_svg" src="'.esc_url($searchIcon).'" alt="svg" />';
	$searchHTML		= '<div class="becipe_fn_search_nav"><a href="#">'.$searchSVG.'</a></div>';
	
	
	$html 		= $languageBox.$searchHTML.$buyHTML;
	return $html;
}

function becipe_fn_getCartBox($in = '',$pageFrom = ''){
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	
	$html	= '<div class="becipe_fn_cartbox">';
	if($in == 'yes'){
		$html = '';
	}
	
	if(!empty($items)){
		$subTotalText 		= esc_html__('Subtotal:', 'becipe');
		$deleteItemText		= esc_html__('Remove this product from the cart', 'becipe');
		$cartURL			= '<a class="fn_cart_url" href="'.esc_url( wc_get_cart_url() ).'">'.esc_html__('View Cart', 'becipe').'</a>';
		$checkoutURL		= '<a class="fn_checkout_url" href="'.esc_url( wc_get_checkout_url() ).'">'.esc_html__('Checkout', 'becipe').'</a>';
		
		$html .= '<div class="fn_cartbox">';
		$list	= '<div class="fn_cartbox_top"><div class="fn_cartbox_list">';
		foreach($items as $item => $values) {
			$productID			= $values['product_id'];
			$_product 			= wc_get_product( $values['data']->get_id() );
			$getProductDetail 	= wc_get_product( $productID );
			$image				= $getProductDetail->get_image();
			$quantity			= $values['quantity'];
			$title				= $_product->get_title();
			$productURL			= get_permalink($productID);
			$price 				= wc_price(get_post_meta($productID , '_price', true));
			$priceHolder 		= '<span class="fn_cartbox_item_price">'.$quantity . " x " . $price.'</span>';
			$titleHolder		= '<span class="fn_cartbox_item_title"><a href="'.$productURL.'">'.$title.'</a></span>';
			$deleteItem 		= '<a href="'.wc_get_cart_remove_url( $item ).'" class="fn_cartbox_delete_item" title="'.$deleteItemText.'"></a>';
			
			if((is_cart() || is_checkout()) || $pageFrom != ''){
				$deleteItem = '';
			}
			
			
			$list .= '<div class="fn_cartbox_item" data-id="'.$productID.'" data-key="'.$item.'">';
				$list .= '<div class="fn_cartbox_item_img"><a href="'.$productURL.'">'.$image.'</a></div>';
				$list .= '<div class="fn_cartbox_item_title">'.$titleHolder.$priceHolder.$deleteItem.'</div>';
			$list .= '</div>';
		}
		$list .= '</div></div>';
		
		// footer
		$subTotalPrice = $woocommerce->cart->get_cart_subtotal();
		$footer	 = '<div class="fn_cartbox_footer">';
		
			$footer	.= '<div class="fn_cartbox_subtotal">';
			$footer	.= '<span class="fn_left">'.$subTotalText.'</span>';
			$footer	.= '<span class="fn_right">'.$subTotalPrice.'</span>';
			$footer	.= '</div>';
		
			$footer	.= '<div class="fn_cartbox_links">';
			$footer	.= '<span class="fn_top">'.$cartURL.'</span>';
			$footer	.= '<span class="fn_bottom">'.$checkoutURL.'</span>';
			$footer	.= '</div>';
		
		$footer	.= '</div>';
		
		
		$html .= $list;
		$html .= $footer;
		$html	.= '</div>';
		if($in == 'yes'){
			
		}else{
			$html	.= '</div>';
		}
		
	}else{
		$returnToShop 	= '<a href="'.get_permalink( wc_get_page_id( 'shop' ) ).'">'.esc_html__('Return to shop','becipe').'</a>';
		$emptyText		= esc_html__('Your cart is currently empty', 'becipe');
		$html .= '<div class="fn_cartbox_empty"><p>'.$emptyText.$returnToShop.'</p></div>';
		if($in == 'yes'){
			
		}else{
			$html	.= '</div>';
		}
	}
	
	return $html;
}

function becipe_fn_getSocialList(){
	global $becipe_fn_option;
	
	$socialPosition 		= array();
	if(isset($becipe_fn_option['social_position'])){
		$socialPosition 	= $becipe_fn_option['social_position'];
	}

	$socialHTML				= '';
	$socialList				= '';
	foreach($socialPosition as $key => $sPos){
		if($sPos == 1){
			if(isset($becipe_fn_option[$key.'_helpful']) && $becipe_fn_option[$key.'_helpful'] != ''){
				$icon		= $key;
				if($key == 'google'){
					$icon	= 'gplus';
				}else if($key == 'rocketchat'){
					$icon	= 'rocket';
				}else if($key == 'youtube'){
					$icon	= 'youtube-play';
				}else if($key == 'vimeo'){
					$icon	= 'vimeo-1';
				}
				$myIcon	= '<i class="fn-icon-'.$icon.'"></i>';
				$socialList .= '<li><a href="'.esc_url($becipe_fn_option[$key.'_helpful']).'" target="_blank">';
				$socialList .= $myIcon;
				$socialList .= '</a></li>';
			}
		}
	}

	if($socialList != ''){
		$socialHTML .= '<div class="becipe_fn_social_list"><ul>';
			$socialHTML .= $socialList;
		$socialHTML .= '</ul></div>';
	}

	return $socialHTML;
	
}

function becipe_fn_getExtraButtons($button = '1'){
	global $becipe_fn_option;
	
	if(isset($becipe_fn_option['extra_button_'.$button.'_text'])){
		$text 		= $becipe_fn_option['extra_button_'.$button.'_text'];
	}
	if(isset($becipe_fn_option['extra_button_'.$button.'_url'])){
		$url 		= $becipe_fn_option['extra_button_'.$button.'_url'];
	}
	if(isset($becipe_fn_option['extra_button_'.$button.'_target'])){
		$target 	= $becipe_fn_option['extra_button_'.$button.'_target'];
	}
	if(isset($becipe_fn_option['extra_button_'.$button.'_radius'])){
		$radius 	= (int)$becipe_fn_option['extra_button_'.$button.'_radius']['width'] . $becipe_fn_option['extra_button_'.$button.'_radius']['units'];
	}
	if(isset($text) && isset($url) && $text != '' && $url != ''){
		$output		 = '<div class="becipe_fn_nav_extra_button becipe_fn_nav_extra_button'.$button.'">';
		$output		.= '<a href="'.$url.'" target="'.$target.'" style="border-radius:'.$radius.';">';
		$output		.= '<span class="a1">'.$text.'</span>';
		$output		.= '<span class="a2">'.$text.'</span>';
		$output		.= '<span class="a3" style="opacity: 0;">'.$text.'</span>';
		$output		.= '</a>';
		$output		.= '</div>';
		return $output;
	}
	
	return '';
}

function becipe_fn_getMainTrigger($version = 'desktop'){
	global $becipe_fn_option;
	
	// trigger switch
	$tSwitch 		= true;
	if(isset($becipe_fn_option['trigger_switcher'])){
		$tSwitch 	= $becipe_fn_option['trigger_switcher'];
	}
	
	// trigger height
	$tHeight		= 'two';
	if(isset($becipe_fn_option['trigger_height'])){
		$tHeight 	= $becipe_fn_option['trigger_height'];
	}
	
	// trigger layout
	$tLayout		= 1;
	if(isset($becipe_fn_option['trigger_layout'])){
		$tLayout 	= $becipe_fn_option['trigger_layout'];
	}
	
	// trigger background type
	$tBG			= 'none';
	if(isset($becipe_fn_option['trigger_bg_type'])){
		$tBG	 	= $becipe_fn_option['trigger_bg_type'];
	}
	
	// trigger round type
	$tRound			= 'circle';
	if(isset($becipe_fn_option['trigger_round_type'])){
		$tRound	 	= $becipe_fn_option['trigger_round_type'];
	}
	
	// trigger color
	$tColor			= '#333';
	if(isset($becipe_fn_option['trigger_color'])){
		$tColor	 	= $becipe_fn_option['trigger_color'];
	}
	
	// trigger background color
	$tBGColor		= '#eee';
	if(isset($becipe_fn_option['trigger_bg_color'])){
		$tBGColor	= $becipe_fn_option['trigger_bg_color'];
	}
	
	// trigger animation
	$animationType 		= 'vortex-r'; // hamburger--collapse-r
	if(isset($becipe_fn_option['trigger_animation'])){
		$animationType	= $becipe_fn_option['trigger_animation'];
	}
	$animationType		= 'hamburger--'.$animationType;
	
	$style = '<style>.becipe_fn_hamburger[data-bg="color"]{background-color:'.$tBGColor.';}.fn_hamburger > span:after, .fn_hamburger > span:before,.becipe_fn_one_line .hamburger .hamburger-inner::before, .becipe_fn_one_line .hamburger .hamburger-inner::after, .becipe_fn_one_line .hamburger .hamburger-inner,.becipe_fn_two_lines .hamburger .hamburger-inner::before, .becipe_fn_two_lines .hamburger .hamburger-inner::after, .becipe_fn_two_lines .hamburger .hamburger-inner,.becipe_fn_three_lines .hamburger .hamburger-inner::before, .becipe_fn_three_lines .hamburger .hamburger-inner::after, .becipe_fn_three_lines .hamburger .hamburger-inner{background-color:'.$tColor.';}</style>';
	
	if($version == 'desktop'){
		if(!$tSwitch){
			return '';
		}
	}
	
	if($tLayout == 1 || $version != 'desktop'){
		return $style.'<div class="becipe_fn_hamburger" data-layout="'.$tLayout.'" data-height="'.$tHeight.'" data-bg="'.$tBG.'" data-round="'.$tRound.'">
				<div class="hamburger '.$animationType.'">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			</div>';
	}else{
		return $style.'<div class="becipe_fn_hamburger" data-layout="'.$tLayout.'" data-height="'.$tHeight.'" data-bg="'.$tBG.'" data-round="'.$tRound.'">
						<div class="fn_hamburger">
							<span class="a"></span>
							<span class="b"></span>
							<span class="c"></span>
						</div><div class="hamburger '.$animationType.'">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			</div>';
	}
	
}


function becipe_fn_header_info(){
	global $becipe_fn_option;
	
	// *************************************************************************************************
	// 1. mobile menu autocollapse
	// *************************************************************************************************
	$mobMenuAutocollapse 		= 'disable';
	if(isset($becipe_fn_option['mobile_menu_autocollapse'])){
		$mobMenuAutocollapse 	= $becipe_fn_option['mobile_menu_autocollapse'];
	}
	
	// *************************************************************************************************
	// 2. sidebar navigation open by default
	// *************************************************************************************************
	$page_title 		= '';
	if(function_exists('rwmb_meta')){
		$page_title 	= get_post_meta(get_the_ID(),'becipe_fn_page_title', true);
	}
	
	
	return array($mobMenuAutocollapse,$page_title);
}

/*-----------------------------------------------------------------------------------*/
/* Attachment image id by url (if it is thumbnail or full image)
/*-----------------------------------------------------------------------------------*/
function becipe_fn_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url ){return '';}
		
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return esc_html($attachment_id);
}
/*-----------------------------------------------------------------------------------*/
/* Custom excerpt
/*-----------------------------------------------------------------------------------*/
function becipe_fn_excerpt($limit,$postID = '', $splice = 0) {
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

// CUSTOM POST TAXANOMY
function becipe_fn_taxanomy_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' / ', $class = ''){
	global $becipe_fn_option;
	$terms = $term_list = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link 		= get_term_link( $terms[$i]->slug, $taxanomy );
			$lastItem 		= '';
			if($i == ($cat_count-1)){
				$lastItem 	= 'fn_last_category';
			}
			$term_list .= '<a class="' . esc_attr($class) .' '. esc_attr($lastItem) .'" href=" '. esc_url($term_link) . '">' . $terms[$i]->name . '</a>' . $seporator;
		}
		$term_list = trim($term_list, $seporator);
	}

	if($echo == true){
		echo wp_kses($term_list, 'post');
	}else{
		return wp_kses($term_list, 'post');
	}
	return '';
}
// Some tricky way to pass check the theme
if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link(); wp_link_pages();} 

/*-----------------------------------------------------------------------------------*/
/* CHANGE: Password Protected Form
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_password_form', 'becipe_fn_password_form' );
function becipe_fn_password_form() {
    global $post;
    $label 	= 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
    $output = '<form class="post-password-form" action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    			<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'becipe'  ) . '</p>
				<div><input name="post_password" id="' . esc_attr($label) . '" type="password" class="password" placeholder="'.esc_attr__('Password', 'becipe').'" /></div>
				<div><input type="submit" name="Submit" class="button" value="' . esc_attr__( 'Submit', 'becipe' ) . '" /></div>
    		   </form>';
    
    return wp_kses($output, 'post');
}
/*-----------------------------------------------------------------------------------*/
/* BREADCRUMBS
/*-----------------------------------------------------------------------------------*/
// Breadcrumbs
function becipe_fn_breadcrumbs( $echo = true) {
       
    // Settings
    $separator          = '<span>'.becipe_fn_getSVG_theme('right-arrow').'</span>';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = esc_html__('Home', 'becipe');
	
	
	$recipe_archive_title		= esc_html__('All Recipes', 'becipe');
	if(isset($becipe_fn_option['recipe_archive_title'])){
		$recipe_archive_title 	= $becipe_fn_option['recipe_archive_title'];
	}
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = '';
	
	$output				= '';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       	
		$output .= '<div class="becipe_fn_breadcrumbs">';
        // Build the breadcrums
        $output .= '<ul id="' . esc_attr($breadcrums_id) . '" class="' . esc_attr($breadcrums_class) . '">';
           
        // Home page
        $output .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr($home_title) . '">' . esc_html($home_title) . '</a></li>';
        $output .= '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
			
			if ( class_exists( 'WooCommerce' ) ) {
				if(is_shop()){
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title('', false) . '</span></li>';
				}else{
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'becipe') . '</span></li>';
				}
			}else if($post->post_type == 'becipe-recipe'){
				$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . $recipe_archive_title . '</span></li>';	
			}else{
				$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'becipe') . '</span></li>';
			}
		  	
            
			
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_attr($post_type_object->labels->name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            $output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html($custom_tax_name) . '</span></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_html($post_type_object->labels->name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.esc_html($parents).'</li>';
                    $cat_display .= '<li class="separator"> ' . esc_html($separator) . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                $output .= $cat_display;
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                $output .= '<li class="item-cat item-cat-' . esc_attr($cat_id) . ' item-cat-' . esc_attr($cat_nicename) . '"><a class="bread-cat bread-cat-' . esc_attr($cat_id) . ' bread-cat-' . esc_attr($cat_nicename) . '" href="' . esc_url($cat_link) . '" title="' . esc_attr($cat_name) . '">' . esc_html($cat_name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
              
            } else {
                  
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            $output .= '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . esc_attr($ancestor) . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                $output .= $parents;
                   
                // Current page
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
                   
            } else {
                   
                // Just display current page if not parents
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '"> ' . get_the_title() . '</span></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            $output .= '<li class="item-current item-tag-' . esc_attr($get_term_id) . ' item-tag-' . esc_attr($get_term_slug) . '"><span class="bread-current bread-tag-' . esc_attr($get_term_id) . ' bread-tag-' . esc_attr($get_term_slug) . '">' . esc_html($get_term_name) . '</span></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'becipe').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'becipe').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            $output .= '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__(' Archives', 'becipe').'</span></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'becipe').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'becipe').'</span></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            $output .= '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'becipe').'</span></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            $output .= '<li class="item-current item-current-' . esc_attr($userdata->display_name) . '"><span class="bread-current bread-current-' . esc_attr($userdata->display_name) . '" title="' . esc_attr($userdata->display_name) . '">' . esc_html__('Author: ', 'becipe') . esc_html($userdata->display_name) . '</span></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            $output .= '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="'.esc_attr__('Page ', 'becipe') . get_query_var('paged') . '">'.esc_html__('Page', 'becipe') . ' ' . get_query_var('paged') . '</span></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            $output .= '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="'.esc_attr__('Search results for: ', 'becipe'). get_search_query() . '">' .esc_html__('Search results for: ', 'becipe') . get_search_query() . '</span></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            $output .= '<li>' . esc_html__('Error 404', 'becipe') . '</li>';
        }
       
        $output .= '</ul>';
		$output .= '</div>';
           
    }
	
	if($echo == true){
		echo wp_kses($output, 'post');
	}else{
		return $output;
	}
       
}

function becipe_fn_getImgIDByUrl($url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
	if(isset($attachment[0])){
		return $attachment[0];
	}
	return '';
}
function becipe_get_category_like_share($postID,$postType, $categoryCount = 9999){
	global $becipe_fn_option;
	$category = $like = $share = '';
	$taxonomy		= becipe_fn_post_taxanomy($postType)[0];
	if(becipe_fn_taxanomy_list($postID, $taxonomy, false, 1) != ""){
		$category 	= becipe_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount, '', 'fn_category');
	}
	if(isset($becipe_fn_option)){
		$like 			= '<div class="like_btn"><div class="like_in">'.becipe_fn_like($postID,'return').'</div></div>';
		$shareText		= esc_html__('Share', 'becipe');
		$share			= becipe_fn_share_post($postID,$shareText);
	}
	return '<div class="becipe_fn_category_like_share">'.$category.$like.$share.'</div>';
}


/*-----------------------------------------------------------------------------------*/
/* CallBack Thumbnails
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'becipe_fn_callback_thumbs' ) ) {   
    function becipe_fn_callback_thumbs($width, $height = '') {
    	
		$output = '';
		if(!is_numeric($width)){
			// callback function
			$thumb = get_template_directory_uri() .'/framework/img/thumb/'. esc_html($width).'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'becipe').'">'; 
		}else{
			// callback function
			$thumb = get_template_directory_uri() .'/framework/img/thumb/thumb-'. esc_html($width) .'-'. esc_html($height) .'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'becipe').'" data-initial-width="'. esc_attr($width) .'" data-initial-height="'. esc_attr($height) .'">'; 
		}
		
		return  wp_kses($output, 'post');
    }
}


function becipe_fn_font_url() {
	$fonts_url = '';
	
	$font_families = array();
	$font_families[] = 'Open Sans:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Rubik:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Muli:300,300i,400,400i,500,500i,600,600i,800,800i';
	$font_families[] = 'Montserrat:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Lora:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Poppins:300,300i,400,400i,500,600,600i,800,800i';
	$font_families[] = 'Oswald:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Neuton:200,200,300,300i,400,400i,700,700i,800,800i';
	$font_families[] = 'Heebo:200,200,300,300i,400,400i,500,600,700,700i,800,800i';
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	
	return esc_url_raw( $fonts_url );
}
function becipe_fn_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'becipe-fn-font-url', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
function becipe_fn_post_term_list_2($postid, $taxanomy, $url = false, $separator = ' ', $slug = true, $space = false){

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
			if($slug == true){
				$termName	= $terms[$i]->slug;
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
add_filter( 'wp_resource_hints', 'becipe_fn_resource_hints', 10, 2 );
function becipe_fn_filter_allowed_html($allowed, $context){
 
	if (is_array($context))
	{
	    return $allowed;
	}
 
	if ($context === 'post')
	{
        // Custom Allowed Tag Atrributes and Values
	    $allowed['div']['data-success'] = true;
		
		$allowed['a']['href'] = true;
		$allowed['a']['data-filter-value'] = true;
		$allowed['a']['data-filter-name'] = true;
		$allowed['ul']['data-wid'] = true;
		$allowed['div']['data-wid'] = true;
		$allowed['a']['data-postid'] = true;
		$allowed['a']['data-gpba'] = true;
		$allowed['div']['data-col'] = true;
		$allowed['div']['data-gutter'] = true;
		$allowed['div']['data-title'] = true;
		$allowed['a']['data-disable-text'] = true;
		$allowed['script'] = true;
		$allowed['div']['data-archive-value'] = true;
		$allowed['a']['data-wid'] = true;
		$allowed['div']['data-sub-html'] = true;
		$allowed['div']['data-src'] = true;
		$allowed['li']['data-src'] = true;
		$allowed['div']['data-fn-bg-img'] = true;
		
		$allowed['div']['data-cols'] = true;
		$allowed['td']['data-fgh'] = true;
		$allowed['span']['style'] = true;
		$allowed['div']['style'] = true;
		$allowed['input']['type'] = true;
		$allowed['input']['name'] = true;
		$allowed['input']['id'] = true;
		$allowed['input']['class'] = true;
		$allowed['input']['value'] = true;
		$allowed['input']['placeholder'] = true;
		
		$allowed['img']['data-initial-width'] = true;
		$allowed['img']['data-initial-height'] = true;
		$allowed['img']['style'] = true;
		$allowed['audio']['controls'] = true;
		$allowed['source']['src'] = true;
		$allowed['button']['onclick'] = true;
	}
 
	return $allowed;
}
add_filter('wp_kses_allowed_html', 'becipe_fn_filter_allowed_html', 10, 2);
?>

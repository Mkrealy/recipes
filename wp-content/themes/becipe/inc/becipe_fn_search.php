<?php 

global $becipe_fn_option, $post;

function becipe_fn_search_filter(){
	global $becipe_fn_option;
	$seo_recipe_search_title 	= 'h3';
	if(isset($becipe_fn_option['seo_recipe_search_title'])){
		$seo_recipe_search_title = $becipe_fn_option['seo_recipe_search_title'];
	}
	
	$filter_category_array = $filter_page = $filter_difficulty = $filter_country = $include_categories = $search_term = '';
	
	
	if(!empty($_POST['filter_category_array'])){
		$filter_category_array 	= $_POST['filter_category_array'];
	}
	if(!empty($_POST['filter_page'])){
		$filter_page 			= $_POST['filter_page'];
	}
	if(!empty($_POST['filter_difficulty'])){
		$filter_difficulty 		= $_POST['filter_difficulty'];
	}
	if(!empty($_POST['filter_country'])){
		$filter_country 		= $_POST['filter_country'];
	}
	if(!empty($_POST['search_term'])){
		$search_term 			= $_POST['search_term'];
	}
	
	
	if($filter_category_array != ''){
		$include_categories		= explode(',', $filter_category_array);
	}
	
	$post_order 				= 'desc';
	$post_orderby 				= '';

	$post_number 				= get_option('posts_per_page');
	$paged 						= $filter_page;
	$query_args = array(
		'post_type' 			=> 'becipe-recipe',
		'paged' 				=> $paged,
		'posts_per_page' 		=> $post_number,
		'post_status' 			=> 'publish',
		'order' 				=> $post_order,
		'orderby' 				=> $post_orderby,
	);
	$query_args2 = array(
		'post_type' 			=> 'becipe-recipe',
		'posts_per_page' 		=> -1, // post number
		'post_status' 			=> 'publish',
		'order' 				=> $post_order,
		'orderby' 				=> $post_orderby,
	);

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

	add_filter( 'posts_where', function ( $where ) use ($search_term){
		global $wpdb;
		if ( $search_term ) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
		}
		return $where;
	}, 10, 2 );
	$loop 			= new \WP_Query($query_args);
	$loop2 			= new \WP_Query($query_args2);

	$allCount 		= count($loop2->posts);

	$pagination		= becipe_fn_filter_pagination($allCount,$post_number,$paged);

	$queryItems 	= '';

	$read_more	 	= esc_html__('Read More', 'becipe');

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
	if($search_term == ''){
		$top_text = '<div class="top_title"><p></p></div>';
	}else{
		$top_text = '<div class="top_title"><p>'.sprintf( esc_html__('Search results for: "%s"', 'becipe'), '<span>'.$search_term ).'</p></div>';
	}
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
	
	$rightPart = $top_text;
	$rightPart .= '<div class="my_list">';
		$rightPart .= $rightList;
	$rightPart .= '</div>';
	$rightPart .= $pagination;
	
	
	
	$buffyArray = array(
		'becipe_fn_data' 		=> $rightPart,
    );
	
	die(json_encode($buffyArray));
}


if( !function_exists('becipe_fn_get_custom_search_filter') ){
	function becipe_fn_get_custom_search_filter($escText,$loop,$search_term){
		$filterText 		= $escText[0];
		$allCategoriesText 	= $escText[1];
		$typeText 			= $escText[2];
		$difficultyText		= $escText[3];
		$countryText		= $escText[4];
		
		$filterText 		= '<div class="fn_filter_label">'.$filterText.'</div>';
		
		$filter__text			= becipe_fn_get_custom_search_filter__text($typeText,$search_term);
		$filter__category		= becipe_fn_get_custom_search_filter__category($allCategoriesText,$loop,$typeText);
		$filter__difficulty		= becipe_fn_get_custom_search_filter__difficulty($difficultyText,$typeText);
		$filter__country		= becipe_fn_get_custom_search_filter__country($countryText,$typeText);
		return '<div class="filter_section"><div class="filter_section_in">'.$filterText.$filter__text.$filter__category.$filter__country.$filter__difficulty.'</div></div>';
	}
}

function becipe_fn_get_custom_search_filter__country($countryText,$typeText){
		
		$html  = '<div class="becipe_fn_search_recipe_filter country_filter">';
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
					$html .= becipe_fn_get_custom_search_filter__get_country_filter_popup();
				$html  .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
function becipe_fn_get_custom_search_filter__difficulty($difficultyText,$typeText){
		
		$html  = '<div class="becipe_fn_search_recipe_filter difficulty_filter">';
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
					$html .= becipe_fn_get_custom_search_filter__get_difficulty_filter_popup();
				$html  .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
function becipe_fn_get_custom_search_filter__text($typeText,$search_term){
	$extra_class = 'ready filtered';
	if($search_term == ''){
		$extra_class = '';
	}
	$html  = '<div class="becipe_fn_search_recipe_filter text_filter '.$extra_class.'">';
		$html  .= '<div class="filter_in">';
			$html .= '<div class="input_wrapper">';
				$html .= '<input type="text" autocomplete="off" data-type="'.$typeText.'" data-placeholder="'.$typeText.'" placeholder="'.$typeText.'" value="'.$search_term.'" />';
				$html .= '<span class="icon">
							<span class="loader small">
								<span class="loader_process">
									<span class="ball"></span>
									<span class="ball"></span>
									<span class="ball"></span>
								</span>
							</span>
							<span class="reset"></span>
						</span>';
			$html  .= '</div>';
		$html .= '</div>';
	$html .= '</div>';
	return $html;
}
	
function becipe_fn_get_custom_search_filter__category($allText,$loop,$typeText){
		
	$html  = '<div class="becipe_fn_search_recipe_filter category_filter">';
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
				$html .= becipe_fn_get_custom_search_filter__get_category_filter_popup();
			$html  .= '</div>';
		$html .= '</div>';
	$html .= '</div>';
	return $html;
}
	
function becipe_fn_get_custom_search_filter__get_country_filter_popup(){
	global $becipe_fn_option;
	$fn_filter = '';
	$svg 		= '<span class="checked_icon">'.becipe_fn_getSVG_theme('checked').'</span>';
	foreach(get_terms('recipe_country') as $tax){
		$fn_filter .= '<div class="item" data-filter="'.$tax->slug.'" data-name="'.$tax->name.'"><span>'.$tax->name.$svg.'</span></div>';
	}

	$html 		= '<div class="filter_popup_list country"><div class="filter_popup_list_in">';
		$html .= $fn_filter;
	$html 	   .= '</div></div>';
	return $html;
}
	
function becipe_fn_get_custom_search_filter__get_difficulty_filter_popup(){
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
	
function becipe_fn_get_custom_search_filter__get_category_filter_popup(){
	$fn_filter	= '';
	$svg 		= '<span class="checked_icon">'.becipe_fn_getSVG_theme('checked').'</span>';
	foreach(get_terms('recipe_category') as $tax){
		$fn_filter .= '<div class="item" data-filter="'.$tax->slug.'" data-name="'.$tax->name.'"><span>'.$tax->name.$svg.'</span></div>';
	}
	$html  = '<div class="filter_popup_list category"><div class="filter_popup_list_in">';
		$html .= $fn_filter;
	$html .= '</div></div>';
	return $html;
}


if( !function_exists('becipe_fn_find_recipe_in_title') ){
	function becipe_fn_find_recipe_in_title( $where ){
		global $wpdb;
		$search_term = '';
		if(isset($_GET['s'])){
			$search_term 	= $_GET['s'];
		}
		if ( $search_term ) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
		}
		return $where;
	}
}

?>
<?php
function becipe_fn_pagination($pages = '', $range = 1, $home = 0, $type = 3){  
	$currentPage 	= '';
	$showitems 		= ($range * 1) + 1;
	$output			= '';
	
	global $becipe_fn_paged;
    
	if(get_query_var('paged')){
		$becipe_fn_paged = get_query_var('paged');
	}elseif(get_query_var('page')) {
		$becipe_fn_paged = get_query_var('page');
	}else {
		$becipe_fn_paged = 1;
	}

	global $wp_query;
	if($pages == ''){
		$pages = $wp_query->max_num_pages;
		if(!$pages){$pages = 1;}
	}


	if(1 != $pages){
		$output .= '<div class="becipe_fn_pagination fn_type_'.$type.'"><ul>';
		if($becipe_fn_paged > 1 && $showitems < $pages && $type == 1){
			$output .= "<li><a href='".get_pagenum_link(1)."' title='".esc_attr__('first','becipe')."'>&larr; </a></li>";
		}
		$list = '';
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $becipe_fn_paged+$range+1 || $i <= $becipe_fn_paged-$range-1) || $pages <= $showitems )){
				if($home == 1){
					if($becipe_fn_paged == $i){
						$list .= "<li><span class='current'>".esc_html($i)."</span></li>";
					}else{
						$list .= "<li><a href='".esc_url(add_query_arg( 'page', $i))."' class='inactive' >".esc_html($i)."</a></li>";
					}
				}else{
					if($becipe_fn_paged == $i){
						$list .= "<li class='active'><span class='current'>".esc_html($i)."</span></li>";
					}else{
						$list .= "<li><a href='".esc_url( get_pagenum_link($i))."' class='inactive' >".esc_html($i)."</a></li>";
					}
				}
				if($becipe_fn_paged == $i){
					$currentPage = $i;
				}
			}
		}
		if($currentPage != 1 && $type != 1){
			$output .= "<li class='prev'><a href='".esc_url( get_pagenum_link($currentPage-1))."' class='inactive'>".esc_html__('Prev','becipe')."<span></span></a></li>";
		}
		$output .= $list;
		if($becipe_fn_paged < $pages && $showitems < $pages && $type == 1){
			$output .= "<li><a href='".esc_url( get_pagenum_link($pages))."' title='".esc_attr__('last','becipe')."'>&rarr;</a></li>";
		}
		if($type == 1){
			$output .= '<li class="view"><p>'.sprintf('%s %s %s %s',esc_html__('Viewing page', 'becipe'), $currentPage, esc_html__('of', 'becipe'), $pages).'</p></li>';
		}

		if($currentPage < $pages && $type != 1){
			$output .= "<li class='next'><a href='".esc_url( get_pagenum_link($currentPage+1))."' class='inactive'>".esc_html__('Next','becipe')."<span></span></a></li>";
		}
		if($type == 3){
			$default_posts_per_page = get_option( 'posts_per_page' );
			$total_posts_in_this_page = $wp_query->post_count;
			$all 			= $wp_query->found_posts;
			$currentStart 	= ($currentPage - 1) * $default_posts_per_page + 1;
			$currentEnd 	= $currentStart + $total_posts_in_this_page - 1;
			$results 		= $currentStart .' - ' . $currentEnd;
			$output .= '<li class="view"><p>'.sprintf(esc_html('Showing %s of %s results','becipe'), $results, $all).'</p></li>';
		}

		$output .= "</ul></div>\n";
	}
	echo wp_kses($output, 'post');
}



?>

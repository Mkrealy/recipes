<?php

function becipe_fn_inline_styles() {
	
	global $becipe_fn_option;
	
	
	
	wp_enqueue_style('becipe_fn_inline', get_template_directory_uri().'/framework/css/inline.css', array(), '1.0', 'all');
	/************************** START styles **************************/
	$becipe_fn_custom_css 		= "";
	
	
	// Primary Color
	$primary_color 		= '#f0ca6e';
	if(isset($becipe_fn_option['primary_color'])){
		$primary_color 	= $becipe_fn_option['primary_color'];
	}
	$becipe_fn_custom_css .= "

		ul.becipe_fn_postlist .post_left,
		.becipe_fn_related_posts .img_in,
		.becipe_fn_search_recipes .my_list .img_in,
		.becipe_fn_header .recipe_content .img_in{border-color: {$primary_color};}

		.becipe-fn-wrapper code,
		.becipe-fn-wrapper pre,
		.becipe-fn-wrapper blockquote{border-left-color: {$primary_color};}


		.becipe-fn-wrapper .opt-in-hound-opt-in-form-wrapper .opt-in-hound-opt-in-form-button button:hover{background-color: {$primary_color} !important;}

		.becipe_fn_404 .search_holder span,
		.becipe_fn_widget_about .about_img:before,
		.becipe_fn_widget_about .about_img:after,
		.wid-title:after,
		.wid-title:before,
		#frenify-contact-1 .wpcf7 input[type='submit']:hover,
		.becipe_fn_search_recipes .my_list .image_holder span a,
		.becipe-fn-protected .container-custom input[type='submit'],
		.becipe_fn_search_recipes .input_wrapper .new_value,
		.becip_fn_recipe_top .fn_category,
		.becipe_fn_category_like_share .fn_category,
		.becipe_fn_related_posts .image_holder span a,
		.becipe_fn_comment #cancel-comment-reply-link:hover,
		.becipe_fn_comment .comment-text .fn_reply a:hover,
		.becipe_fn_comment input[type='submit']:hover,
		.becipe_fn_nothing_found .search_holder span,
		.becipe_fn_right_panel .panel_search a,
		.becipe_fn_pagination li span,
		.becipe_fn_pagination li a:hover,
		.becipe_fn_header .recipe_content .img_in span a,
		.becipe_fn_header .header_nav .fn_bg{background-color: {$primary_color};}
	";

	
	// Secondary Color
	$secondary_color 		= '#c00a27';
	if(isset($becipe_fn_option['secondary_color'])){
		$secondary_color 	= $becipe_fn_option['secondary_color'];
	}
	$becipe_fn_custom_css .= "
		.becipe_fn_diff_section .item_cuisine a:hover,
		.becipe-fn-wrapper.core_absent .becipe_fn_full_page_in a,
		.becipe_fn_post_content .blog_content .fn_narrow_container a,
		.becipe_fn_read_holder a,
		.becipe_fn_header .recipe_top .icon_holder{color: {$secondary_color};}
		.becipe_fn_header .recipe_content .owl-nav,
		.becipe_fn_read_holder a .arrow,
		.becipe_fn_read_holder a .arrow:after,
		.becipe_fn_read_holder a .arrow:before,
		.becipe_fn_read_holder a .bg,
		.becipe_fn_comment input[type=submit],
		.becipe_fn_related_posts .image_holder span a:hover,
		.becipe_fn_author_info .author_bottom ul li a:hover,
		.becipe_fn_category_like_share .fn_category:hover,
		.becip_fn_recipe_top .fn_category:hover,
		.becipe_fn_diff_section .item_video .icon,
		.becipe_fn_right_panel a.becipe_fn_totop,
		.becipe_fn_search_recipes .my_list .image_holder span a:hover,
		#frenify-contact-1 .wpcf7 input[type='submit'],
		.becipe_fn_social_list ul li a:after,
		.becipe_fn_header .recipe_content .img_in span a:hover{background-color: {$secondary_color};}
		
		.becipe-fn-wrapper .opt-in-hound-opt-in-form-wrapper .opt-in-hound-opt-in-form-button button{background-color: {$secondary_color} !important;}
	";
	
	
	// Heading Hover Color
	$heading_h_color 		= '#c00a27';
	if(isset($becipe_fn_option['heading_h_color'])){
		$heading_h_color 	= $becipe_fn_option['heading_h_color'];
	}
	$becipe_fn_custom_css .= "
		h1 > a:hover,
		.fn__title a:hover,
		h2 > a:hover,
		h3 > a:hover,
		h4 > a:hover,
		h5 > a:hover,
		.becipe_fn_header .recipe_content .title_holder .fn_title a:hover,
		.becipe_fn_related_posts .title_holder .fn__title a:hover,
		h6 > a:hover{color: {$heading_h_color};}
		.becipe_fn_comment h4.author a:hover,
		
		.becipe_fn_breadcrumbs ul li a:hover,
		.becipe_fn_author_info h3 a:hover,
		.becipe_fn_tags a:hover,
		.becipe-fn-footer .footer_menu ul li:hover > a,
		.widget_block a:hover,
		.becipe_fn_siblings .post_sibling:hover .fn__title,
		.becipe-fn-footer .footer_menu ul li a:hover{color: {$heading_h_color};}
		";
	
	
	// Heading Regular Color
	$heading_color 		= '#1e1e1e';
	if(isset($becipe_fn_option['heading_color'])){
		$heading_color 	= $becipe_fn_option['heading_color'];
	}

	$becipe_fn_custom_css .= "
		h1 > a,
		h2 > a,
		h3 > a,
		h4 > a,
		h5 > a,
		h6 > a,
		.fn__title a,
		.becipe_fn_siblings .fn__title,
		.becipe_fn_header .recipe_content .title_holder .fn_title a,
		.becipe_fn_related_posts .title_holder .fn__title a,
		.becipe_fn_pagetitle .fn__title,
		h1, h2, h3, h4, h5, h6{color: {$heading_color};}
		
		.becipe-fn-wrapper .opt-in-hound-opt-in-heading{color: {$heading_color} !important;}
		";
	
	
	
	// box shadow
	$box_shadow 		= 'enable';
	if(isset($becipe_fn_option['box_shadow'])){
		$box_shadow 	= $becipe_fn_option['box_shadow'];
	}
	if($box_shadow == 'disable'){
		$becipe_fn_custom_css .= "*,*:after,*:before{box-shadow: none !important;}";
	}
	
	
	// since v1.2
	$mob_nav_bg_color 				= '#0b0e13';
	if(isset($becipe_fn_option['mob_nav_bg_color'])){
		$mob_nav_bg_color 			= $becipe_fn_option['mob_nav_bg_color'];
	}
	$mob_nav_hamb_color 			= '#ccc';
	if(isset($becipe_fn_option['mob_nav_hamb_color'])){
		$mob_nav_hamb_color 		= $becipe_fn_option['mob_nav_hamb_color'];
	}
	$mob_nav_ddbg_color 			= '#c00a27';
	if(isset($becipe_fn_option['mob_nav_ddbg_color'])){
		$mob_nav_ddbg_color 		= $becipe_fn_option['mob_nav_ddbg_color'];
	}
	$mob_nav_ddlink_color 			= '#eee';
	if(isset($becipe_fn_option['mob_nav_ddlink_color'])){
		$mob_nav_ddlink_color 		= $becipe_fn_option['mob_nav_ddlink_color'];
	}
	$mob_nav_ddlink_ha_color 		= '#fff';
	if(isset($becipe_fn_option['mob_nav_ddlink_ha_color'])){
		$mob_nav_ddlink_ha_color 	= $becipe_fn_option['mob_nav_ddlink_ha_color'];
	}
	$becipe_fn_custom_css .= "
		.becipe_fn_mobilemenu_wrap .logo_hamb{background-color: {$mob_nav_bg_color};}
		.becipe_fn_mobilemenu_wrap .hamburger .hamburger-inner::before,
		.becipe_fn_mobilemenu_wrap .hamburger .hamburger-inner::after,
		.becipe_fn_mobilemenu_wrap .hamburger .hamburger-inner{
			background-color: {$mob_nav_hamb_color};
		}
		.becipe_fn_mobilemenu_wrap .mobilemenu{background-color: {$mob_nav_ddbg_color};}
		.becipe_fn_mobilemenu_wrap .vert_menu_list a{color: {$mob_nav_ddlink_color};}
		.becipe_fn_mobilemenu_wrap .vert_menu_list a:hover,
		.becipe_fn_mobilemenu_wrap .vert_menu_list li.active.menu-item-has-children > a{color: {$mob_nav_ddlink_ha_color};}
	";

	/****************************** END styles *****************************/
	if(isset($becipe_fn_option['custom_css'])){
		$becipe_fn_custom_css .= "{$becipe_fn_option['custom_css']}";	
	}

	wp_add_inline_style( 'becipe_fn_inline', $becipe_fn_custom_css );

			
}

?>
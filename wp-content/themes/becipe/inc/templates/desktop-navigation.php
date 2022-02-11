<?php 
	global $becipe_fn_option, $post;
	

	// get navigation skin
	$navigation_skin	= becipe_fn_getNavSkin();

	if($navigation_skin == 'light' || $navigation_skin == ''){
		$default_logo 	= becipe_fn_getLogo('light');
	}else{
		$default_logo 	= becipe_fn_getLogo('dark');
	}
	$logo				= '<div class="fn_logo"><a href="'.esc_url(home_url('/')).'"><img class="retina_logo" src="'.esc_url($default_logo[0]).'" alt="'.esc_attr__('logo', 'becipe').'" /><img class="desktop_logo" src="'.esc_url($default_logo[1]).'" alt="'.esc_attr__('logo', 'becipe').'" /></a></div>';



	if(has_nav_menu('main_menu')){
		$menu 			= wp_nav_menu( array('theme_location'  => 'main_menu','menu_class' => 'becipe_fn_main_nav', 'echo' => false, 'link_before' => '<span class="link">', 'link_after' => '</span>') );
	}else{
		$menu 			= '<ul class="becipe_fn_main_nav"><li><a href=""><span class="link">'.esc_html__('No menu assigned', 'becipe').'</span></a></li></ul>';
	}

	$recipe_post 		= '';
	$recipe 			= '';
	$recipe_text 		= '';
	if(isset($becipe_fn_option['week_recipe_text'])){
		$recipe_text 	= $becipe_fn_option['week_recipe_text'];
	}
	if(isset($becipe_fn_option['week_recipe_post'])){
		$recipe_post 	= $becipe_fn_option['week_recipe_post'];
	}
	if($recipe_post != ''){
		$call_back		= becipe_fn_callback_thumbs(140,91);
		$king_icon 		= becipe_fn_getSVG_theme('king');
		$recipe_content  = '<div class="recipe_content">';
		
		
		$seo_menu_recipe_title 		= 'h3';
		if(isset($becipe_fn_option['seo_menu_recipe_title'])){
			$seo_menu_recipe_title 	= $becipe_fn_option['seo_menu_recipe_title'];
		}
		
		if(count($recipe_post) > 1){
			$recipe_content .= '<div class="owl-carousel">';
			foreach($recipe_post as $recipe_item_id){
				$post_title 	= get_the_title($recipe_item_id);
				$post_url 		= get_the_permalink($recipe_item_id);
				$post_image 	= get_the_post_thumbnail_url( $recipe_item_id, 'full' );
				$post_category	= becipe_fn_post_term_list($recipe_item_id, 'recipe_category', false, 1);
				$image			= $call_back.'<div class="abs_img" data-fn-bg-img="'.$post_image.'"></div>';

				
					$recipe_content .= '<div class="item">';
						$recipe_content .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$post_url.'">'.$image.'</a></div><span>'.$post_category.'</span></div></div>';
						$recipe_content .= '<div class="title_holder"><'.$seo_menu_recipe_title.' class="fn_title"><a href="'.$post_url.'">'.$post_title.'</a></'.$seo_menu_recipe_title.'></div>';
					$recipe_content .= '</div>';
			}
			$recipe_content .= '</div>';
		}else{
			if(is_array($recipe_post)){
				$recipe_post = $recipe_post[0];
			}
			$post_title 	= get_the_title($recipe_post);
			$post_url 		= get_the_permalink($recipe_post);
			$post_image 	= get_the_post_thumbnail_url( $recipe_post, 'full' );
			$post_category	= becipe_fn_post_term_list($recipe_post, 'recipe_category', false, 1);
			$image			= $call_back.'<div class="abs_img" data-fn-bg-img="'.$post_image.'"></div>';



			$recipe_content .= '<div class="item">';
				$recipe_content .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$post_url.'">'.$image.'</a></div><span>'.$post_category.'</span></div></div>';
				$recipe_content .= '<div class="title_holder"><'.$seo_menu_recipe_title.' class="fn_title"><a href="'.$post_url.'">'.$post_title.'</a></'.$seo_menu_recipe_title.'></div>';
			$recipe_content .= '</div>';
		}
			
		$recipe_content .= '</div>';
		
		$recipe .= '<div class="recipe_holder">';
		$seo_menu_recipe_heading 		= 'span';
		if(isset($becipe_fn_option['seo_menu_recipe_heading'])){
			$seo_menu_recipe_heading 	= $becipe_fn_option['seo_menu_recipe_heading'];
		}
		$recipe .= '<div class="recipe_top"><span class="icon_holder">'.$king_icon.'</span><'.$seo_menu_recipe_heading.' class="text_holder">'.$recipe_text.'</'.$seo_menu_recipe_heading.'></div>';
		
		$recipe .= $recipe_content;
		$recipe .= '</div>';
	}

	
	
$show_more = esc_html__('Show More','becipe');
$show_less = esc_html__('Show Less','becipe');	
?>
<header class="becipe_fn_header">
	<div class="header_inner">
		
		<div class="header_logo">
			<?php echo wp_kses($logo, 'post'); ?>
		</div>
		
		<div class="header_nav_wrap">
			<div class="header_nav">
				
				<div class="header_in">
					<span class="fn_bg"></span>
					<?php echo wp_kses($menu, 'post'); ?>
				</div>
				
			</div>
		</div>
		
		<div class="header_recipe">
			<?php echo wp_kses($recipe, 'post'); ?>
		</div>
		
	</div>
</header>

<div id="becipe_fn_portable_menu"><ul></ul></div>


<!-- Right Panel Starts -->
<div class="becipe_fn_right_panel">
	
	<span class="extra_closer"></span>
	<div class="becipe_fn_recipe_search">
		<span class="search_closer"></span>
		<label for="becipe-recipe-search"></label>
		<form role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get" autocomplete="off">
			<input id="becipe-recipe-search" type="text" name="s" placeholder="<?php echo esc_attr__('Search Recipes...','becipe');?>" value="" />
			<input type="hidden" name="post_type" value="becipe-recipe" />
			<input type="submit" value="" />
		</form>
	</div>
	
	
	<div class="becipe_fn_panel">
		
		<div class="panel_top">
			<?php if(isset($becipe_fn_option)){ ?>
			<div class="panel_search">
				<a href="#"><?php echo wp_kses(becipe_fn_getSVG_theme('search'), 'post');?></a>
			</div>
			<?php } ?>
			
			<?php if(isset($becipe_fn_option)){ ?>
			<div class="panel_trigger">
				<div class="trigger">
					<span class="trigger_a"></span>
					<span class="trigger_b"></span>
					<span class="trigger_c"></span>
				</div>
				<div class="closer">
					<?php echo wp_kses(becipe_fn_getSVG_theme('cancel'), 'post'); ?>
				</div>
			</div>
			<?php } ?>
		</div>
		
			
		
		<div class="panel_bottom">
			<div class="panel_bottom_in">
			
				<?php echo wp_kses(becipe_fn_getSocialList(), 'post');?>

				<a href="#" class="becipe_fn_totop">
					<input type="hidden" value="300" />
					<?php echo wp_kses(becipe_fn_getSVG_theme('next'), 'post'); ?>
				</a>
				
			</div>
		</div>
		
	</div>
	
	
	<div class="becipe_fn_popup_sidebar">
		<div class="sidebar_wrapper">
			<?php if(is_active_sidebar( 'becipe-right-bar' )){?>
				<?php dynamic_sidebar( 'becipe-right-bar' ); ?>
			<?php }?>
		</div>
	</div>
	
</div>
<!-- Right Panel Ends -->

<div class="becipe_fn_hidden more_cats">
 	<div class="becipe_fn_more_categories"><a href="#" data-more="<?php echo esc_attr($show_more); ?>" data-less="<?php echo esc_attr($show_less); ?>"><span class="text"><?php echo esc_html($show_more); ?></span><span class="fn_count"></span></a></div>
</div>
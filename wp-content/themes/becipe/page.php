<?php 

get_header();

global $post, $becipe_fn_option;
$page_contained 		= '';
$becipe_fn_pagetitle 	= '';
$padding_top 			= '';
$padding_bottom 		= '';
$becipe_fn_page_spaces 	= '';
$becipe_fn_pagestyle 	= '';

if(function_exists('rwmb_meta')){
	$becipe_fn_pagetitle 	= get_post_meta(get_the_ID(),'becipe_fn_page_title', true);
	$page_contained		 	= get_post_meta(get_the_ID(),'becipe_fn_page_contained', true);
	$padding_top 			= get_post_meta(get_the_ID(),'becipe_fn_page_padding_top', true);
	$padding_bottom 		= get_post_meta(get_the_ID(),'becipe_fn_page_padding_bottom', true);
	$padding_left 			= get_post_meta(get_the_ID(),'becipe_fn_page_padding_left', true);
	$padding_right 			= get_post_meta(get_the_ID(),'becipe_fn_page_padding_right', true);
	
	$becipe_fn_page_spaces = 'style=';
	if($padding_top != ''){$becipe_fn_page_spaces .= 'padding-top:'.$padding_top.'px;';}
	if($padding_bottom != ''){$becipe_fn_page_spaces .= 'padding-bottom:'.$padding_bottom.'px;';}
	if($padding_left != ''){$becipe_fn_page_spaces .= 'padding-left:'.$padding_left.'px;';}
	if($padding_right != ''){$becipe_fn_page_spaces .= 'padding-right:'.$padding_right.'px;';}
	if($padding_top == '' && $padding_bottom == '' && $padding_left == '' && $padding_right == ''){$becipe_fn_page_spaces = '';}
	// page styles
	$becipe_fn_pagestyle 	= get_post_meta(get_the_ID(),'becipe_fn_page_style', true);
}

if($becipe_fn_pagestyle == 'ws' && !becipe_fn_if_has_sidebar()){
	$becipe_fn_pagestyle	= 'full';
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = '<div class="becipe-fn-protected"><div class="in">';
		$protected .= '<div class="message_holder">';
			$protected .= '<span class="icon">'.becipe_fn_getSVG_theme('lock').'</span>';
			$protected .= '<h3>'.esc_html__('Protected','becipe').'</h3>';
			$protected .= '<p>'.esc_html__('Please, enter the password to have access to this page.','becipe').'</p>';
			$protected .= get_the_password_form();
		$protected .= '</div>';
	$protected .= '</div></div>';
	echo wp_kses($protected, 'post');
}
else
{
 	$seo_page_title 			= 'h3';
	if(isset($becipe_fn_option['seo_page_title'])){
		$seo_page_title 		= $becipe_fn_option['seo_page_title'];
	}
	$seo_page_title__start = sprintf( '<%1$s class="fn__title">', $seo_page_title );
	$seo_page_title__end = sprintf( '</%1$s>', $seo_page_title );
?>




<div class="becipe_fn_full_page_template fn_page_contained_<?php echo esc_attr($page_contained);?>">
	<?php if($becipe_fn_pagetitle !== 'disable'){ ?>
		<!-- PAGE TITLE -->
		<div class="becipe_fn_pagetitle">
			<div class="title_holder">
				<?php echo $seo_page_title__start; ?><?php the_title(); ?><?php echo $seo_page_title__end; ?>
			</div>
		</div>
		<!-- /PAGE TITLE -->
	<?php } ?>
		
	<?php if($becipe_fn_pagestyle == 'ws'){ ?>
	
	<div class="becipe_fn_hassidebar">
		<div class="becipe_fn_leftsidebar">
	<?php } ?>
				
			<div class="becipe_fn_container">
				<div class="becipe_fn_container_in">
					<?php if($becipe_fn_pagetitle !== 'disable'){becipe_fn_breadcrumbs();}?>
					<!-- ALL PAGES -->		
					<div class="becipe_fn_full_page_in" <?php echo esc_attr($becipe_fn_page_spaces); ?>>
						<!-- PAGE -->
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php the_content(); ?>
						
							<?php wp_link_pages(
								array(
									'before'      => '<div class="becipe_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'becipe' ). '</span>',
									'after'       => '</div>',
									'link_before' => '<span class="number">',
									'link_after'  => '</span>',
								)); 
							?>

							<?php if ( comments_open() || get_comments_number()){?>
							<!-- Comments -->
							<div class="becipe_fn_comment" id="comments">
								<div class="comment_in">
									<?php comments_template(); ?>
								</div>
							</div>
							<!-- /Comments -->
							<?php } ?>

						<?php endwhile; endif; ?>
						<!-- /PAGE -->
					</div>		
					<!-- /ALL PAGES -->
				</div>
			</div>
		<?php if($becipe_fn_pagestyle == 'ws'){ ?>
		</div>
		<?php } ?>
		<?php if($becipe_fn_pagestyle == 'ws'){?>
			<div class="becipe_fn_rightsidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
		<?php } ?>
</div>





<?php } ?>

<?php get_footer(); ?>  
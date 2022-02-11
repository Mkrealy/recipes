<?php
/*
	Template Name: Blog Page
*/
get_header();

global $post, $becipe_fn_option;
$becipe_fn_pagetitle 	= '';
$becipe_fn_top_padding 	= '';
$becipe_fn_bot_padding 	= '';
$becipe_fn_page_spaces 	= '';
$becipe_fn_pagestyle 	= 'ws';

if(function_exists('rwmb_meta')){
	$becipe_fn_pagetitle 		= get_post_meta(get_the_ID(),'becipe_fn_page_title', true);
	$becipe_fn_top_padding 		= get_post_meta(get_the_ID(),'becipe_fn_page_padding_top', true);
	$becipe_fn_bot_padding 		= get_post_meta(get_the_ID(),'becipe_fn_page_padding_bottom', true);
	
	$becipe_fn_page_spaces = 'style=';
	if($becipe_fn_top_padding != ''){$becipe_fn_page_spaces .= 'padding-top:'.$becipe_fn_top_padding.'px;';}
	if($becipe_fn_bot_padding != ''){$becipe_fn_page_spaces .= 'padding-bottom:'.$becipe_fn_bot_padding.'px;';}
	if($becipe_fn_top_padding == '' && $becipe_fn_bot_padding == ''){$becipe_fn_page_spaces = '';}
	
	// page styles
	$becipe_fn_pagestyle 		= get_post_meta(get_the_ID(),'becipe_fn_page_style', true);
}

if(isset($_GET['blog_layout'])){$becipe_fn_pagestyle = $_GET['blog_layout'];}

if($becipe_fn_pagestyle == 'ws' && !becipe_fn_if_has_sidebar()){
	$becipe_fn_pagestyle		= 'full';
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
	
	$pageContent = get_the_content();
	$pageTitle	= esc_html__('Latest News', 'becipe');
	if($becipe_fn_pagetitle !== 'disable'){ ?>
	<!-- PAGE TITLE -->
	<div class="becipe_fn_pagetitle">
		<div class="title_holder">
			<?php echo $seo_page_title__start; ?><?php the_title();?><?php echo $seo_page_title__end; ?>
		</div>
	</div>
	<!-- /PAGE TITLE -->
	<?php } ?>

	<div class="fn_page_blog becipe_fn_container">
		<div class="becipe_fn_container_in">
			<?php if($becipe_fn_pagetitle !== 'disable'){becipe_fn_breadcrumbs();}?>

			<?php if($becipe_fn_pagestyle == 'full'){ ?>

			<!-- WITHOUT SIDEBAR -->
			<div class="becipe_fn_nosidebar" <?php echo esc_attr($becipe_fn_page_spaces); ?>>
				<ul class="becipe_fn_postlist">
					<?php get_template_part( 'inc/templates/posts' );?>
				</ul>
			</div>
			<!-- /WITHOUT SIDEBAR -->

			<?php }else{ ?>

			<!-- WITH SIDEBAR -->
			<div class="becipe_fn_hassidebar">
				<div class="becipe_fn_leftsidebar" <?php echo esc_attr($becipe_fn_page_spaces); ?>>
					<div class="sidebar_in">
						<ul class="becipe_fn_postlist">
							<?php get_template_part( 'inc/templates/posts' );?>
						</ul>
					</div>
				</div>

				<div class="becipe_fn_rightsidebar" <?php echo esc_attr($becipe_fn_page_spaces); ?>>
					<div class="sidebar_in">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
			<!-- /WITH SIDEBAR -->

			<?php } ?>
		</div>
	</div>
	<?php becipe_fn_pagination(); ?>



	<?php if($pageContent !== ''){ ?>
	<div class="becipe_fn_container becipe_fn_blog_content">
		<div class="becipe_fn_container_in">
			<div class="blog_content">
				<?php echo wp_kses($pageContent, 'post'); ?>
			</div>
		</div>
	</div>	
	<?php } ?>


<?php } ?>

<?php get_footer(); ?>  
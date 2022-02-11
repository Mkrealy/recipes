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

$seo_page_title 			= 'h3';
if(isset($becipe_fn_option['seo_page_title'])){
	$seo_page_title 		= $becipe_fn_option['seo_page_title'];
}
$seo_page_title__start = sprintf( '<%1$s class="fn__title">', $seo_page_title );
$seo_page_title__end = sprintf( '</%1$s>', $seo_page_title );
?>
        
    
        <div class="becipe-fn-content_archive">
			
			<div class="becipe_fn_pagetitle">
				<div class="title_holder">
					<?php echo $seo_page_title__start; ?>
					<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
					<?php /* If this is a category archive */ if (is_category()) { ?>
						<?php printf(esc_html__('All posts in %s', 'becipe'), single_cat_title('',false)); ?>
					<?php /* If this is a tag archive */ } elseif( is_tax() ) { $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); if($term->taxonomy == 'recipe_tag'){ ?>
						<?php printf(esc_html__('All recipes tagged in %s', 'becipe'), $term->name ); }else{?>
						<?php printf(esc_html__('All posts in %s', 'becipe'), $term->name ); ?>
					<?php /* If this is a tag archive */ }} elseif( is_tag() ) { ?>
						<?php printf(esc_html__('All posts tagged in %s', 'becipe'), single_tag_title('',false)); ?>
					<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
						<?php esc_html_e('Archive for', 'becipe') ?> <?php the_time(get_option('date_format')); ?>
					 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
						<?php esc_html_e('Archive for', 'becipe') ?> <?php the_time('F, Y'); ?>
					<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
						<?php esc_html_e('Archive for', 'becipe') ?> <?php the_time('Y'); ?>
					<?php /* If this is an author archive */ } elseif (is_author()) { ?>
						<?php esc_html_e('All posts by', 'becipe') ?> <?php echo esc_html($currentAuthor->display_name); ?>
					<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<?php esc_html_e('Blog Archives', 'becipe') ?>
					<?php }else if($post->post_type == 'becipe-recipe'){?>
						<?php echo esc_html($recipe_archive_title); ?>
					<?php } ?>
					<?php echo $seo_page_title__end; ?>
				</div>
				
			</div>
			
			<div class="becipe_fn_container">
				<div class="becipe_fn_container_in">
					<?php becipe_fn_breadcrumbs();?>
					<div class="fn_container">
						<ul class="becipe_fn_postlist">
							<?php get_template_part( 'inc/templates/posts' );?>
						</ul>
					</div>
				</div>
			</div>
			<?php becipe_fn_pagination(); ?>
        </div>
		<!-- /MAIN CONTENT -->
        
<?php get_footer(); ?>   
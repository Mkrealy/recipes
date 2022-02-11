<?php 

global $becipe_fn_option;
$post_type				= 'post';
if (isset($args['post_type'])) {
	$post_type 			= $args['post_type'];
}
$has_sidebar			= 'full';
if (isset($args['has_sidebar'])) {
	$has_sidebar 		= $args['has_sidebar'];
}
if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$authorMeta 		= becipe_fn_get_author_meta($post_ID);
	$post_title 		= '<div class="post_title"><h3>'.get_the_title().'</h3></div>';

	$post_thumbnail_id 	= get_post_thumbnail_id( $post_ID );
	$src 				= wp_get_attachment_image_src( $post_thumbnail_id, 'full');
	$image_URL 			= '';
	$has_image			= 0;
	if(isset($src[0])){
		$image_URL 		= $src[0];
	}
	if($image_URL != ''){
		$has_image		= 1;
	}
	
	$category_box		= becipe_fn_get_category_info($post_ID,$post_type, 999);

	$getInfoAboutAuthor = becipe_get_author_info();

	$prev_next_posts	= becipe_get_prev_next_posts($post_ID);
?>

<!-- POST HEADER -->
<div class="becipe_fn_post_header" data-image="<?php echo esc_attr($has_image);?>">
	<div class="post_header_bg" data-fn-bg-img="<?php echo esc_url($image_URL);?>"></div>
</div>
<!-- /POST HEADER -->


<!-- POST CONTENT -->
<div class="becipe_fn_post_content fn_<?php echo esc_attr($has_sidebar);?>" data-image="<?php echo esc_attr($has_image);?>">
	
	<div class="author_meta_content">
		<div class="becipe_fn_container">
			<div class="author_meta_wrapper">
				<?php echo wp_kses($authorMeta, 'post');?>
			</div>
		</div>
	</div>
	
	<?php if($has_sidebar != 'full'){ ?>
	
	<div class="becipe_fn_hassidebar">

		<div class="becipe_fn_leftsidebar">
			<div class="becipe_fn_blog_single">
				

	<?php } ?>
		
	<div class="becipe_fn_container">
		<div class="becipe_fn_container_in">
			
			<div class="fn_narrow_container">
				<?php echo wp_kses($category_box, 'post');?>
				<?php echo wp_kses($post_title, 'post');?>
			</div>
	
			
			<div class="blog_content">
				<?php if(!isset($becipe_fn_option)){ ?>
				<div class="fn_narrow_container">
				<?php }else{ ?>
				<div class="blog_in">
				<?php } ?>
					<?php the_content(); ?>
				</div>
			</div>
	
	
			<div class="fn_narrow_container">
				<?php echo wp_kses($getInfoAboutAuthor, 'post');?>
				<?php if(has_tag()){?>
					<div class="becipe_fn_tags">
						<label><?php the_tags(esc_html_e('Tags:', 'becipe').'</label>', ', '); ?>
					</div>
				<?php } ?>
			</div>
			<?php wp_link_pages(
				array(
					'before'      => '<div class="fn_narrow_container"><div class="becipe_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'becipe' ). '</span>',
					'after'       => '</div></div>',
					'link_before' => '<span class="number">',
					'link_after'  => '</span>',
				)); 
			?>
			<!-- /POST CONTENT -->

			<?php if ( comments_open() || get_comments_number()){?>
			<!-- POST COMMENT -->
			<div class="fn_container">
				<div class="becipe_fn_comment" id="comments">
					<div class="comment_in">
						<?php comments_template(); ?>
					</div>
				</div>
			</div>
			<!-- /POST COMMENT -->
			<?php } ?>
	
		</div>
	</div>
	
		
	<?php if($has_sidebar != 'full'){?>
		</div>
	</div>
	<?php } ?>	
		
		
	<?php if($has_sidebar != 'full'){?>
		<div class="becipe_fn_rightsidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php } ?>
		
		
		<?php echo wp_kses($prev_next_posts, 'post'); ?>
</div>
<?php endwhile; endif;wp_reset_postdata();?>
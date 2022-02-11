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
	

	$getInfoAboutAuthor = becipe_get_author_info();

	$prev_next_posts	= becipe_get_prev_next_posts($post_ID);

	$recipe_top_part	= becipe_recipe_top_part($post_ID);

	$recipe_difficulty	= becipe_recipe_difficulty_section($post_ID);
?>

<?php echo wp_kses($recipe_top_part, 'post'); ?>


<!-- POST CONTENT -->
<div class="becipe_fn_recipe_content">
	
	
	<div class="becipe_fn_container">
		
		
		<?php echo wp_kses($recipe_difficulty, 'post'); ?>
		
		<div class="becipe_fn_container_in">
			
			<div class="recipe_content">
				<?php the_content(); ?>
			</div>
			
		</div>
	</div>
	
	<div class="becipe_fn_container">
		<div class="becipe_fn_container_in">
			
			<?php if(has_tag()){?>
				<div class="becipe_fn_tags">
					<label><?php the_tags(esc_html_e('Tags:', 'becipe').'</label>', ', '); ?>
				</div>
			<?php } ?>
					
			<?php 
				$tags = becipe_recipe_tags($post_ID);
				echo wp_kses($tags, 'post');
			?>
			
		</div>
	</div>
	<?php 
		$comment_area 		= false;
		$related_area 		= false;
		if ( comments_open() || get_comments_number()){
			$comment_area 	= true;
		}
		$related_posts		= becipe_get_related_posts($post_ID);
		if ( $related_posts != ''){
			$related_area 	= true;
		}
	?>
	
	<div class="becipe_fn_container fn_comment_related" data-comment="<?php echo esc_attr($comment_area); ?>" data-related="<?php echo esc_attr($related_area); ?>">
		<div class="becipe_fn_container_in">
			
			<?php if ($comment_area){?>
			<!-- POST COMMENT -->
			<div class="becipe_fn_comment" id="comments">
				<div class="comment_in">
					<?php comments_template(); ?>
				</div>
			</div>
			<!-- /POST COMMENT -->
			<?php } ?>
			
			<?php echo wp_kses($related_posts, 'post'); ?>
			
		</div>
	</div>
		<?php echo wp_kses($prev_next_posts, 'post'); ?>
	
</div>
<?php endwhile; endif;wp_reset_postdata();?>
<?php 

get_header();
global $becipe_fn_option;

$searchText = esc_html__('Search anything...','becipe');


// SEO
$seo_404_number 			= 'h2';
if(isset($becipe_fn_option['seo_404_number'])){
	$seo_404_number 		= $becipe_fn_option['seo_404_number'];
}
$seo_404_number__start 		= sprintf( '<%1$s class="fn__title">', $seo_404_number );
$seo_404_number__end 		= sprintf( '</%1$s>', $seo_404_number );

$seo_404_not_found 			= 'h3';
if(isset($becipe_fn_option['seo_404_not_found'])){
	$seo_404_not_found 		= $becipe_fn_option['seo_404_not_found'];
}
$seo_404_not_found__start 	= sprintf( '<%1$s class="fn__heading">', $seo_404_not_found );
$seo_404_not_found__end 	= sprintf( '</%1$s>', $seo_404_not_found );

$seo_404_desc 				= 'p';
if(isset($becipe_fn_option['seo_404_desc'])){
	$seo_404_desc 			= $becipe_fn_option['seo_404_desc'];
}
$seo_404_desc__start 		= sprintf( '<%1$s class="fn__desc">', $seo_404_desc );
$seo_404_desc__end 			= sprintf( '</%1$s>', $seo_404_desc );
?>
          	
<!-- ERROR PAGE -->
<div class="becipe_fn_404">
	<div class="fn_container">
		<div class="error_wrap">
			<div class="error_box">
				<div class="title_holder">
					<?php echo $seo_404_number__start; ?><?php esc_html_e('404', 'becipe') ?><?php echo $seo_404_number__end; ?>
					<?php echo $seo_404_not_found__start; ?><?php esc_html_e('Page Not Found', 'becipe') ?><?php echo $seo_404_not_found__end; ?>
					<?php echo $seo_404_desc__start; ?><?php esc_html_e('Sorry, but the page you are looking for was moved, removed, renamed or might never existed...', 'becipe') ?><?php echo $seo_404_desc__end; ?>
				</div>
				<div class="search_holder">
					<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
						<div>
							<input type="text" placeholder="<?php echo esc_attr($searchText);?>" name="s" autocomplete="off" />
							<input type="submit" class="pe-7s-search" value="" />
							<span><?php echo wp_kses(becipe_fn_getSVG_theme('search'), 'post');?></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /ERROR PAGE -->

        
<?php get_footer(); ?>
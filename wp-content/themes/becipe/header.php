<!DOCTYPE html >
<html <?php language_attributes(); ?>>
<head>
<?php global $becipe_fn_option, $post; ?>

<meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php wp_head(); ?>

</head>
<?php 
	
	$options				= becipe_fn_header_info();
	$navigation_skin		= becipe_fn_getNavSkin();
	$mobile_autocollapse	= $options[0];
	$page_title				= $options[1];
	$core_ready				= 'core_absent';
	if(isset($becipe_fn_option)){
		$core_ready 		= 'core_ready';
	}
?>
<body <?php body_class();?>>
	<?php wp_body_open(); ?>

	<!-- HTML starts here -->
	<div class="becipe-fn-wrapper <?php echo esc_attr($core_ready); ?>" data-mobile-autocollapse="<?php echo esc_attr($mobile_autocollapse); ?>" data-page-title="<?php echo esc_attr($page_title); ?>" data-skin="<?php echo esc_attr($navigation_skin);?>">


		<!-- Header starts here -->
		<?php get_template_part( 'inc/templates/desktop-navigation' );?>
		<!-- Header ends here -->


		<!-- Mobile Menu starts here -->
		<?php get_template_part( 'inc/templates/mobile-navigation' );?>
		<!-- Mobile Menu ends here -->


		<!-- All website content starts here -->
		<div class="becipe_fn_content">
			
			<!-- All content without footer starts here -->
			<div class="becipe_fn_pages">
			<link rel="stylesheet" href="http://oceanwp.test/wp-content/plugins/DarkMode/assets/darkMode.css">
				
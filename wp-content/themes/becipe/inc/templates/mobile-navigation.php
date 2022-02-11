<?php 
	global $becipe_fn_option, $post;
	
	$mobileLogo 				= get_template_directory_uri().'/framework/img/mobile-logo.png';
	
	$logoMobile 				= $logoMobileURL = '';
	if(isset($becipe_fn_option['mobile_logo'])){
		$logoMobile 			= $becipe_fn_option['mobile_logo'];
	}
	if(isset($becipe_fn_option['mobile_logo']['url'])){
		$logoMobileURL 			= $becipe_fn_option['mobile_logo']['url'];
	}
	if(isset($logoMobile) && isset($logoMobileURL)){
		if($logoMobileURL !== ''){
			$mobileLogo 		= $logoMobileURL;
		}
	}

	$mobMenuOpen 				= 'disable';
	$mobileHambClass			= '';
	$mobileActiveClass			= '';
	$mobileMenuDisplay			= 'none';
	if(isset($becipe_fn_option['mobile_menu_open_default'])){
		$mobMenuOpen	 		= $becipe_fn_option['mobile_menu_open_default'];
		if($mobMenuOpen == 'enable'){
			$mobileMenuDisplay	= 'block';
			$mobileHambClass	= 'is-active';
		}
	}
?>
   
<!-- MOBILE MENU -->
<div class="becipe_fn_mobilemenu_wrap">


	<!-- LOGO & HAMBURGER -->
	<div class="logo_hamb">
		<div class="in">
			<div class="menu_logo">
				<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($mobileLogo);?>" alt="<?php esc_attr(bloginfo('description')); ?>" /></a>
			</div>
			<?php if(has_nav_menu('mobile_menu')){ ?>
				<div class="hamburger hamburger--collapse-r <?php echo esc_attr($mobileHambClass);?>">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- /LOGO & HAMBURGER -->

	<!-- MOBILE DROPDOWN MENU -->
	<?php if(has_nav_menu('mobile_menu')){ ?>
		<div class="mobilemenu <?php echo esc_attr($mobileActiveClass);?>" style="display: <?php echo esc_attr($mobileMenuDisplay);?>">
			<?php wp_nav_menu(  array('theme_location'  => 'mobile_menu','menu_class' => 'vert_menu_list nav_ver','menu_id' => 'vert_menu_list') ); ?>
		</div>
	<?php } ?>
	<!-- /MOBILE DROPDOWN MENU -->

</div>
<!-- /MOBILE MENU -->
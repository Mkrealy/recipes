<?php
function becipe_fn_fonts() {
	global $becipe_fn_option;
	$customfont = '';
	
	$default = array(
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica');
	$bodyFont = $navFont = $navMobFont = $headingFont = $blockquoteFont = $extraFont = '';
	if(isset($becipe_fn_option['body_font']['font-family'])){$bodyFont = $becipe_fn_option['body_font']['font-family'];}
	if(isset($becipe_fn_option['nav_font']['font-family'])){$navFont = $becipe_fn_option['nav_font']['font-family'];}
	if(isset($becipe_fn_option['nav_mob_font']['font-family'])){$navMobFont = $becipe_fn_option['nav_mob_font']['font-family'];}
	if(isset($becipe_fn_option['heading_font']['font-family'])){$headingFont = $becipe_fn_option['heading_font']['font-family'];}
	if(isset($becipe_fn_option['blockquote_font']['font-family'])){$blockquoteFont = $becipe_fn_option['blockquote_font']['font-family'];}
	if(isset($becipe_fn_option['extra_font']['font-family'])){$extraFont = $becipe_fn_option['extra_font']['font-family'];}
	
	$googlefonts = array(
					$bodyFont,
					$navFont,
					$navMobFont,
					$headingFont,
					$blockquoteFont,
					$extraFont,
					);
				
	foreach($googlefonts as $getfonts) {
		
		if(!in_array($getfonts, $default)) {
				$customfont = str_replace(' ', '+', $getfonts). ':400,400italic,500,500italic,600,600italic,700,700italic|' . $customfont;
		}
	}
	
	
	
	
	if($customfont != '' && isset($becipe_fn_option)){
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'becipe_fn_googlefonts', "$protocol://fonts.googleapis.com/css?family=" . substr_replace($customfont ,"",-1) . "&subset=latin,cyrillic,greek,vietnamese" );
	}	
}
add_action( 'wp_enqueue_scripts', 'becipe_fn_fonts' );
?>
<?php

get_header();

global $post, $becipe_fn_option;
$becipe_fn_pagetitle = '';
$becipe_fn_pagestyle = 'ws';

if(function_exists('rwmb_meta')){
	$becipe_fn_pagetitle 			= get_post_meta(get_the_ID(),'becipe_fn_page_title', true);
	$becipe_fn_pagestyle 			= get_post_meta(get_the_ID(),'becipe_fn_page_style', true);
}
if($becipe_fn_pagestyle == 'ws' && !becipe_fn_if_has_sidebar()){
	$becipe_fn_pagestyle			= 'full';
}

if($becipe_fn_pagestyle == 'ws' && !becipe_fn_if_has_sidebar()){
	$becipe_fn_pagestyle			= 'full';
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

?>
<div class="becipe_fn_single_template">

	<?php if($becipe_fn_pagestyle == 'full'){ ?>

	<!-- WITHOUT SIDEBAR -->
	<div class="becipe_fn_nosidebar">
		<div class="inner">
			<div class="becipe_fn_blog_single">
				<?php get_template_part( 'inc/templates/single-post-template' );?>
			</div>
		</div>
	</div>
	<!-- /WITHOUT SIDEBAR -->

	<?php }else{ ?>
	
	<!-- WITH SIDEBAR -->
	<?php get_template_part( 'inc/templates/single-post-template', '', array('has_sidebar' => $becipe_fn_pagestyle) );?>
	<!-- /WITH SIDEBAR -->

	<?php } ?>
				
</div>
<?php } ?>

<?php get_footer(); ?>  
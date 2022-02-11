<?php 
	global $becipe_fn_option;

	// text #1
	$text 			= esc_html__('Copyright 2020. Designed by Frenify. Developed with &#10084; in London.', 'becipe');
	if(isset($becipe_fn_option['footer_text'])){
		$text 		= $becipe_fn_option['footer_text'];
	}
	$text__html		= '<div class="footer_text"><p>'.$text.'</p></div>';

	$menu__html		= '';
	if(has_nav_menu('footer_menu')){$menu__html = '<div class="footer_menu">'.wp_nav_menu( array('theme_location'  => 'footer_menu','menu_class' => 'footer_nav', 'echo' => false) ).'</div>';}

	$html = $menu__html.$text__html;
?>

			<!-- Footer starts here-->
			<footer class="becipe-fn-footer">
				<?php echo wp_kses($html, 'post');?>
			</footer>
			<!-- Footer end here-->

		</div>
		<!-- All content without footer starts here -->			
			
	</div>
	<!-- All website content starts here -->

</div>
<!-- HTML ends here -->


<?php wp_footer(); ?>
</body>
</html>
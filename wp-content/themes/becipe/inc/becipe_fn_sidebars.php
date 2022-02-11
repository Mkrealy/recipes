<?php

/* ------------------------------------------------------------------------ */
/* Define Sidebars */
/* ------------------------------------------------------------------------ */

add_action( 'widgets_init', 'becipe_fn_widgets_init', 1000 );


function becipe_fn_widgets_init() {
	if (function_exists('register_sidebar')) {
		
		global $becipe_fn_option;
		
			/* ------------------------------------------------------------------------ */
			/* Footer Left Part Widget
			/* ------------------------------------------------------------------------ */
			
			register_sidebar(array(
				'name' => 'Right Bar',
				'id'   => 'becipe-right-bar',
				'description'   => esc_html__('This is widget for right popup bar.', 'becipe'),
				'before_widget' => '<div id="%1$s" class="widget_block clearfix %2$s"><div>',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="wid-title"><span>',
				'after_title'   => '</span></div>'
			));
		
		
			/* ------------------------------------------------------------------------ */
			/* Sidebar Widgets
			/* ------------------------------------------------------------------------ */
			register_sidebar(array(
				'name' => 'Main Sidebar',
				'id'   => 'main-sidebar',
				'description'   => esc_html__('These are widgets for the sidebar.', 'becipe'),
				'before_widget' => '<div id="%1$s" class="widget_block clear %2$s"><div>',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="wid-title"><span>',
				'after_title'   => '</span></div>'
			));
	}
}

    
?>
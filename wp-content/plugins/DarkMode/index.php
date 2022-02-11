
<?php 

/*

Plugin Name: Dark Mode

Plugin URI: https://www.linkedin.com/in/mkrealy

Description: Tema Dark Mode Özelliği

Author: Mensur Kılıç

Version: 1.0 

Author URI: https://www.linkedin.com/in/mkrealy

*/
add_action( 'enqueue_block_assets', 


function () {
   
    wp_enqueue_style( 'darkModeFontAwesome',  ''  );
    wp_enqueue_style( 'darkModeFontAwesome',  esc_url('pro.fontawesome.com/releases/v5.10.0/css/all.css', __FILE__ ) );
    wp_enqueue_style( 'darkMode',  esc_url('cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', __FILE__ ) ) ;
} );


function add_this_script_footer(){

    wp_enqueue_script( 'darkMode',  esc_url(plugins_url( '/js/darkMode.js',__FILE__ ))  );
     } 
    
    add_action('wp_footer', 'add_this_script_footer');
    
    ?>
    
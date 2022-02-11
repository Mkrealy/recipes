<?php



if( ! class_exists( 'BECIPE_Frenify_Custom_Post' ) ) {
	class BECIPE_Frenify_Custom_Post {

		function __construct() {
			// recipe
			add_action( 'init', array( $this, 'recipe_init' ) );
			add_action( 'init', array( $this, 'recipe_taxonomy_init' ) );
			add_action( 'init', array( $this, 'recipe_country_init' ) );
			add_action( 'init', array( $this, 'recipe_tag_taxonomies' ) );
			
			// changing "Featured Image" text for custom post type
		}

		
		
		/********************************************************/
		/*  Recipe post registr
		/********************************************************/
		
		function recipe_init() {
			
			global $becipe_fn_option;
			
			$recipe_slug = 'recipe';
			if(isset($becipe_fn_option['recipe_slug']) && $becipe_fn_option['recipe_slug'] != ''){
				$recipe_slug = $becipe_fn_option['recipe_slug'];
			}
			$recipe_bread_title = esc_html__( 'Recipe Posts', 'frenify-core' );
			if(isset($becipe_fn_option['recipe_bread_title']) && $becipe_fn_option['recipe_bread_title'] != ''){
				$recipe_bread_title = $becipe_fn_option['recipe_bread_title'];
			}
			
			
			
			// Labels for display service recipes
			$labels = array(
				'name'					=> esc_html__( 'Recipe Posts', 'frenify-core' ),
				'singular_name'			=> esc_html__( 'Recipe Post', 'frenify-core' ),
				'menu_name'				=> esc_html__( 'Recipe Posts', 'frenify-core' ),
				'name_admin_bar' 		=> esc_html__( 'Recipe Posts', 'frenify-core' ),
				'add_new'				=> esc_html__( 'Add New', 'frenify-core' ),
				'add_new_item'			=> esc_html__( 'Add New Recipe Post', 'frenify-core' ),
				'edit_item' 			=> esc_html__( 'Edit Recipe Post', 'frenify-core' ),
				'new_item' 				=> esc_html__( 'New Recipe Post', 'frenify-core' ),
				'view_item' 			=> esc_html__( 'View Recipe Post', 'frenify-core' ),
				'search_items' 			=> esc_html__( 'Search Recipe Posts', 'frenify-core' ),
				'not_found' 			=> esc_html__( 'No Recipe posts found', 'frenify-core' ),
				'not_found_in_trash'	=> esc_html__( 'No Recipe posts found in trash', 'frenify-core' ),
				'all_items' 			=> esc_html__( 'Recipe Posts', 'frenify-core' )
			);
		
			// Arguments for service recipes
			$args = array(
				'labels' 				=> $labels,
				'public' 				=> true,
				'publicly_queryable' 	=> true,
				'show_in_nav_menus' 	=> true,
				'show_in_admin_bar' 	=> true,
				'exclude_from_search'	=> false,
				'show_ui'				=> true,
				'show_in_menu'			=> true,
				'menu_position'			=> 4,
				'menu_icon'				=> 'dashicons-food', //XXS_PLUGIN_URI . 'assets/img/recipe-icon.png',
				'can_export'			=> true,
				'delete_with_user'		=> false,
				'hierarchical'			=> false,
				'has_archive'			=> true,
				'capability_type'		=> 'post',
				'rewrite'				=> array( 'slug' => $recipe_slug, 'with_front' => false ),
				'supports'				=> array( 'title', 'editor', 'thumbnail', 'comments' )
			);
		
			// Register our recipe post type
			register_post_type( 'becipe-recipe', $args );
		}
		

			//create two taxonomies, genres and tags for the post type "tag"
		function recipe_tag_taxonomies() {
			
			$slug = 'recipe_tag';
			// Add new taxonomy, NOT hierarchical (like tags)
			$labels = array(
				'name' 							=> __( 'Tags', 'frenify-core' ),
				'singular_name' 				=> __( 'Tag', 'frenify-core' ),
				'search_items' 					=>  __( 'Search Tags', 'frenify-core' ),
				'popular_items' 				=> __( 'Popular Tags', 'frenify-core' ),
				'all_items' 					=> __( 'All Tags', 'frenify-core' ),
				'parent_item' 					=> null,
				'parent_item_colon' 			=> null,
				'edit_item' 					=> __( 'Edit Tag', 'frenify-core' ), 
				'update_item' 					=> __( 'Update Tag', 'frenify-core' ),
				'add_new_item' 					=> __( 'Add New Tag', 'frenify-core' ),
				'new_item_name' 				=> __( 'New Tag Name', 'frenify-core' ),
				'separate_items_with_commas' 	=> __( 'Separate tags with commas', 'frenify-core' ),
				'add_or_remove_items'			=> __( 'Add or remove tags', 'frenify-core' ),
				'choose_from_most_used' 		=> __( 'Choose from the most used tags', 'frenify-core' ),
				'menu_name' 					=> __( 'Tags', 'frenify-core' ),
			); 
			$labels = array(
				'name'							=> esc_html__( 'Recipe Tags', 'frenify-core' ),
				'singular_name'					=> esc_html__( 'Recipe Tag', 'frenify-core' ),
				'menu_name'						=> esc_html__( 'Recipe Tags', 'frenify-core' ),
				'edit_item'						=> esc_html__( 'Edit Tag', 'frenify-core' ),
				'update_item'					=> esc_html__( 'Update Tag', 'frenify-core' ),
				'add_new_item'					=> esc_html__( 'Add New Tag', 'frenify-core' ),
				'new_item_name'					=> esc_html__( 'New Tag Name', 'frenify-core' ),
				'parent_item'					=> esc_html__( 'Parent Tag', 'frenify-core' ),
				'parent_item_colon'				=> esc_html__( 'Parent Tag:', 'frenify-core' ),
				'all_items'						=> esc_html__( 'All Tags', 'frenify-core' ),
				'search_items'					=> esc_html__( 'Search Tags', 'frenify-core' ),
				'popular_items'					=> esc_html__( 'Popular Tags', 'frenify-core' ),
				'separate_items_with_commas'	=> esc_html__( 'Separate Tags with commas', 'frenify-core' ),
				'add_or_remove_items'			=> esc_html__( 'Add or remove Tags', 'frenify-core' ),
				'choose_from_most_used'			=> esc_html__( 'Choose from the most used Tags', 'frenify-core' ),
				'not_found'						=> esc_html__( 'No Tags found', 'frenify-core' )
			);
			
			
			$args = array(
				'labels'			=> $labels,
				'public'			=> true,
				'show_ui' 			=> true,
				'show_in_nav_menus'	=> true,
				'show_admin_column'	=> true,
				'show_tagcloud'		=> false,
				'hierarchical'		=> false,
				'query_var'			=> true,
				'rewrite'			=> array( 'slug' => $slug, 'with_front' => false, 'hierarchical' => true )
			);
			// Register Taxanomy
			register_taxonomy( $slug, 'becipe-recipe', $args );
			
		}
		
		function recipe_taxonomy_init() {
			
			global $becipe_fn_option;
			
			$slug = 'myrecipe-cat';
			if(isset($becipe_fn_option['recipe_cat_slug']) && $becipe_fn_option['recipe_cat_slug'] != ''){
				$slug = $becipe_fn_option['recipe_cat_slug'];
			}
		
			// Label for 'recipe category' taxonomy
			$labels = array(
				'name'							=> esc_html__( 'Recipe Categories', 'frenify-core' ),
				'singular_name'					=> esc_html__( 'Recipe Category', 'frenify-core' ),
				'menu_name'						=> esc_html__( 'Recipe Categories', 'frenify-core' ),
				'edit_item'						=> esc_html__( 'Edit Category', 'frenify-core' ),
				'update_item'					=> esc_html__( 'Update Category', 'frenify-core' ),
				'add_new_item'					=> esc_html__( 'Add New Category', 'frenify-core' ),
				'new_item_name'					=> esc_html__( 'New Category Name', 'frenify-core' ),
				'parent_item'					=> esc_html__( 'Parent Category', 'frenify-core' ),
				'parent_item_colon'				=> esc_html__( 'Parent Category:', 'frenify-core' ),
				'all_items'						=> esc_html__( 'All Categories', 'frenify-core' ),
				'search_items'					=> esc_html__( 'Search Categories', 'frenify-core' ),
				'popular_items'					=> esc_html__( 'Popular Categories', 'frenify-core' ),
				'separate_items_with_commas'	=> esc_html__( 'Separate Categoriess with commas', 'frenify-core' ),
				'add_or_remove_items'			=> esc_html__( 'Add or remove Categories', 'frenify-core' ),
				'choose_from_most_used'			=> esc_html__( 'Choose from the most used Categories', 'frenify-core' ),
				'not_found'						=> esc_html__( 'No Categories found', 'frenify-core' )
			);
		
			// Arguments for 'service category' taxonomy
			$args = array(
				'labels'			=> $labels,
				'public'			=> true,
				'show_ui' 			=> true,
				'show_in_nav_menus'	=> true,
				'show_admin_column'	=> true,
				'show_tagcloud'		=> false,
				'hierarchical'		=> true,
				'query_var'			=> true,
				'rewrite'			=> array( 'slug' => $slug, 'with_front' => false, 'hierarchical' => true )
			);
			
			// Register Taxanomy
			register_taxonomy( 'recipe_category', 'becipe-recipe', $args );
			
			
		}
		
		function recipe_country_init() {
			
			global $becipe_fn_option;
			
			$slug = 'recipe-country';
		
			// Label for 'recipe category' taxonomy
			$labels = array(
				'name'							=> esc_html__( 'Recipe Countries', 'frenify-core' ),
				'singular_name'					=> esc_html__( 'Recipe Country', 'frenify-core' ),
				'menu_name'						=> esc_html__( 'Recipe Countries', 'frenify-core' ),
				'edit_item'						=> esc_html__( 'Edit Country', 'frenify-core' ),
				'update_item'					=> esc_html__( 'Update Country', 'frenify-core' ),
				'add_new_item'					=> esc_html__( 'Add New Country', 'frenify-core' ),
				'new_item_name'					=> esc_html__( 'New Country Name', 'frenify-core' ),
				'parent_item'					=> esc_html__( 'Parent Country', 'frenify-core' ),
				'parent_item_colon'				=> esc_html__( 'Parent Country:', 'frenify-core' ),
				'all_items'						=> esc_html__( 'All Countries', 'frenify-core' ),
				'search_items'					=> esc_html__( 'Search Countries', 'frenify-core' ),
				'popular_items'					=> esc_html__( 'Popular Countries', 'frenify-core' ),
				'separate_items_with_commas'	=> esc_html__( 'Separate Countries with commas', 'frenify-core' ),
				'add_or_remove_items'			=> esc_html__( 'Add or remove Countries', 'frenify-core' ),
				'choose_from_most_used'			=> esc_html__( 'Choose from the most used Countries', 'frenify-core' ),
				'not_found'						=> esc_html__( 'No Countries found', 'frenify-core' )
			);
		
			// Arguments for 'service category' taxonomy
			$args = array(
				'labels'			=> $labels,
				'public'			=> true,
				'show_ui' 			=> true,
				'show_in_nav_menus'	=> true,
				'show_admin_column'	=> true,
				'show_tagcloud'		=> false,
				'hierarchical'		=> true,
				'query_var'			=> true,
				'rewrite'			=> array( 'slug' => $slug, 'with_front' => false, 'hierarchical' => true )
			);
			
			// Register Taxanomy
			register_taxonomy( 'recipe_country', 'becipe-recipe', $args );
			
			
		}
		
		
		
		
	
		
	}

	$becipe_fn_custompost = new BECIPE_Frenify_Custom_Post();
}
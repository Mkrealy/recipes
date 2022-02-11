<?php
namespace Frel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Frel\Frel_Helper;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Frel Site Title
 */
class Frel_Posts_List_Filter extends Widget_Base {

	public function get_name() {
		return 'frel-posts-list-filter';
	}

	public function get_title() {
		return __( 'Posts List with Filter', 'frenify-core' );
	}

	public function get_icon() {
		return 'eicon-image-box frenifyicon-elementor';
	}

	public function get_categories() {
		return [ 'frel-elements' ];
	}
	
	public function get_keywords() {
        return [
            'frenify',
            'posts',
            'post',
            'becipe'
        ];
    }

	protected function _register_controls() {
		
		
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'frenify-core' ),
			]
		);
		
		$this->add_control(
			'cols',
			[
				'label' => __( 'Column Count', 'frenify-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 4,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 4,
						'step' => 1,
					]
				],
			]
		);
		
		$this->add_control(
			'post_perpage',
			[
				'label' => __( 'Post Perpage', 'frenify-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 99999,
						'step' => 1,
					]
				],
			]
		);
		
		$this->add_control(
			'post_include_categories',
			[
				 'label'	 	=> __( 'Include Categories', 'frenify-core' ),
				 'description'	=> __( 'Select a category to include or leave blank for all.', 'frenify-core' ),
				 'type' 		=> Controls_Manager::SELECT2,
				 'multiple'	 	=> true,
				 'label_block'	=> true,
				 'options' 		=> Frel_Helper::getAllCategories('recipe_category'),
			]
		);
		
		
		$this->add_control(
			'post_exclude_categories',
			[
				 'label'	 	=> __( 'Exclude Categories', 'frenify-core' ),
				 'description'	=> __( 'Select a category to exclude', 'frenify-core' ),
				 'type' 		=> Controls_Manager::SELECT2,
				 'multiple'	 	=> true,
				 'label_block'	=> true,
				 'options' 		=> Frel_Helper::getAllCategories('recipe_category'),
			]
		);
		
		$this->add_control(
			'post_included_items',
			[
				 'label'	 	=> __( 'Include Posts', 'frenify-core' ),
				 'type' 		=> Controls_Manager::SELECT2,
				 'multiple'	 	=> true,
				 'label_block'	=> true,
				 'options' 		=> Frel_Helper::getAllPosts('becipe-recipe'),
			]
		);
		
		
		$this->add_control(
			'post_excluded_items',
			[
				 'label'	 	=> __( 'Exclude Posts', 'frenify-core' ),
				 'type' 		=> Controls_Manager::SELECT2,
				 'multiple'	 	=> true,
				 'label_block'	=> true,
				 'options' 		=> Frel_Helper::getAllPosts('becipe-recipe'),
			]
		);
		
		$this->add_control(
            'post_order',
            [
                'label' => esc_html__( 'Post Order', 'frenify-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' 	=> esc_html__( 'Ascending', 'frenify-core' ),
                    'desc' 	=> esc_html__( 'Descending', 'frenify-core' )
                ],
                'default' => 'desc',
            ]
        );
		
		$this->add_control(
            'post_orderby',
            [
                'label' => esc_html__( 'Post Orderby', 'frenify-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' 					=> esc_html__( 'Select Option', 'frenify-core' ),
                    'ID' 				=> esc_html__( 'By ID', 'frenify-core' ),
                    'author' 			=> esc_html__( 'By Author', 'frenify-core' ),
                    'title' 			=> esc_html__( 'By Title', 'frenify-core' ),
                    'name' 				=> esc_html__( 'By Name', 'frenify-core' ),
                    'rand' 				=> esc_html__( 'Random', 'frenify-core' ),
                    'comment_count' 	=> esc_html__( 'By Number of Comments', 'frenify-core' ),
                    'menu_order' 		=> esc_html__( 'By Page Order', 'frenify-core' ),
                ],
                'default' => '',
            ]
        );
		
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'label_section',
			[
				'label' => __( 'Labels', 'frenify-core' ),
			]
		);
		$this->add_control(
			'filter_text',
			[
				'label' 		=> __( 'Filter Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'Filter', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		
		$this->add_control(
			'all_text',
			[
				'label' 		=> __( 'Categories Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'All Categories', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		$this->add_control(
			'country_text',
			[
				'label' 		=> __( 'Country Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'Country', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		$this->add_control(
			'diff_text',
			[
				'label' 		=> __( 'Difficulty Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'Difficulty', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		$this->add_control(
			'type_text',
			[
				'label' 		=> __( 'Type Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'Type Something...', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		
		$this->add_control(
			'read_more',
			[
				'label' 		=> __( 'Read More Label', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __( 'Read More', 'frenify-core' ),
				'label_block'	=> true
			]
		);
		
		$this->end_controls_section();
		
		
	}


	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		global $becipe_fn_option;
		$seo_recipe_search_title 	= 'h3';
		if(isset($becipe_fn_option['seo_recipe_search_title'])){
			$seo_recipe_search_title = $becipe_fn_option['seo_recipe_search_title'];
		}
		
		$settings = $this->get_settings();
		
		/***********************************************************************************/
		/* QUERY */
		/***********************************************************************************/
		$postIncludedItems			= array();
		if(!empty($settings['post_included_items'])){
			$postIncludedItems		= $settings['post_included_items'];
		}
		$postExcludedItems			= array();
		if(!empty($settings['post_excluded_items'])){
			$postExcludedItems		= $settings['post_excluded_items'];
		}
		$include_categories 		= array();
		if(!empty($settings['post_include_categories'])){
			$include_categories 	= $settings['post_include_categories'];
		}
		$exclude_categories 		= array();
		if(!empty($settings['post_exclude_categories'])){
			$exclude_categories	 	= $settings['post_exclude_categories'];
		}
		$post_perpage 	= $settings['post_perpage']['size'];
		$post_order 	= $settings['post_order'];
		$post_orderby 	= $settings['post_orderby'];
		$paged 			= 1;
		
		$read_more 		= esc_html($settings['read_more']);
		
		
		$hiddenFilter = '';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_read_more" value="'.$read_more.'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_post_order" value="'.$post_order.'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_post_orderby" value="'.$post_orderby.'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_post_include" value="'.implode(",", $postIncludedItems).'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_post_exclude" value="'.implode(",", $postExcludedItems).'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_cat_include" value="'.implode(",", $include_categories).'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_cat_exclude" value="'.implode(",", $exclude_categories).'" />';
		$hiddenFilter .= '<input type="hidden" class="hidden_info fn_hidden_perpage" value="'.$post_perpage.'" />';
		
		
		$query_args = array(
			'post_type' 			=> 'becipe-recipe',
			'paged' 				=> $paged,
			'posts_per_page' 		=> $post_perpage,
			'post_status' 			=> 'publish',
			'order' 				=> $post_order,
			'orderby' 				=> $post_orderby,
			'post__in' 				=> $postIncludedItems,
			'post__not_in'	 		=> $postExcludedItems,
		);
		$query_args2 = array(
			'post_type' 			=> 'becipe-recipe',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
			'order' 				=> $post_order,
			'orderby' 				=> $post_orderby,
			'post__in' 				=> $postIncludedItems,
			'post__not_in'	 		=> $postExcludedItems,
		);

		if ( ! empty ( $exclude_categories ) ) {

			// Exclude the correct cats from tax_query
			$query_args['tax_query'] = array(
				array(
					'taxonomy'	=> 'recipe_category', 
					'field'	 	=> 'slug',
					'terms'		=> $exclude_categories,
					'operator'	=> 'NOT IN'
				)
			);

			// Exclude the correct cats from tax_query
			$query_args2['tax_query'] = array(
				array(
					'taxonomy'	=> 'recipe_category', 
					'field'	 	=> 'slug',
					'terms'		=> $exclude_categories,
					'operator'	=> 'NOT IN'
				)
			);

			// Include the correct cats in tax_query
			if ( ! empty ( $include_categories ) ) {
				$query_args['tax_query']['relation'] = 'AND';
				$query_args['tax_query'][] = array(
					'taxonomy'	=> 'recipe_category',
					'field'		=> 'slug',
					'terms'		=> $include_categories,
					'operator'	=> 'IN'
				);
			}	

			// Include the correct cats in tax_query
			if ( ! empty ( $include_categories ) ) {
				$query_args2['tax_query']['relation'] = 'AND';
				$query_args2['tax_query'][] = array(
					'taxonomy'	=> 'recipe_category',
					'field'		=> 'slug',
					'terms'		=> $include_categories,
					'operator'	=> 'IN'
				);
			}		

		} else {
			// Include the cats from $cat_slugs in tax_query
			if ( ! empty ( $include_categories ) ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' 	=> 'recipe_category',
						'field' 	=> 'slug',
						'terms' 	=> $include_categories,
						'operator'	=> 'IN'
					)
				);
			}
			if ( ! empty ( $include_categories ) ) {
				$query_args2['tax_query'] = array(
					array(
						'taxonomy' 	=> 'recipe_category',
						'field' 	=> 'slug',
						'terms' 	=> $include_categories,
						'operator'	=> 'IN'
					)
				);
			}
		}

		$loop 			= new \WP_Query($query_args);
		$loop2 			= new \WP_Query($query_args2);

		$allCount 		= count($loop2->posts);
		
		$pagination		= becipe_fn_filter_pagination($allCount,$post_perpage,$paged);
		
		
		/***********************************************************************************/
		/* RENDER STARTS */
		$html		 	= Frel_Helper::frel_open_wrap();
		
		
		/***********************************************************************************/
		/* MODERN ROWS */
		/***********************************************************************************/
		
		$queryItems 	= "";
		$count = 22;
		$callBackImage 	= becipe_fn_callback_thumbs('square');
			
		foreach ( $loop->posts as $key => $fnPost ) {
			setup_postdata( $fnPost );
			$postID 			= $fnPost->ID;
			$postPermalink 		= get_permalink($postID);
			$postImage 			= get_the_post_thumbnail_url( $postID, 'full' );
			$postTitle			= $fnPost->post_title;
			$category			= Frel_Helper::post_term_list($postID, 'recipe_category', false, 1);
			
			$authorMeta			= becipe_fn_get_author_meta($postID);
			$extraMeta			= becipe_fn_get_extra_met_by_post_id($postID);
			
			
			$readMore			= Frel_Helper::frel_read_more($read_more, $postPermalink);
			
			$image				= $callBackImage.'<div class="abs_img" data-fn-bg-img="'.$postImage.'"></div>';
			$queryItems .= '<li><div class="item">';
				$queryItems .= '<div class="image_holder"><div class="img_in"><div class="img_wrap"><a href="'.$postPermalink.'">'.$image.'</a></div><span>'.$category.'</span></div></div>';
				$queryItems .= '<div class="title_holder"><'.$seo_recipe_search_title.' class="fn__title"><a href="'.$postPermalink.'">'.$postTitle.'</a></'.$seo_recipe_search_title.'></div>';
				$queryItems .= $authorMeta;
				$queryItems .= $readMore;
				$queryItems .= $extraMeta;
			$queryItems .= '</div></li>';

			wp_reset_postdata();
		}
		
		
		
		$preloader = '<div class="my_loader"></div>';
		
		$filterText 		= $settings['filter_text'];
		$allCategoriesText 	= $settings['all_text'];
		$typeText 			= $settings['type_text'];
		$difficultyText		= $settings['diff_text'];
		$countryText		= $settings['country_text'];
		$escText 			= array($filterText,$allCategoriesText,$typeText,$difficultyText,$countryText);
		
		
		$filter_section = Frel_Helper::getAllFilter($escText,$loop2);

		
		
		$list = '<ul>'.$queryItems.'</ul>';
		// Right PART ------
		$list_section	= '<div class="post_section">';
			$list_section .= '<div class="post_section_in">';
				$list_section .= '<div class="my_list">';
					$list_section .= $list;
				$list_section .= '</div>';
				$list_section .= $pagination;
			$list_section .= '</div>';
		$list_section .= '</div>';
		// -----------------
		
		
		$html .= '<div class="fn_cs_posts_filter" data-cols="'.$settings['cols']['size'].'">'.$hiddenFilter;
		
				$html .= '<div class="inner">';
					$html .= $filter_section;
					$html .= $list_section;
				$html .= '</div>';
				
		
		$html .= '</div>';
		
		
		
		
		/***********************************************************************************/
		/* RENDER ENDS */
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

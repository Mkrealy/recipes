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
class Frel_Featured_Recipes extends Widget_Base {

	public function get_name() {
		return 'frel-featured-recipes';
	}

	public function get_title() {
		return __( 'Featured Recipes', 'frenify-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid frenifyicon-elementor';
	}

	public function get_categories() {
		return [ 'frel-elements' ];
	}
	
	public function get_keywords() {
        return [
            'frenify',
            'becipe'
        ];
    }

	protected function _register_controls() {
		
		
		$this->start_controls_section(
			'section1',
			[
				'label' => __( 'Content', 'frenify-core' ),
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
			'featured_text',
			  [
				'label'       	=> __( 'Featured Text', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'default' 	   	=> __( 'Featured Recipes', 'frenify-core' ),
				'label_block'	=> true
			  ]
		);
		
		$this->add_control(
			'see_all_text',
			  [
				'label'       	=> __( 'See All Text', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'default' 	   	=> __( 'See all featured recipes', 'frenify-core' ),
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

		$this->start_controls_section(
			'section2',
			[
				'label' => __( 'Style', 'frenify-core' ),
			]
		);
		
		$this->add_control(
			'category_options',
			[
				'label' => __( 'Category', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'c_bg_color',
			[
				'label' => __( 'Regular Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .category_name a' => 'background-color: {{VALUE}};',
				],
				'default' => '#f0ca6e',
			]
		);
		
		$this->add_control(
			'c_text_color',
			[
				'label' => __( 'Regular Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .category_name a' => 'color: {{VALUE}};',
				],
				'default' => '#582300',
			]
		);
		
		$this->add_control(
			'c_bg_h_color',
			[
				'label' => __( 'Hover Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .category_name a:hover' => 'background-color: {{VALUE}};',
				],
				'default' => '#c00a27',
			]
		);
		
		$this->add_control(
			'c_text_h_color',
			[
				'label' => __( 'Hover Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .category_name a:hover' => 'color: {{VALUE}};',
				],
				'default' => '#fff',
			]
		);
		
		
		$this->add_control(
			'title_options',
			[
				'label' => __( 'Title', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 't_typo',
				'label' 		=> __( 'Typography', 'frenify-core' ),
				'scheme' 		=> Scheme_Typography::TYPOGRAPHY_1,
				'selector' 		=> '{{WRAPPER}} .item h3',
				'fields_options' => [
					'font_weight' => [
						'default' => '500',
					],
					'font_family' => [
						'default' => 'Heebo',
					],
					'font_size'   => [
						'default' => [
										'unit' => 'px',
										'size' => '48'
									]
					],
					'line_height' => [
						'default' => [
										'unit' => 'px',
										'size' => '50',
									]
					],
					'letter_spacing' => [
						'default' => [
										'unit' => 'px',
										'size' => '0',
									]
					],
				],
			]
		);
		
		$this->add_control(
			't_text_color',
			[
				'label' => __( 'Regular Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn__title a' => 'color: {{VALUE}};',
				],
				'default' => '#1e1e1e',
			]
		);
		
		$this->add_control(
			't_tex_h_color',
			[
				'label' => __( 'Hover Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn__title a:hover' => 'color: {{VALUE}};',
				],
				'default' => '#c00a27',
			]
		);
		
		
		$this->end_controls_section();

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;
		
		global $becipe_fn_option;
		$seo_recipe_search_title 		= 'h3';
		if(isset($becipe_fn_option['seo_recipe_search_title'])){
			$seo_recipe_search_title 	= $becipe_fn_option['seo_recipe_search_title'];
		}
		
		$settings 		= $this->get_settings();
		
		
		$read_more 		= $settings['read_more'];
		$see_all_text 	= $settings['see_all_text'];
		$featured_text 	= $settings['featured_text'];
		$post_order 	= $settings['post_order'];
		$post_orderby 	= $settings['post_orderby'];
		$query_args = array(
			'post_type' 			=> 'becipe-recipe',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
			'order' 				=> $post_order,
			'orderby' 				=> $post_orderby,
		);
		
		$query_args['meta_query'][] = array(
			'key'       => 'becipe_fn_page_special_featured',
			'value'     => true,
			'compare'   => '==',
		);
		
		
		$loop = new \WP_Query($query_args);
		
		$html = Frel_Helper::frel_open_wrap();
		$html .= '<div class="fn_cs_featured_posts_slider">';
		$swiper = '<div class="swiper-wrapper">';
		
		
		$icon = '<span class="fn_icon">'.becipe_fn_getSVG_core('flash').'</span>';
		if($featured_text != ''){
			$featured_text	= '<h3>'.$featured_text.'</h3>';
		}
		
		$see = '<p>'.$see_all_text.'</p>';
		
		
		$progress = '<div class="fn_cs_swiper__progress">
						<div class="my_pagination_in">
							<span class="current"></span>
							<span class="pagination_progress"><span class="all"><span></span></span></span>
							<span class="total"></span>
						</div>
					</div>';
		
		$topLeft	= '<div class="top_left">'.$icon.$featured_text.$see.'</div>';
		$topRight	= '<div class="top_right">'.$progress.'</div>';
		
		$topPart	= '<div class="top_part">'.$topLeft.$topRight.'</div>';
		
		
		foreach ( $loop->posts as $key => $fn_post ) {
			setup_postdata( $fn_post );
			$postID 			= $fn_post->ID;
			$post_permalink 	= get_permalink($postID);
			$post_title			= $fn_post->post_title;
			$post_img			= get_the_post_thumbnail_url($postID, 'full');
			$title 				= '<div class="slide_title"><'.$seo_recipe_search_title.' class="fn__title"><a href="'.$post_permalink.'">'.$post_title.'</a></'.$seo_recipe_search_title.'></div>';
			$authorMeta			= becipe_fn_get_author_meta($postID);
			$extraMeta			= becipe_fn_get_extra_met_by_post_id($postID);
			$category			= becipe_fn_get_category($postID, 1, 'becipe-recipe');
			
			$left_top			= '<div class="left_top">'.$category.$extraMeta.'</div>';
			
			$read_meta			= Frel_Helper::frel_read_more($read_more, $post_permalink);
			
			$left_holder		= '<div class="left_holder">'.$left_top.$title.$authorMeta.$read_meta.'</div>';
			$img_holder 		= '<div class="img_holder"><a href="'.$post_permalink.'"><div class="abs_img" data-fn-bg-img="'.$post_img.'"></a></div></div>';
			
			$item 				= '<div class="item">'.$img_holder.$left_holder.'</div>';

			
			$swiper .= '<div class="swiper-slide">'.$item.'</div>';

			wp_reset_postdata();
		}
		$swiper .= '</div>';
		
		
		$swiperContainer = '<div class="bottom_part"><div class="swiper-container">'.$swiper.'</div></div>';
		
		$html .= $topPart;
		$html .= $swiperContainer;
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

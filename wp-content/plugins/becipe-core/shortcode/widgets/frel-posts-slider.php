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
class Frel_Posts_Slider extends Widget_Base {

	public function get_name() {
		return 'frel-posts-slider';
	}

	public function get_title() {
		return __( 'Posts Slider', 'frenify-core' );
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
            'post_offset',
            [
                'label' => esc_html__( 'Post Offset', 'frenify-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0'
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
		
		$this->add_control(
			'read_more',
			  [
				'label'       	=> __( 'Read More Text', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'Type read more text here', 'frenify-core' ),
				'default' 	   	=> __( 'Read More', 'frenify-core' ),
				'label_block'	=> true
			  ]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section2',
			[
				'label' => __( 'Coloring', 'frenify-core' ),
			]
		);
		
		$this->add_control(
			'bg_options',
			[
				'label' => __( 'Background', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Overlay Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .img_holder:after' => 'background-color: {{VALUE}};',
				],
				'default' => 'rgba(0,0,0,.5)',
			]
		);
		
		$this->add_control(
			'author_options',
			[
				'label' => __( 'Author Meta', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'author_text_color',
			[
				'label' => __( 'Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .fn_author_meta  p' => 'color: {{VALUE}};',
				],
				'default' => '#ccc',
			]
		);
		
		$this->add_control(
			'author_link_color',
			[
				'label' => __( 'Link Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .fn_author_meta  p a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .fn_cs_posts_slider .fn_author_meta  p a:before' => 'background-color: {{VALUE}};',
				],
				'default' => '#ccc',
			]
		);
		
		$this->add_control(
			'date_options',
			[
				'label' => __( 'Date Meta', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'date_reg_text_color',
			[
				'label' => __( 'Regular Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a' => 'color: {{VALUE}};',
				],
				'default' => '#ccc',
			]
		);
		
		$this->add_control(
			'date_reg_border_color',
			[
				'label' => __( 'Regular Border Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a' => 'border-color: {{VALUE}};',
				],
				'default' => '#b3b3b4',
			]
		);
		
		$this->add_control(
			'date_reg_bg_color',
			[
				'label' => __( 'Regular Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a' => 'background-color: {{VALUE}};',
				],
				'default' => 'rgba(0,0,0,0)',
			]
		);
		
		$this->add_control(
			'date_hover_text_color',
			[
				'label' => __( 'Hover Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a:hover' => 'color: {{VALUE}};',
				],
				'default' => '#000',
			]
		);
		
		$this->add_control(
			'date_hover_border_color',
			[
				'label' => __( 'Hover Border Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a:hover' => 'border-color: {{VALUE}};',
				],
				'default' => '#f3b469',
			]
		);
		
		$this->add_control(
			'date_hover_bg_color',
			[
				'label' => __( 'Hover Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_author_meta  .date_meta a:hover' => 'background-color: {{VALUE}};',
				],
				'default' => '#f3b469',
			]
		);
		
		$this->add_control(
			'title_desc_options',
			[
				'label' => __( 'Title & Description', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .title_holder h3 a' => 'color: {{VALUE}};',
				],
				'default' => '#fff',
			]
		);
		
		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Title Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .slide_desc p' => 'color: {{VALUE}};',
				],
				'default' => '#ccc',
			]
		);
		
		$this->add_control(
			'read_more_options',
			[
				'label' => __( 'Read More', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'rm_text_color',
			[
				'label' => __( 'Regular Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .read_more a' => 'color: {{VALUE}};',
				],
				'default' => '#000',
			]
		);
		
		
		$this->add_control(
			'rm_bg_color',
			[
				'label' => __( 'Regular Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .read_more a' => 'background-color: {{VALUE}};',
				],
				'default' => '#f3b469',
			]
		);
		
		$this->add_control(
			'rm_h_text_color',
			[
				'label' => __( 'Regular Hover Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .read_more a:hover' => 'color: {{VALUE}};',
				],
				'default' => '#f3b469',
			]
		);
		
		
		$this->add_control(
			'rm_h_bg_color',
			[
				'label' => __( 'Regular Background Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_posts_slider .read_more a:hover' => 'background-color: {{VALUE}};',
				],
				'default' => '#000',
			]
		);
		
		$this->add_control(
			'progress_options',
			[
				'label' => __( 'Numbered Navigation', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'prog_inactive_color',
			[
				'label' => __( 'Inactive Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_swiper_number_progress .progress_wrap .fn_count' => 'color: {{VALUE}};',
					'{{WRAPPER}} .fn_cs_swiper_number_progress .progress_wrap .fn_progress' => 'background-color: {{VALUE}};',
				],
				'default' => '#343536',
			]
		);
		
		$this->add_control(
			'prog_active_color',
			[
				'label' => __( 'Active Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_swiper_number_progress .progress_wrap.active .fn_count' => 'color: {{VALUE}};',
					'{{WRAPPER}} .fn_cs_swiper_number_progress .progress_wrap .fn_progress:after' => 'background-color: {{VALUE}};',
				],
				'default' => '#ccc',
			]
		);
		
		$this->end_controls_section();

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		
		
		$read_text 		= $settings['read_more'];
		$post_offset 	= $settings['post_offset'];
		$post_order 	= $settings['post_order'];
		$post_orderby 	= $settings['post_orderby'];
		$query_args = array(
			'post_type' 			=> 'post',
			'posts_per_page' 		=> 3,
			'post_status' 			=> 'publish',
			'offset' 				=> $post_offset,
			'order' 				=> $post_order,
			'orderby' 				=> $post_orderby,
		);
		
		
		$loop = new \WP_Query($query_args);
		
		$html = Frel_Helper::frel_open_wrap();
		$html .= '<div class="fn_cs_posts_slider">';
		$swiper = '<div class="swiper-wrapper">';
		
		$progress = '';
		foreach ( $loop->posts as $key => $fn_post ) {
			setup_postdata( $fn_post );
			$post_id 			= $fn_post->ID;
			$post_permalink 	= get_permalink($post_id);
			$post_title			= $fn_post->post_title;
			$post_img			= get_the_post_thumbnail_url($post_id, 'full');
			$title 				= '<div class="slide_title"><h3><a href="'.$post_permalink.'">'.$post_title.'</a></h3></div>';
			$desc 				= '<div class="slide_desc"><p>'.becipe_fn_excerpt(30, $post_id).'</p></div>';
			$read 				= '<div class="read_more"><a href="'.$post_permalink.'">'.$read_text.'</a></div>';
			$authorMeta			= becipe_fn_get_author_meta_by_post_id($post_id, 'post', true);
			
			$img_holder 		= '<div class="img_holder" data-fn-bg-img="'.$post_img.'"></div>';
			$item 				= '<div class="item">'.$img_holder.'<div class="fn-container"><div class="title_holder">'.$authorMeta.$title.$desc.$read.'</div></div></div>';

			
			
			$key++;
			$swiper .= '<div class="swiper-slide" data-hash="fn_slide'.$key.'">'.$item.'</div>';
			$myKey = $key;
			if($key < 10){$myKey = '0'.$key;}
			$progress .= '<a class="progress_wrap" href="#fn_slide'.$key.'"><span class="fn_count">'.$myKey.'</span><span class="fn_progress"></span></a>';

			wp_reset_postdata();
		}
		$swiper .= '</div>';
		
		
		$progress = '<div class="fn_cs_swiper_number_progress"><div class="fn-container"><div class="progress_inner">'.$progress.'</div></div></div>';
		
		$swiperContainer = '<div class="swiper-container">'.$swiper.$progress.'</div>';
		
		$html .= $swiperContainer;
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

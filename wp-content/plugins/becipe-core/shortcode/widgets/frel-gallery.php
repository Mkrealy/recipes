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
class Frel_Gallery extends Widget_Base {

	public function get_name() {
		return 'frel-gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'frenify-core' );
	}

	public function get_icon() {
		return 'eicon-checkbox frenifyicon-elementor';
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
			'layout',
			[
				'label' 	=> __( 'Layout', 'frenify-core' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'collage',
				'options' 	=> [
					'collage'		=> __( 'Collage', 'frenify-core' ),
					'justified'  	=> __( 'Justified', 'frenify-core' ),
					'masonry'  		=> __( 'Masonry', 'frenify-core' ),
					'slider'  		=> __( 'Slider', 'frenify-core' ),
					'grid'  		=> __( 'Grid', 'frenify-core' ),
				],
			]
		);
		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		
		$this->add_control(
			'collage_gutter',
			[
				'label' 		=> __( 'Gutter', 'frenify-core' ),
				'description' 	=> __( 'In px. Default value: 20px', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_gallery_collage ul li' => 'padding-left: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_collage ul' => 'margin-left: -{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'collage',
				]
			]
		);
		$this->add_control(
			'justified_gutter',
			[
				'label' 		=> __( 'Gutter', 'frenify-core' ),
				'description' 	=> __( 'In px. Default value: 10px', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition' => [
					'layout' => 'justified',
				]
			]
		);
		$this->add_control(
			'justified_height',
			[
				'label' 		=> __( 'Height', 'frenify-core' ),
				'description' 	=> __( 'In px. Default value: 400px', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'condition' => [
					'layout' => 'justified',
				]
			]
		);
		$this->add_control(
			'masonry_gutter',
			[
				'label' 		=> __( 'Gutter', 'frenify-core' ),
				'description' 	=> __( 'In px. Default value: 20px', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_gallery_masonry ul li' => 'padding-left: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_masonry ul' => 'margin-left: -{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'masonry',
				]
			]
		);
		$this->add_control(
			'masonry_cols',
			[
				'label' 	=> __( 'Columns', 'frenify-core' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '4',
				'options' 	=> [
					'1'			=> __( '1 Column', 'frenify-core' ),
					'2'  		=> __( '2 Columns', 'frenify-core' ),
					'3'  		=> __( '3 Columns', 'frenify-core' ),
					'4'  		=> __( '4 Columns', 'frenify-core' ),
				],
				'condition' => [
					'layout' => 'masonry',
				]
			]
		);
		$this->add_responsive_control(
			'grid_ratio',
			[
				'label' => __( 'Image Ratio', 'frenify-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'tablet_default' => [
					'size' => '',
				],
				'mobile_default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'condition' => [
					'layout' => 'grid',
				]
			]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'frenify-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_gallery_collage ul li .item' => 'border-radius: {{SIZE}}{{UNIT}};overflow:hidden;',
					'{{WRAPPER}} .justified-gallery>a' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_masonry ul li .item' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_slider .item' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_grid ul li .item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'grid_gutter',
			[
				'label' 		=> __( 'Gutter', 'frenify-core' ),
				'description' 	=> __( 'In px. Default value: 0px', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_cs_gallery_grid ul li' => 'padding-left: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fn_cs_gallery_grid ul' => 'margin-left: -{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'grid',
				]
			]
		);
		$this->add_control(
			'grid_cols',
			[
				'label' 	=> __( 'Columns', 'frenify-core' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '4',
				'options' 	=> [
					'1'			=> __( '1 Column', 'frenify-core' ),
					'2'  		=> __( '2 Columns', 'frenify-core' ),
					'3'  		=> __( '3 Columns', 'frenify-core' ),
					'4'  		=> __( '4 Columns', 'frenify-core' ),
				],
				'condition' => [
					'layout' => 'grid',
				]
			]
		);
		$this->add_control(
			'lightbox',
			[
				'label' 	=> __( 'Lightbox', 'frenify-core' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'disabled',
				'options' 	=> [
					'enabled'	=> __( 'Enabled', 'frenify-core' ),
					'disabled'	=> __( 'Disabled', 'frenify-core' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		
		

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		$layout			= $settings['layout'];
		
		// ***************************************
		$lightbox		= $settings['lightbox'];
		$l__parent 		= $l__child = '';
		if($lightbox == 'enabled'){
			$l__parent 	= 'fn_cs_lightgallery';
			$l__child 	= 'lightbox';
		}
		// ***************************************
		
		$fnC_Start 	= $fnC_End = '';
		
		$html		 	 = Frel_Helper::frel_open_wrap();
		
		if($layout == 'collage'){
			
			$html			.= '<div class="fn_cs_gallery_collage '.$l__parent.'">'.$fnC_Start.'<div class="inner"><ul>';
			$firstReplacer	 = '<img src="'.BECIPE_CORE_SHORTCODE_URL.'assets/img/thumb-7-3.jpg" alt="" />';
			$secondReplacer	 = '<img src="'.BECIPE_CORE_SHORTCODE_URL.'assets/img/thumb-69-44.jpg" alt="" />';
			foreach ( $settings['gallery'] as $key => $image ) {
				if($key%3 == 0){
					$replacer 	= $firstReplacer;
				}
				$html .= '<li><div class="item">'.$replacer.'<div class="abs_img '.$l__child.'" data-src="'.$image['url'].'" data-fn-bg-img="'.$image['url'].'"></div></div></li>';
				$replacer 		= $secondReplacer;
			}

			$html 			.= '</ul></div>'.$fnC_End.'</div>';
			
		}else if($layout == 'justified'){
			
			$height			 = $settings['justified_height']['size'];
			$gutter			 = $settings['justified_gutter']['size'];
			
			$html			.= '<div class="fn_cs_gallery_masonry">'.$fnC_Start.'<div class="inner"><div class="fn_cs_gallery_justified '.$l__parent.'" data-gutter="'.$gutter.'" data-height="'.$height.'">';
			
			foreach ( $settings['gallery'] as $key => $image ) {
				$fullURL	= $image['url'];
				$imageID	= $image['id'];
				$img		= wp_get_attachment_image_src( $imageID, 'becipe_fn_thumb-1400-0');
				$imgURL		= $img[0];

				$html 		.=	'<a class="'.$l__child.'" href="" data-src="'.esc_url($fullURL).'">
									<img src="'.esc_url($imgURL).'" alt="" />
								</a>';
			}
			
			$html 			.= '</div></div>'.$fnC_End.'</div>';
			
		}else if($layout == 'masonry'){
			
			$cols			= $settings['masonry_cols'];
			$html			.= '<div class="fn_cs_gallery_masonry" data-cols="'.$cols.'">'.$fnC_Start.'<div class="inner"><ul class="fn_cs_masonry '.$l__parent.'">';
			foreach ( $settings['gallery'] as $key => $image ) {
				$fullURL	= $image['url'];
				$imageID	= $image['id'];
				$img		= wp_get_attachment_image_src( $imageID, 'becipe_fn_thumb-1400-0');
				$imgURL		= $img[0];
				$imgHTML	= '<img src="'.$imgURL.'" alt="" />';
				$html 		.= '<li class="fn_cs_masonry_in"><div class="item '.$l__child.'" data-src="'.$fullURL.'">'.$imgHTML.'</div></li>';
			}

			$html 			.= '</ul></div>'.$fnC_End.'</div>';
			
		}else if($layout == 'slider'){
			$pagination		= '<div class="fn_cs_swiper_progress fill">
								<div class="my_pagination_in">
									<span class="current"></span>
									<span class="pagination_progress"><span class="all"><span></span></span></span>
									<span class="total"></span>
								</div>
							</div>';

			$prevNextBtn	=	'<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';

			$html			.= '<div class="fn_cs_gallery_slider">'.$fnC_Start.'<div class="inner '.$l__parent.'">';

				$html			.= '<div class="swiper-container">';
					$html			.= '<div class="swiper-wrapper">';
						foreach ( $settings['gallery'] as $image ) {
							$html .= '<div class="swiper-slide"><div class="item"><div class="abs_img '.$l__child.'" data-fn-bg-img="'.$image['url'].'" data-src="'.$image['url'].'"></div></div></div>';
						}
					$html 			.= '</div>';
					$html 			.= $pagination;
					$html 			.= $prevNextBtn;
				$html			.= '</div>';

			$html 			.= $fnC_End.'</div></div>';
		}else if($layout == 'grid'){
			$ratio			= $settings['grid_ratio']['size'];
			$ratio			= $ratio - 1;
			$size 			= 'margin-bottom:calc('.$ratio.' * 100%)';
			
			$thumb		   	= '<img style="'.$size.'" src="'.becipe_CORE_SHORTCODE_URL.'assets/img/thumb-square.jpg" alt="" />';
			$cols			= $settings['grid_cols'];
			$html			.= '<div class="fn_cs_gallery_grid" data-cols="'.$cols.'">'.$fnC_Start.'<div class="inner"><ul class="'.$l__parent.'">';
			foreach ( $settings['gallery'] as $key => $image ) {
				$fullURL	= $image['url'];
				$imageID	= attachment_url_to_postid( $fullURL );
				$img		= wp_get_attachment_image_src( $imageID, 'full');
				$imgURL		= $img[0];
				$imgHTML	= '<img src="'.$imgURL.'" alt="" />';
				$html 		.= '<li><div class="item '.$l__child.'" data-src="'.$fullURL.'"><div class="abs_img" data-fn-bg-img="'.$imgURL.'"></div>'.$thumb.'</div></li>';
			}

			$html 			.= '</ul></div>'.$fnC_End.'</div>';
			
		}
		
			
		$html 			.= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

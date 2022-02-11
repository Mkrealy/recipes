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
class Frel_Audio extends Widget_Base {

	public function get_name() {
		return 'frel-audio';
	}

	public function get_title() {
		return __( 'Audio', 'frenify-core' );
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
			'layout',
			[
				'label' 	=> __( 'Layout', 'frenify-core' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'alpha',
				'options' 	=> [
					'alpha'  	=> __( 'Alpha', 'frenify-core' ),
					'beta'  	=> __( 'Beta', 'frenify-core' ),
				],
			]
		);
		
		$this->add_control(
			'subtitle',
			  [
				'label'       	=> __( 'Subtitle', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'Type subtitle here', 'frenify-core' ),
				'default' 	   	=> __( 'Have you heard?', 'frenify-core' ),
				'label_block'	=> true
			  ]
		);
		
		$this->add_control(
			'title',
			  [
				'label'       	=> __( 'Title', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'Type title here', 'frenify-core' ),
				'default' 	   	=> __( 'Becipe podcast is here', 'frenify-core' ),
				'label_block'	=> true
			  ]
		);
		
		$this->add_control(
			'desc',
			  [
				'label'       	=> __( 'Description', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'Type description here', 'frenify-core' ),
				'default' 	   	=> __( 'Get started on latest episodes', 'frenify-core' ),
				'label_block'	=> true,
				'condition' => [
					'layout' 	=> 'alpha',
				]
			  ]
		);
		
		$this->add_control(
			'audio_text',
			  [
				'label'       	=> __( 'Audio Text', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'default' 	   	=> __( 'Listen in', 'frenify-core' ),
				'label_block'	=> true
			  ]
		);
		
		$this->add_control(
			'audio_url',
			  [
				'label'       	=> __( 'Recipe Page URL', 'frenify-core' ),
				'type'        	=> Controls_Manager::TEXT,
				'default' 	   	=> '#',
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
		
		
		
		$this->end_controls_section();

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		$subtitle		= $settings['subtitle'];
		$title			= $settings['title'];
		$desc			= $settings['desc'];
		$audio_text		= $settings['audio_text'];
		$audio_url		= $settings['audio_url'];
		$layout			= $settings['layout'];
		
		$iconSVG	= '<span class="icon_wrapper">'.becipe_fn_getSVG_theme('podcast').'</span>';
		$iconHolder	= '<span class="podcast_icon"><span class="icon_inner">'.$iconSVG.'</span></span>';
		
		
		if($subtitle != ''){$subtitle = '<h5>'.$subtitle.'</h5>';}
		if($title != ''){$title = '<h3>'.$title.'</h3>';}
		if($desc != ''){$desc = '<h4>'.$desc.'</h4>';}
		
		$content = '';
		
		if($layout == 'alpha'){
			$rightLines		= '<span class="fn_lines"></span>';
			$listenIn		= '<a href="'.$audio_url.'"><span class="btn_text">'.$audio_text.'</span><span class="btn_icon"></span></a>';
			$titleHolder 	= '<div class="title_holder">'.$subtitle.$title.$desc.'</div>';
			$left			= '<div class="fn_left">'.$iconHolder.$titleHolder.'</div>';
			$right			= '<div class="fn_right"><div class="fn_right_in">'.$listenIn.$rightLines.'</div></div>';
			$content 		= '<div class="fn_cs_audio_in">'.$left.$right.'</div>';
		}else if($layout == 'beta'){
			$listenIn		= '<p><a href="'.$audio_url.'"><span class="btn_text">'.$audio_text.'</span><span class="btn_icon"></span></a></p>';
			$titleHolder 	= '<div class="title_holder">'.$subtitle.$title.$listenIn.'</div>';
			$content 		= '<div class="fn_cs_audio_in">'.$iconHolder.$titleHolder.'</div>';
		}
		
		
		$html = Frel_Helper::frel_open_wrap();
		$html .= '<div class="fn_cs_audio fn_cs_audio_'.$layout.'">';
			$html .= '<div class="fn-container">';
				$html .= $content;
			$html .= '</div>';
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

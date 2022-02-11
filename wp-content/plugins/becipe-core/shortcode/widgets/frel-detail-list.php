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
class Frel_Detail_List extends Widget_Base {

	public function get_name() {
		return 'frel-detail-list';
	}

	public function get_title() {
		return __( 'Detail list', 'frenify-core' );
	}

	public function get_icon() {
		return 'eicon-checkbox frenifyicon-elementor'; // frenifyicon-deprecated
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
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_title',
			[
				'label'       => __( 'List Title', 'frenify-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Type list title here', 'frenify-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_desc',
			[
				'label'       => __( 'List Description', 'frenify-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type list description here', 'frenify-core' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'check_list',
			[
				'label' => __( 'List', 'frenify-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' 	=> __( 'Phone', 'frenify-core' ),
						'list_desc' 	=> __( '<a href="tel:+770221770505">+77 022 177 05 05</a>', 'frenify-core' ),
					],
					[
						'list_title' 	=> __( 'Email', 'frenify-core' ),
						'list_desc' 	=> __( '<a href="mailto:frenifyteam@gmail.com">frenifyteam@gmail.com</a>', 'frenify-core' ),
					],
					[
						'list_title' 	=> __( 'Office', 'frenify-core' ),
						'list_desc' 	=> __( 'Carbon Street 11, London, UK', 'frenify-core' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Options', 'frenify-core' ),
			]
		);
		
		$this->add_control(
		  'align',
		  [
			 'label'       => __( 'Text Align', 'frenify-core' ),
			 'type' => Controls_Manager::SELECT,
			 'default' => 'left',
			 'options' => [
				'left'  	=> __( 'Left', 'frenify-core' ),
				'center'  	=> __( 'Center', 'frenify-core' ),
				'right'  	=> __( 'Right', 'frenify-core' ),
			 ]
		  ]
		);
		
		$this->add_control(
		  'cols',
		  [
			 'label'       => __( 'Column Count', 'frenify-core' ),
			 'type' => Controls_Manager::SELECT,
			 'default' => '3',
			 'options' => [
				'2'  	=> __( '2 Columns', 'frenify-core' ),
				'3' 	=> __( '3 Columns', 'frenify-core' ),
				'4' 	=> __( '4 Columns', 'frenify-core' ),
			 ]
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
			'title_color',
			[
				'label' => __( 'Title Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_title' => 'color: {{VALUE}};',
				],
				'default' => '#888',
			]
		);
		
		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Description Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .fn_desc' => 'color: {{VALUE}};',
				],
				'default' => '#444',
			]
		);
		
		$this->add_control(
			'link_color',
			[
				'label' => __( 'Link Regular Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				],
				'default' => '#444',
			]
		);
		
		$this->add_control(
			'link_h_color',
			[
				'label' => __( 'Link Hover Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
				],
				'default' => '#f0ca6e',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'typography_section',
			[
				'label' => __( 'Typography', 'frenify-core' ),
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'frenify-core' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .fn_title',
				'fields_options' => [
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Muli',
					],
					'font_size'   => [
						'default' => [
										'unit' => 'px',
										'size' => '15'
									]
					],
					'line_height' => [
						'default' => [
										'unit' => 'em',
										'size' => '1.2',
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
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Description Typography', 'frenify-core' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .fn_desc',
				'fields_options' => [
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Muli',
					],
					'font_size'   => [
						'default' => [
										'unit' => 'px',
										'size' => '18'
									]
					],
					'line_height' => [
						'default' => [
										'unit' => 'em',
										'size' => '1.2',
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
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => __( 'Link Typography', 'frenify-core' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} a',
				'fields_options' => [
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Muli',
					],
					'font_size'   => [
						'default' => [
										'unit' => 'px',
										'size' => '18'
									]
					],
					'line_height' => [
						'default' => [
										'unit' => 'em',
										'size' => '1.2',
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
		
		
		$this->end_controls_section();
		
	

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		
		
		$cols 			= $settings['cols'];
		$check_list 	= $settings['check_list'];
		$align 			= $settings['align'];
		$html		 	= Frel_Helper::frel_open_wrap();
		$html			.= '<div class="fn_cs_detail_list" data-cols="'.$cols.'" data-align="'.$align.'">';
		if ( $check_list ) {
			$html .= '<div class="list"><ul>';
			foreach ( $check_list as $item ) {
				
				$html .= '<li><div class="item"><h5 class="fn_title">'.$item['list_title'].'</h5><p class="fn_desc">'.$item['list_desc'].'</p></div></li>';
			}
			$html .= '</ul></div>';
		}
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

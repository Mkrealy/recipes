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


class Frel_Ingredients extends Widget_Base {

	public function get_name() {
		return 'frel-ingredients';
	}

	public function get_title() {
		return __( 'Ingredients', 'frenify-core' );
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
            'ingredients',
            'arlo'
        ];
    }

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section1',
			[
				'label' => __( 'List', 'frenify-core' ),
			]
		);
		
		
		$this->add_control(
			'servings',
			[
				'label' 		=> __( 'Servings (people)', 'frenify-core' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'r_name',
			[
				'label' 		=> __( 'Ingredient Description', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Default description', 'frenify-core' ),
				'placeholder' 	=> __( 'Type your description here', 'frenify-core' ),
			]
		);
		
		$repeater->add_control(
			'r_type',
			[
				'label' 		=> __( 'Item Type', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> 'item',
				'options' 		=> [
					'item'  		=> __( 'Ingredient Item', 'frenify-core' ),
					'group'  		=> __( 'Ingredient Group', 'frenify-core' ),
				],
			]
		);

		$this->add_control(
			'repeater',
			[
				'label' => __( 'Accordion Items', 'frenify-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'r_name'	=> __( 'for the cauliflower mash', 'frenify-core' ),
						'r_type' 	=> 'group',
					],
					[
						'r_name'	=> __( '{{2}} tablespoons <strong>olive oil</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1}} head <strong>cauliflower</strong>, cut into small florets (about {{6}} cups)', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{3}} cloves <strong>garlic</strong>, minced', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1}} cup <strong>milk</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{3}} cups <strong>vegetable</strong> or <strong>chicken broth</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1}} 14-ounce can <strong>white beans</strong>, rinsed and drained', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1/2}} cup <strong>cornmeal</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1/2}} cup <strong>shredded cheese</strong>, like sharp cheddar or havarti', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1}} teaspoon <strong>salt</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( 'for the kale', 'frenify-core' ),
						'r_type' 	=> 'group',
					],
					[
						'r_name'	=> __( '{{1}} tablespoon <strong>sheep fat</strong> (or olive oil)', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{3}} cups <strong>kalettes</strong> OR chopped <strong>kale</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{3}} cloves <strong>garlic</strong>, minced', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( 'for the shrimp', 'frenify-core' ),
						'r_type' 	=> 'group',
					],
					[
						'r_name'	=> __( '{{1}} tablespoon <strong>olive oil</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( '{{1/2}} lb. <strong>shrimp</strong> (enough for 4 people)', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
					[
						'r_name'	=> __( 'a few good shakes of <strong>garlic salt, chili powder, cayenne</strong>, and/or <strong>black pepper</strong>', 'frenify-core' ),
						'r_type' 	=> 'item',
					],
				],
				'title_field' => '{{{ r_name }}}',
			]
		);
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_label',
			[
				'label' => __( 'Labels', 'frenify-core' ),
			]
		);
		
		
		$this->add_control(
			'ing_text',
			  [
				 'label'       => __( 'Ingredients Text', 'frenify-core' ),
				 'type'        => Controls_Manager::TEXT,
				 'default' 	   => __( 'Ingredients', 'frenify-core' ),
				 'label_block' => true,
			  ]
		);
		
		$this->add_control(
			'serves_text',
			  [
				 'label'       => __( 'Serves Text', 'frenify-core' ),
				 'type'        => Controls_Manager::TEXT,
				 'default' 	   => __( 'Serves', 'frenify-core' ),
				 'label_block' => true,
			  ]
		);
		
		$this->add_control(
			'people_text',
			  [
				 'label'       => __( 'People Text', 'frenify-core' ),
				 'type'        => Controls_Manager::TEXT,
				 'default' 	   => __( 'People', 'frenify-core' ),
				 'label_block' => true,
			  ]
		);
		
		$this->add_control(
			'print_text',
			  [
				 'label'       => __( 'Print Text', 'frenify-core' ),
				 'type'        => Controls_Manager::TEXT,
				 'default' 	   => __( 'Print Recipe', 'frenify-core' ),
				 'label_block' => true,
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
			'title_option',
			[
				'label' => __( 'Title', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'frenify-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ing_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top'		=> '',
					'right' 	=> '0',
					'bottom' 	=> '30',
					'left' 		=> '0',
					'unit' 		=> 'px',
					'isLinked' 	=> false,
				]
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
					'{{WRAPPER}} .ing_title' => 'color: {{VALUE}};',
				],
				'default' => '#1e1e1e',
			]
		);
		
		$this->add_control(
			'list_option',
			[
				'label' => __( 'List', 'frenify-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'list_group_color',
			[
				'label' => __( 'Group Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .group_title' => 'color: {{VALUE}};',
				],
				'default' => '#c00a27',
			]
		);
		
		$this->add_control(
			'list_icon_color',
			[
				'label' => __( 'Icon Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ingredient_item:after' => 'background-color: {{VALUE}};',
				],
				'default' => '#55ce63',
			]
		);
		
		$this->add_control(
			'list_text_color',
			[
				'label' => __( 'Text Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ingredient_item' => 'color: {{VALUE}};',
				],
				'default' => '#444',
			]
		);
		
		$this->add_control(
			'list_strong_color',
			[
				'label' => __( 'Strong Color', 'frenify-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ingredient_item strong' => 'color: {{VALUE}};',
				],
				'default' => '#1e1e1e',
			]
		);

		
		$this->end_controls_section();
		
	}

	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		
		$repeater 		= $settings['repeater'];
		$servings 		= $settings['servings']['size'];
		$html		 	= Frel_Helper::frel_open_wrap();
		
		$list = '';
		
		// get bottom section
		
		$bottom_left  = '<div class="bottom_left">';
			$bottom_left .= '<div class="fn_serves_calc">';
				$bottom_left .= '<div class="left_text">'.$settings['serves_text'].'</div>';
				$bottom_left .= '<div class="fn_serves_calc_input"><span class="fn_decrease"></span><input readonly min="1" type="number" value="'.$servings.'" /><span class="fn_increase"></span></div>';
				$bottom_left .= '<div class="right_text">'.$settings['people_text'].'</div>';
			$bottom_left .= '</div>';
		$bottom_left .= '</div>';
		
		$bottom_right  = '<div class="bottom_right">';
			$bottom_right .= '<a class="fn_cs_print">'.becipe_fn_getSVG_theme('printer').$settings['print_text'].'</a>';
		$bottom_right .= '</div>';
		
		$bottom_section = '<div class="bottom_section">';
			$bottom_section .= $bottom_left;
			$bottom_section .= $bottom_right;
		$bottom_section .= '</div>';
		
		$html .= '<div class="fn_cs_ingredients" data-servings="'.$servings.'">';
		if ( $repeater ) {
			$list = '<div class="top_section"><ul class="fn_cs_masonryy"><li class="fn_cs_masonryy_in"><div class="ingredient_group">';
			foreach ( $repeater as $key => $item ) {
				$type = $item['r_type'];
				$name = $item['r_name'];
				if($type == 'group'){
					if($key != 0){
						$list .= '</div></li><li class="fn_cs_masonry_in"><div class="ingredient_group">';
					}
					$list .= '<div class="group_title">'.$name.'</div>';
				}else if($type == 'item'){
					$name = str_replace('{{', '<span class="fn_changable_count">',$name);
					$name = str_replace('}}', '</span>',$name);
					$list .= '<div class="ingredient_item">'.$name.'</div>';
				}
			}
			$list .= '</div></li></ul></div>';
		}
		$text = $settings['ing_text'];
		if($text .= ''){
			$text = '<h3 class="ing_title">'.$text.'</h3>';
		}
		$html .= $text;
		$html .= $list;
		$html .= $bottom_section;
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

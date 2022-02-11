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


class Frel_Recipe_Instructions extends Widget_Base {

	public function get_name() {
		return 'frel-recipe-instructions';
	}

	public function get_title() {
		return __( 'Recipe Instructions', 'frenify-core' );
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
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'r_desc',
			[
				'label' 		=> __( 'Ingredient Description', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Default description', 'frenify-core' ),
				'placeholder' 	=> __( 'Type your description here', 'frenify-core' ),
			]
		);
		
		$repeater->add_control(
			'r_image',
			[
				'label' 		=> __( 'Choose Image', 'frenify-core' ),
				'type' 			=> \Elementor\Controls_Manager::MEDIA,
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
						'r_desc'	=> __( '<strong>Cauliflower Mash:</strong> Heat the olive oil in a large soup pot. Add the cauliflower and garlic. Saute for a minute or two, until the garlic is fragrant. Add the milk and 2 cups broth. Simmer for 10 minutes or until soft. Add the white beans and mash roughly with the back of a large wooden spoon. It will be soupy - that is okay. Stir in the cornmeal and things will start to thicken a bit. Adjust the consistency by adding in the last cup of broth as needed. Stir in the cheese and season to taste.', 'frenify-core' ),
					],
					[
						'r_desc'	=> __( '<strong>Kale:</strong> Heat the sheep fat in a nonstick skillet over medium low heat. Add the greens and garlic and saute until softened. For the kalettes, I added a little water at the end to sort of steam them to finish them off. Remove kale and wipe out pan with a paper towel.', 'frenify-core' ),
					],
					[
						'r_desc'	=> __( '<strong>Shrimp:</strong> In the same skillet, add the oil over medium heat. Pat the shrimp dry. Add to the pan and sprinkle with seasonings to taste. Cook for just a few minutes and then add a quick splash of water or broth to the pan (about 2 tablespoons) to pull the browned bits and spices into something of a saucy-coating for the shrimp. It is delicious.', 'frenify-core' ),
					],
					[
						'r_desc'	=> __( '<strong>Serve:</strong> Serve the shrimp and kale over a big pile of cauliflower mash! SO yummy.', 'frenify-core' ),
					],
				],
				'title_field' => '{{{ r_desc }}}',
			]
		);
		
		$this->add_control(
			'title',
			  [
				 'label'       => __( 'Title', 'frenify-core' ),
				 'type'        => Controls_Manager::TEXT,
				 'default' 	   => __( 'Instructions', 'frenify-core' ),
				 'label_block' => true,
			  ]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Color', 'frenify-core' ),
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
		
		

		
		$this->end_controls_section();
		
	}

	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		
		$title 			= $settings['title'];
		if($title != ''){
			$title		= '<div class="title_holder"><h3>'.$title.'</h3></div>';
		}
		$repeater 		= $settings['repeater'];
		$html		 	= Frel_Helper::frel_open_wrap();
		$list = '';
		
		$html .= '<div class="fn_cs_instructions">';
		if ( $repeater ) {
			$list .= '<div class="inst_list"><ul>';
			foreach ( $repeater as $key => $item ) {
				$desc	= $item['r_desc'];
				$image 	= $item['r_image']['url'];
				if($image != ''){
					$image = '<div class="fn_image"><img src="'.$image.'" alt="" /></div>';
				}
				if($desc != ''){
					$desc = '<div class="fn_desc">'.$desc.'</div>';
				}
				
				$key 	= '<div class="fn_number"><span>'.sprintf('%02d', ($key+1)).'</span></div>';
				
				$list .= '<li><div class="item">'.$key.$desc.$image.'</div></li>';
			}
			$list .= '</ul></div>';
		}
		$html .= $title;
		$html .= $list;
		$html .= '</div>';
		$html .= Frel_Helper::frel_close_wrap();
		echo $html;
	}

}

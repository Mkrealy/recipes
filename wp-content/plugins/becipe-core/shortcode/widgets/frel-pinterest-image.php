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
class Frel_Pinterest_Image extends Widget_Base {

	public function get_name() {
		return 'frel-pinterest-image';
	}

	public function get_title() {
		return __( 'Pinterest Image', 'frenify-core' );
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
            'pinterest',
            'arlo'
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
		  'image',
		  [
			 'label' => __( 'Choose Right Image', 'frenify-core' ),
			 'type' => Controls_Manager::MEDIA,
		  ]
		);
		
		$this->end_controls_section();

	}




	protected function render() {
		$title = get_bloginfo( 'name' );

		if ( empty( $title ) )
			return;

		
		$settings 		= $this->get_settings();
		$image_URL 		= $settings['image']['url'];
			
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
			$page_URL 	= "https://";
		}else{
			$page_URL 	= "http://";
		}
		// Append the host(domain name, ip) to the URL.   
		$page_URL		.= $_SERVER['HTTP_HOST'];   

		// Append the requested resource location to the URL   
		$page_URL		.= $_SERVER['REQUEST_URI'];
		
		$html 			= Frel_Helper::frel_open_wrap();
		
		$pin_button		= '<a href="http://www.pinterest.com/pin/create/button/?url='.urlencode($page_URL).'&media='.urlencode($image_URL).'&description='.get_the_title().'" target="_blank">'.becipe_fn_getSVG_core('pinterest-1').esc_html__('Pin', 'frenify-core').'</a>';
		
		$image = '<img src="'.$image_URL.'" alt="" />';
		
		$html .= '<div class="fn_cs_pin_image">'.$image.$pin_button.'</div>';
		
		$html .= Frel_Helper::frel_close_wrap();
		
		echo $html;
	}

}

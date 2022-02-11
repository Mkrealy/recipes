/*
 * Copyright (c) 2020 Frenify
 * Author: Frenify
 * This file is made for CURRENT TEMPLATE
*/

(function($){
	"use strict";
	
	
	var Becipe_Elementor = {
		
		init: function(){
			this.elementor();
		},
		
		elementor: function(){
			$('.frenifyicon-deprecated').each(function(){
				console.log('asd');
			});
			console.log('asdasdasd');
			console.log($('.elementor-element-wrapper').length);
		}
		
	};
	
	$( document ).ready(function(){Becipe_Elementor.init();});
	
})(jQuery);
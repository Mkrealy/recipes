(function($){
    "use strict";
	var ajax_running = false;
	
	var AjaxEl = {
		
		init: function(){
			
			var widgets = {
				'frel-title-with-content.default' : AjaxEl.ajaxCall,
			};

			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'panel/open_editor/widget', callback );
			});
			
		},
		
		ajaxCall: function(panel, model, view){	
			
			// panel:  	The Panel object
			// model:  	The Backbone model instance
			// view:  	The Backbone view instance
			if(model && view){} // just for removing not used error
			
			var fn_post_types 		= panel.$el.find( '.elementor-control-input-wrapper select[data-setting="fn_post_types"]' );
			var fn_post_terms 		= panel.$el.find( '.elementor-control-input-wrapper select[data-setting="fn_post_terms"]' );
			
			
			// for category select based on post type
			if(fn_post_types.length){
				fn_post_types.on('change', function(e){
					e.preventDefault();

					var chosed = $(this).children('option:selected').val();
					ajax_running = true;
					//fn_post_terms.parent().find('span.select2 *').css({opacity:0,maxWidth:0,maxHeight:0});
					//fn_post_terms.parent().find('span.select2 li.select2-selection__choice').remove();
					//$('.select2-results__option').attr('aria-selected', false);
					
					
					
					AjaxEl.doAjaxCallTerms(chosed, fn_post_terms);
				});
				
				fn_post_types.triggerHandler("change");
				
			}
			
			

		},
		
		// AJAX CALL TERMS
		doAjaxCallTerms:	function (current_post_type, current_categories){
			
			
			var requestData = {
				action: 'fn_action_post_terms',
				current_post_type: current_post_type,
			};
			
			
			$.ajax({
				type: 		'POST',
				url: 		fn_ajax_object.fn_ajax_url,
				cache:		true,
				data: 		requestData,
				success: 	function(data) {
					AjaxEl.AjaxProcessTerms(data, current_categories);
				},
				error: 		function(MLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});	
	
		},

		// AJAX PROCESS TERMS
		AjaxProcessTerms: function(data, current_categories){
			
			
			//console.log(data);
			
			//read the server response
			var result = '';
			var queriedObj = $.parseJSON(data); //get the data object
			var slugs = queriedObj.data_slugs;
			var names = queriedObj.data_names;
			var numberOfCats = slugs.length;
			
			
			for(var i = 0; i < numberOfCats; i++){
				result += '<option value="'+slugs[i]+'">'+names[i]+'</option>';
			}
			
			current_categories.html(result);
			
			//current_categories.parent().find('span.select2 *').css({opacity:1,maxWidth:'100%',maxHeight:'100%'});
			ajax_running = false; // finish the loading for this block
		},
		
	};
	
	$( window ).on( 'elementor/frontend/init', AjaxEl.init );
	
	
})(jQuery);
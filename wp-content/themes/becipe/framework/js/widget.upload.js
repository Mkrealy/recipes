jQuery(document).ready(function() {
	'use strict';
	jQuery(document).on('click', '.fn_widget_add_button', function(evt){
		
		evt.preventDefault();
		var element 	= jQuery(this);
		var preview 	= element.siblings('img');
		var hiddenType 	= element.siblings('input[type="hidden"]');
		
		var custom_uploader = wp.media({
			multiple: false  // Set this to true to allow multiple files to be selected
		})
		.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			preview.attr('src', attachment.url);
			hiddenType.val(attachment.url);
		})
		.open();
	});
	
	
	
	// added 18.09.2020
	jQuery('#frenify-postoption input[type="checkbox"]').each(function(){
		var element = jQuery(this),
			name	= element.attr('name');
		element.wrap('<label class="frenify_checkbox" for="'+name+'" />');
		element.parent().append('<span class="slider"></span>');
	});
});
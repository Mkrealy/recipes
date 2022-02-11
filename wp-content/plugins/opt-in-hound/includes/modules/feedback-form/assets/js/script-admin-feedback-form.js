jQuery( function($) {

	function is_email( email ) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	var current_panel = 1;

	/**
	 * Trigger feedback form
	 *
	 */
	$(document).on( 'click', '#oih-feedback-button', function() {

		$(this).toggleClass('oih-inactive');
		$('#oih-feedback-form-wrapper').toggleClass('oih-inactive');

	});

	/**
	 * Click to select the first options
	 *
	 */
	$(document).on( 'click', '#oih-feedback-form-panel-1 .oih-selection-label', function() {

		current_panel = 2;

		$('#oih-feedback-form-panel-1').removeClass('oih-doing').addClass('oih-done');
		$('#oih-feedback-form-panel-2').removeClass('oih-todo').addClass('oih-doing');

		$('#oih-feedback-form-navigation').fadeIn(250);

		setTimeout( function() {
			$('#oih-feedback-form-panel-2 textarea').focus();
		}, 300 );
		
	});

	/**
	 * Handle textarea functionality
	 *
	 */
	$(document).on( 'keyup', '#oih-feedback-form-panel-2 textarea', function() {

		var $textarea = $(this);

		$('#oih-feedback-form-char-count').html( parseInt( 250 - $textarea.val().length ) );

		/* Show counts */
		if( $textarea.val().length > 0 ) {

			$('#oih-feedback-form-description-char-count-1').hide();
			$('#oih-feedback-form-description-char-count-2').show();

		} else {

			$('#oih-feedback-form-description-char-count-2').hide();
			$('#oih-feedback-form-description-char-count-1').show();

		}

		/* Handle next button */
		if( $textarea.val().length >= 250 ) {

			$('#oih-feedback-form-next').removeClass('oih-inactive');

			$('#oih-feedback-form-description-char-count-2').hide();

		} else {

			$('#oih-feedback-form-next').addClass('oih-inactive');

		}

	});

	/**
	 * Handle email input functionality
	 *
	 */
	$(document).on( 'keyup', '#oih-feedback-form-panel-3 input[type=email]', function() {

		var $input = $(this);

		if( is_email( $input.val() ) ) {

			$('#oih-feedback-form-send').removeClass('oih-inactive');

		} else {

			$('#oih-feedback-form-send').addClass('oih-inactive');

		}

	});

	/**
	 * Handle back button navigation
	 *
	 */
	$(document).on( 'click', '#oih-feedback-form-back', function(e) {

		e.preventDefault();

		$('#oih-feedback-form-panel-' + current_panel ).removeClass('oih-doing').addClass('oih-todo');

		current_panel--;

		$('#oih-feedback-form-panel-' + current_panel ).removeClass('oih-done').addClass('oih-doing');

		if( current_panel == 1 )
			$('#oih-feedback-form-navigation').fadeOut(250);

		if( current_panel == 3 ) {
			$('#oih-feedback-form-next').hide();
			$('#oih-feedback-form-send').show();
		} else {
			$('#oih-feedback-form-next').show();
			$('#oih-feedback-form-send').hide();
		}

	});


	/**
	 * Handle next button navigation
	 *
	 */
	$(document).on( 'click', '#oih-feedback-form-next', function(e) {

		e.preventDefault();

		if( $(this).hasClass('oih-inactive') ) {
			$(this).closest('#oih-feedback-form-wrapper').find('.oih-doing input, .oih-doing textarea').focus();
			return false;
		}


		$('#oih-feedback-form-panel-' + current_panel ).removeClass('oih-doing').addClass('oih-done');

		current_panel++;

		$('#oih-feedback-form-panel-' + current_panel ).removeClass('oih-todo').addClass('oih-doing');

		setTimeout( function() {
			$('.oih-feedback-form-panel input[type=email]').focus();
		}, 300 );

		if( current_panel == 3 ) {
			$('#oih-feedback-form-next').hide();
			$('#oih-feedback-form-send').show();
		} else {
			$('#oih-feedback-form-next').show();
			$('#oih-feedback-form-send').hide();
		}

	});


	/**
	 * Handle send button
	 *
	 */
	$(document).on( 'click', '#oih-feedback-form-send', function(e) {

		e.preventDefault();

		if( $(this).hasClass('oih-inactive') ) {
			$(this).closest('#oih-feedback-form-wrapper').find('.oih-doing input, .oih-doing textarea').focus();
			return false;
		}

		$('#oih-feedback-form-navigation a').fadeOut(250);
		$('#oih-feedback-form-navigation .spinner').fadeIn(250);

		var data = {
			action 	   : 'oih_ajax_send_feedback',
			oih_token  : $('#oih_token').val(),
			type       : $('#oih-feedback-form-panel-1').find('input[type=radio]:checked').val(),
			message    : $('#oih-feedback-form-panel-2').find('textarea').val(),
			user_email : $('#oih-feedback-form-panel-3').find('input[type=email]').val()
		}

		$.post( ajaxurl, data, function( response ) {

			$('.oih-feedback-form-panel').removeClass('oih-doing').fadeOut( 250, function() {
				$('#oih-feedback-form-panel-4').removeClass('oih-todo').addClass('oih-doing').fadeIn();
			});

			$('#oih-feedback-form-navigation .spinner').fadeOut(250);

		});

	});

});
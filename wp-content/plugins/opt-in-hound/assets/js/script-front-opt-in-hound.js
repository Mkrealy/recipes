jQuery( function($) {

	var $opt_ins = $('.opt-in-hound-opt-in-wrapper');

	/**
	 * Handle opt-in dimensions on ready and window resize
	 *
	 */
	$opt_ins.each( function() {
		resize_opt_in( $(this) );
	});

	$(window).resize( function() {

		$opt_ins.each( function() {

			if( $(this).data('type') == 'pop_up' )
				position_opt_in( $(this) );

			resize_opt_in( $(this) );

		});

	});


	/**
	 * Add a trigger for when the opt-ins are being displayed
	 *
	 */
	$opt_ins.each( function() {

		if( $(this).css('visibility') != 'hidden' )
			on_show_opt_in_trigger( $(this) );

	});


	/**
	 * Add a data-display false to opt-ins if they are not in the active
	 * date range
	 *
	 */
	$opt_ins.each( function() {

		// Get current date
		var current_date = new Date();

		if( typeof $(this).data('schedules') == 'undefined' )
			return false;

		// Set schedules
		var schedules = $(this).data('schedules');

		// Set display to true at the beginning
		var display = true;
		

		/**
		 * Handle date range schedules
		 *
		 */
		for( var index in schedules ) {

			if( schedules[index].type != 'date_range' )
				continue;

			// Make display false if we find our first date range
			display = false;

			schedule = schedules[index];

			if( schedule.start_date ) {

				var start_date = new Date( schedule.start_date );

				display = ( current_date < start_date ? false : true );

			} else
				display = true;

			if( display && schedule.end_date ) {

				var end_date = new Date( schedule.end_date );

				display = ( current_date > end_date ? false : true );

			}

			if( display )
				break;

		}

		if( true == display ) {

			/**
			 * Handle recurring weekly
			 *
			 */
			for( var index in schedules ) {

				if( schedules[index].type != 'recurring_weekly' )
					continue;

				schedule = schedules[index];

				if( ! schedule.weekdays )
					continue;

				var current_day = current_date.getDay();

				// Sunday is saved as 7 in the db
				if( current_day == 0 )
					current_day = 7;

				display = ( schedule.weekdays.indexOf( current_day ) == -1 ? false : true );

				if( display )
					break;

			}

			/**
			 * Handle recurring monthly
			 *
			 */
			if( false == display ) {

				for( var index in schedules ) {

					if( schedules[index].type != 'recurring_monthly' )
						continue;

					schedule = schedules[index];

					if( ! schedule.monthdays )
						continue;

					var current_day = current_date.getDate();

					display = ( schedule.monthdays.indexOf( current_day ) == -1 ? false : true );

					if( display )
						break;

				}

			}

		}

		if( false == display )
			$(this).data( 'display', false );

		else
			$(this).css( 'display', 'block' );

	});


	/**
	 * Calculate scroll percentage
	 *
	 */
	var has_scrolled = false;
	var scroll_top 	 = 0;

	$(window).scroll( function() {

		// User has scrolled
		has_scrolled = true;
			
		// Calculate scrollTop in percentages on user scroll
		scroll_top = parseInt( $(window).scrollTop() / ($(document).innerHeight() - $(window).height()) * 100 );

	});

	$(window).load( function() {

		has_scrolled = false;

		// Calculate scrollTop in percentages on page load
		scroll_top = parseInt( $(window).scrollTop() / ($(document).innerHeight() - $(window).height()) * 100 );

	});


	/**
	 * On window load show opt-ins that should be displayed on page load
	 *
	 */
	$(window).load( function() {

		$opt_ins.each( function() {

			$this = $(this);

			if( $this.data('type') == 'pop_up' || $this.data('type') == 'fly_in' || $this.data('type') == 'floating_bar' ) {

				$wrapper = $this.parent();

				if( typeof $wrapper.data('page-load') != 'undefined' ) {
					show_opt_in( $this );			
				}
			}
			
		});

	});


	/**
	 * On document ready handle opt-ins
	 *
	 */
	$opt_ins.each( function() {

		$this = $(this);
		
		// Handle pop-ups
		if( $this.data('type') == 'pop_up' || $this.data('type') == 'fly_in' || $this.data('type') == 'floating_bar' ) {

			$wrapper = $this.parent();

			// Remove if the device doesn't match
			if( typeof $wrapper.data('show-on-device') != 'undefined' ) {

				if( is_mobile() && $wrapper.data('show-on-device') == 'desktop' ) {
					$wrapper.parents('.opt-in-hound-opt-in-pop-up-overlay').remove();
					$wrapper.remove();
				}

				if( ! is_mobile() && $wrapper.data('show-on-device') == 'mobile' ) {
					$wrapper.parents('.opt-in-hound-opt-in-pop-up-overlay').remove();
					$wrapper.remove();
				}

			}


			// Remove if the cookie is set
			var session_length = get_opt_in_session_length( $this );

			if( session_length != 0 ) {

				if( get_cookie( $wrapper.attr('id') ) != '' ) {

					$wrapper.parents('.opt-in-hound-opt-in-pop-up-overlay').remove();
					$wrapper.remove();

				}

			} else
				set_cookie( $wrapper.attr('id'), '', -1 );

			// Set time on page trigger
			if( typeof $wrapper.data('time-on-page') != 'undefined' ) {

				setTimeout( function() {
					show_opt_in( $this );
				}, parseInt( $wrapper.data('time-on-page') ) * 1000 );

			}

			// Listen for on click events
			if( typeof $wrapper.data('element-on-click') != 'undefined' ) {

				$(document).on( 'click', $wrapper.data('element-on-click'), function(e) {
					e.preventDefault();
					show_opt_in( $this );
					$this.removeData('dom-remove');
				});

			}

			// Show opt-in on user exit
			if( typeof $wrapper.data( 'user-exit' ) != 'undefined' ) {

				document.documentElement.addEventListener( 'mouseleave', documentMouseLeave );

				function documentMouseLeave(e) {
					if( e.clientY < 1 )
						show_opt_in( $this );
				}

			}

		}

	});


	/**
	 * Set user scroll distance trigger
	 *
	 */
	$(window).scroll( function() {
			
		if( has_scrolled == true ) {

			$opt_ins.each( function() {

				$this   = $(this);
				$pop_up = $this.parent();

				// Trigger for scroll position
				if( ( typeof $pop_up.data('user-scrolls') != 'undefined' ) && scroll_top >= parseInt( $pop_up.data('user-scrolls') ) )
					show_opt_in( $this );

			});

		}
		
	});


	/**
	 * Close opt-in pop-up on overlay click
	 *
	 */
	$(document).on( 'click', '.opt-in-hound-opt-in-pop-up-overlay.opened', function(e) {

		// Take into account only overlay clicks, not children
		if( e.target != this )
			return;
		
		e.preventDefault();

		$('.opt-in-hound-opt-in-pop-up.opt-in-hound-close-overlay-click[data-id=' + $(this).data('id') + ']').find('.opt-in-hound-opt-in-pop-up-close').click();

	});


	/**
	 * Close opt-in pop-up on ESC key press
	 *
	 */
	$(document).on( 'keyup', function(e) {

		if( e.keyCode == 27 ) {

			$('.opt-in-hound-opt-in-pop-up.opt-in-hound-close-esc-key.opened').find('.opt-in-hound-opt-in-pop-up-close').click();

		}

	});


	/**
	 * Close opt-in
	 *
	 */
	$(document).on( 'click', '.opt-in-hound-opt-in-close', function(e) {

		e.preventDefault();

		hide_opt_in( $(this).siblings('.opt-in-hound-opt-in-wrapper') );

	});


	/**
	 * Detects if the current device is a mobile device
	 *
	 */
	function is_mobile() {

		if( /Android|webOS|iPhone|iPad|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/i.test( navigator.userAgent ) )
			return true;
		else
			return false;

	}


	/**
	 * Checks the width of the opt-in and makes it narrow if it
	 * gets under a certain width
	 *
	 */
	function resize_opt_in( $opt_in ) {

		if( $opt_in.outerWidth() < 900 ) {
			$opt_in.addClass('opt-in-hound-max-width-900');
		} else {
			$opt_in.removeClass('opt-in-hound-max-width-900');
		}

		if( $opt_in.outerWidth() < 700 ) {
			$opt_in.addClass('opt-in-hound-max-width-700');
		} else {
			$opt_in.removeClass('opt-in-hound-max-width-700');
		}

		if( $opt_in.outerWidth() < 500 ) {
			$opt_in.addClass('opt-in-hound-narrow');
		} else {
			$opt_in.removeClass('opt-in-hound-narrow');
		}

	}


	/*
	 * Shows the pop-up
	 *
	 */
	function show_opt_in( $opt_in ) {

		if( $opt_in.data('display') == false )
			return false;

		if( $('.opt-in-hound-opt-in-wrapper').parent().hasClass('opened') )
			return false;

		if( $opt_in.data('visibility') == 'visible' )
			return false;

		// Set cookies for pop-up and fly-in
		if( $opt_in.data('type') == 'pop_up' || $opt_in.data('type') == 'fly_in' || $opt_in.data('type') == 'floating_bar' ) {

			$wrapper = $this.parent();

			var session_length = get_opt_in_session_length( $this );

			if( session_length != 0 )
				set_cookie( $wrapper.attr('id'), '1', session_length, '/' );

		}

		var data_id = $opt_in.data('id');

		$opt_in.data('visibility', 'visible');
		$opt_in.data('dom-remove', 1);

		$opt_in.parent().addClass('opened');
		$opt_in.parent().parent().addClass('opened');

		if( $opt_in.data('type') == 'pop_up' )
			position_opt_in( $opt_in );

		// Add on show trigger
		on_show_opt_in_trigger( $opt_in );

	}


	/*
	 * Hides the pop-up and maybe removes it from the DOM
	 *
	 */
	function hide_opt_in( $opt_in ) {

		var data_id = $opt_in.data('id');

		$opt_in_parent 	 	  = $opt_in.parent();
		$opt_in_parent_parent = $opt_in_parent.parents('[data-id="' + data_id + '"]');

		$opt_in_parent.removeClass('opened');
		$opt_in_parent_parent.removeClass('opened');

		$opt_in.data('visibility', 'hidden');

		// Remove overflow
		remove_opt_in_overflow( $opt_in );

		if( typeof $opt_in.data('dom-remove') != 'undefined' ) {

			setTimeout( function() {
				$opt_in_parent.remove();
				$opt_in_parent_parent.remove();

				// Re-cache the remaining opt-ins
				$opt_ins = $('.opt-in-hound-opt-in-wrapper');
			}, 350 );

		}

	}


	/**
	 * Positions the opt-in in the center of the screen
	 *
	 */
	function position_opt_in( $opt_in ) {

		$pop_up = $opt_in.parent();

		var windowHeight = window.innerHeight;
		var windowWidth  = window.innerWidth;

		var popUpHeight  = $pop_up.outerHeight();
		var popUpWidth   = $pop_up.outerWidth();

		$pop_up.css({
			top  : ( windowHeight - popUpHeight ) / 2,
			left : ( windowWidth - popUpWidth ) / 2
		});

		add_opt_in_overflow( $opt_in );

	}


	/**
	 * Checks to see if the opt-in's height is greater than the window
	 * and adds an overflow-y property so that the opt-in looks awesome
	 *
	 */
	function add_opt_in_overflow( $opt_in ) {

		var data_id = $opt_in.data('id');

		if( $opt_in.data('type') != 'pop_up' )
			return false;

		$opt_in_parent 	 	  = $opt_in.parent();
		$opt_in_parent_parent = $opt_in_parent.parents('[data-id="' + data_id + '"]');

		if( $opt_in_parent.outerHeight() > $(window).innerHeight() ) {

			$('html').addClass('opt-in-hound-overflow');
			$('body').addClass('opt-in-hound-overflow');
			$opt_in_parent.addClass('opt-in-hound-overflowing');
			$opt_in_parent_parent.addClass('opt-in-hound-overlay-overflowing');

		} else {
			remove_opt_in_overflow( $opt_in );
		}

	}

	/**
	 * Removes the opt-in overflow
	 *
	 */
	function remove_opt_in_overflow( $opt_in ) {

		var data_id = $opt_in.data('id');

		if( $opt_in.data('type') != 'pop_up' )
			return false;

		$opt_in_parent 	 	  = $opt_in.parent();
		$opt_in_parent_parent = $opt_in_parent.parents('[data-id="' + data_id + '"]');

		$('html').removeClass('opt-in-hound-overflow');
		$opt_in_parent.removeClass('opt-in-hound-overflowing');
		$opt_in_parent_parent.removeClass('opt-in-hound-overlay-overflowing');

	}


	/**
	 * If the opt-in has an on_show_trigger than do an ajax call for
	 * the trigger
	 *
	 */
	function on_show_opt_in_trigger( $opt_in ) {

		if( $opt_in.data('on_show_trigger') != 1 )
			return false;

		var data = {
			'action'	  : 'oih_opt_in_show_trigger',
			'opt_in_id'   : parseInt( $opt_in.data('id') ),
			'opt_in_type' : $opt_in.data('type'),
			'oih_token'	  : $opt_in.find('[data-name=oih_token]').val(),
			'page_data'	  : JSON.stringify( oih_current_page_data )
		}

		$.post( oih_ajax_url, data, function( response ) {});

	}


	/**
	 * Returns the session lengths ( in days ) set by the admin
	 * for a given opt-in
	 *
	 */
	function get_opt_in_session_length( $opt_in ) {

		$wrapper = $opt_in.parent();

		var session_length = 0;

		if( typeof $wrapper.data( 'session-length' ) != 'undefined' )
			session_length = parseInt( $wrapper.data( 'session-length' ) );

		return session_length;

	}


	/**
	 * Set a cookie
	 *
	 */
	function set_cookie( cname, cvalue, exdays, path ) {

	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+d.toUTCString();

	    if( path )
	    	path = "path=" + path;

	    document.cookie = cname + "=" + cvalue + "; " + expires + "; " + path;

	}


	/**
	 * Get a cookie
	 *
	 */
	function get_cookie( cname ) {

	    var name = cname + "=";
	    var ca = document.cookie.split(';');

	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	    }

	    return "";

	}


	/**
	 * Handle form submission
	 *
	 */
	$(document).on( 'click', '.opt-in-hound-opt-in-form button', function(e) {

		e.preventDefault();

		var $form 		 = $(this).closest('form');
		var $form_fields = $form.find( '.opt-in-hound-opt-in-form-input input' );
		var $opt_in 	 = $form.closest('.opt-in-hound-opt-in-wrapper');

		var data = {};

		// Add the action we want to make
		data['action'] 	  = 'oih_opt_in_form_submission';
		data['opt_in_id'] = parseInt( $opt_in.data('id') );

		// Add data for each input
		$form_fields.each( function() {
			data[ $(this).data('name').replace( 'oih_', '' ) ] = $(this).val();
		});

		// Add token data
		data['oih_token'] = $form.find('[data-name=oih_token]').val();

		// Add current page data
		data['page_data'] = JSON.stringify( oih_current_page_data );

		// Show loading spinner instead of the button label
		$form.find('button span').fadeOut( 200, function() {
			$form.find('.oih-loading-spinner').fadeIn( 300 );
		});

		// Disable the fields
		$form_fields.attr( 'disabled', true );

		$.post( oih_ajax_url, data, function( response ) {

			var response 	= JSON.parse( response );
			var enable_form = true;

			// Show the thank you message if everythin is okay
			if( typeof response.success != 'undefined' ) {

				// Display success message
				if( response.success_type == 'message' ) {

					$opt_in.find('.opt-in-hound-opt-in-content-wrapper').fadeOut( 400 );
					$opt_in.find('.opt-in-hound-opt-in-form-wrapper').fadeOut( 400, function() {
						$opt_in.find('.opt-in-hound-opt-in-success-message-wrapper').fadeIn( 400 );
					});

				}

				// Redirect to a page
				if( response.success_type == 'redirect_to_page' ) {

					if( typeof response.success_redirect_page != 'undefined' )
						window.location = response.success_redirect_page;

					enable_form = false;

				}

			}

			// Add the errors message if any
			if( typeof response.error != 'undefined' ) {

				$form.siblings('.opt-in-hound-opt-in-form-errors').addClass('opt-in-hound-active').html( response.error );

			}

			if( enable_form ) {

				// Show button label instead of the loading spinner
				$form.find('.oih-loading-spinner').fadeOut( 300, function() {
					$form.find('button span').fadeIn( 200 );
				});

				// Enable the fields
				$form_fields.attr( 'disabled', false );

			}

		});

	});

});
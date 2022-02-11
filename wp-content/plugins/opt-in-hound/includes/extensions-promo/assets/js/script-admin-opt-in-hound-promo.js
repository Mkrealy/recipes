jQuery( function($) {

	$('.oih-promo-pop-up .oih-promo-pop-up-close').click( function(e) {

		e.preventDefault();

		$(this).closest('.oih-promo-pop-up').removeClass('oih-open');
		$('.oih-promo-pop-up-overlay').removeClass('oih-open');

	});


	/**
	 * Display promo pop-up for lists
	 *
	 */
	$('.oih-wrap-lists h1 a[data-trigger-promo]').click( function(e) {

		e.preventDefault();

		$('#oih-promo-pop-up-lists').addClass('oih-open');
		$('#oih-promo-pop-up-lists-overlay').addClass('oih-open');

	});

	/**
	 * Display promo pop-up for opt-in type "after content"
	 *
	 */
	$('label[for=oih-opt-in-type-after_content_promo], label[for=oih-opt-in-type-fly_in_promo], label[for=oih-opt-in-type-shortcode_promo], label[for=oih-opt-in-type-floating_bar_promo]').click( function(e) {

		e.preventDefault();

		$('#oih-promo-pop-up-opt-in-types').addClass('oih-open');
		$('#oih-promo-pop-up-opt-in-types-overlay').addClass('oih-open');

	});

});
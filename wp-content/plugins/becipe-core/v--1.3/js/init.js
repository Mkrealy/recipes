
(function($, fnFrontend){
	"use strict";
	
	
	
	var FrenifyBecipe = {
		
		isAdmin: false,
		adminBarH: 0,
		noRecords: 'No Records',
		
		init: function() {
			
			if($('body').hasClass('admin-bar')){
				FrenifyBecipe.isAdmin 	= true;
				FrenifyBecipe.adminBarH 	= $('#wpadminbar').height();
			}

			var widgets = {
				'frel-featured-recipes.default' : FrenifyBecipe.featuredPostsSlider,
				'frel-posts-slider.default' : FrenifyBecipe.postsSlider,
				'frel-gallery.default' : FrenifyBecipe.allGalleryFunctions,
				'frel-posts-list-filter.default' : FrenifyBecipe.postsFilter,
				'frel-ingredients.default' : FrenifyBecipe.ingredients,
			};

			$.each( widgets, function( widget, callback ) {
				fnFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});
		},
		
		ingredients: function(){
			FrenifyBecipe.ImgToSVG();
			FrenifyBecipe.print();
			FrenifyBecipe.increaseDecrease();
			FrenifyBecipe.isotopeFunction();
		},
		
		print: function(){
			$('.fn_cs_ingredients .fn_cs_print').off().on('click',function(){
				var content = $(this).closest('.cons_w_wrapper').html();
				content = '<div class="becipe_fn_print_section"><div class="becipe_fn_container"><div class="becipe_fn_container_in">'+content+'</div></div></div>';
				FrenifyBecipe.print_me(content);
			});
		},
		
		print_me: function(content){
			$('html').addClass('becipe_fn_print_action');
			$('body').append(content);
			window.print();
			$('.becipe_fn_print_section').remove();
			$('html').removeClass('becipe_fn_print_action');

			return true;
		},
		
		decimalToFraction: function(value, donly = true) {
			var tolerance = 1.0E-6; // from how many decimals the number is rounded
			var h1 = 1;
			var h2 = 0;
			var k1 = 0;
			var k2 = 1;
			var negative = false;
			var i;

			if (parseInt(value) == value) { // if value is an integer, stop the script
				return value;
			} else if (value < 0) {
				negative = true;
				value = -value;
			}

			if (donly) {
				i = parseInt(value);
				value -= i;
			}

			var b = value;

			do {
				var a = Math.floor(b);
				var aux = h1;
				h1 = a * h1 + h2;
				h2 = aux;
				aux = k1;
				k1 = a * k1 + k2;
				k2 = aux;
				b = 1 / (b - a);
			} while (Math.abs(value - h1 / k1) > value * tolerance);

			return (negative ? "-" : '') + ((donly & (i != 0)) ? i + ' ' : '') + (h1 == 0 ? '' : h1 + "/" + k1);
//			return (negative ? "-" : '') + (h1 == 0 ? '' : (h1+k1*i) + "/" + k1);
		},
		
		calc: function(parent,action){
			var input			= parseFloat(parent.find('.fn_serves_calc_input input').val());
			
			var values			= parent.find('.fn_changable_count');
			var servings		= parent.attr('data-servings');
			values.each(function(){
				var el			= $(this);
				var html		= el.html();
				html	 = eval(html);
				var n;
				if(action === 'increase'){
					n = (html / (input-1) ) * input;
//					console.log((el.html() / (input-1) ) * input);
//					el.html(FrenifyBecipe.decimalToFraction(n);
					el.html(n);
					el.attr('title',FrenifyBecipe.decimalToFraction(n));
				}else if(action == 'decrease'){
					n = (html / (input+1) ) * input;
					el.html(n);
					el.attr('title',FrenifyBecipe.decimalToFraction(n));
				}
			});
			FrenifyBecipe.isotopeFunction();
		},
		
		increaseDecrease: function(){
			var decrease = $('.fn_cs_ingredients .fn_decrease');
			decrease.off().on('click',function(){
				var element		= $(this);
				var parent		= element.closest('.fn_cs_ingredients');
				var input		= parent.find('.fn_serves_calc_input input');
				var oldValue 	= parseFloat(input.val());
				var min			= input.attr('min');
				var newValue;
				if(oldValue <= min){
					newValue = oldValue;
					return false;
				}else{
					newValue = oldValue - 1;
				}
				
				input.val(newValue);
				input.trigger("change");
				FrenifyBecipe.calc(parent,'decrease');
				return false;
			});
			var increase = $('.fn_cs_ingredients .fn_increase');
			increase.off().on('click',function(){
				var element	= $(this);
				var parent	= element.closest('.fn_cs_ingredients');
				var input	= parent.find('.fn_serves_calc_input input');
				var oldValue = parseFloat(input.val());
				var newValue;
				newValue = oldValue + 1;
				
				input.val(newValue);
				input.trigger("change");
				FrenifyBecipe.calc(parent,'increase');
				return false;
			});
		},
		
		postsFilter: function(){
			FrenifyBecipe.ImgToSVG();
			FrenifyBecipe.BgImg();
			FrenifyBecipe.allll();
		},
		
		paginationFilter: function(){
			var self			= this;
			if($('.fn_cs_posts_filter').length){
				var pagination 	= $('.fn_cs_posts_filter .my_pagination a');
				pagination.off().on('click',function(){
					var el		= $(this);
					var li		= el.parent();
					if(!li.hasClass('current')){
						self.filterAjaxCall(el,el.html());
					}
					return false;
				});
			}
		},
		allll: function(){
			var self						= this;
			if($('.fn_cs_posts_filter').length){
				self.paginationFilter();
				var inputWrapper			= $('.fn_cs_posts_filter .input_wrapper');
				
				var categoryFilter			= $('.fn_filter_wrap.category_filter');
				var categoryPopup			= categoryFilter.find('.filter_popup_list');
				var categoryInput			= categoryFilter.find('input[type="text"]');
				var categoryHidden			= categoryFilter.find('input[type="hidden"]');
				var categoryNewValue		= categoryFilter.find('.new_value');
				var categoryPlaceholder		= categoryInput.attr('data-placeholder');
				var categoryType			= categoryInput.attr('data-type');
				
				var difficultyFilter		= $('.fn_filter_wrap.difficulty_filter');
				var difficultyPopup			= difficultyFilter.find('.filter_popup_list');
				var difficultyInput			= difficultyFilter.find('input');
				var difficultyPlaceholder	= difficultyInput.attr('data-placeholder');
				var difficultyType			= difficultyInput.attr('data-type');
				
				var countryFilter			= $('.fn_filter_wrap.country_filter');
				var countryPopup			= countryFilter.find('.filter_popup_list');
				var countryInput			= countryFilter.find('input');
				var countryPlaceholder		= countryInput.attr('data-placeholder');
				var countryType				= countryInput.attr('data-type');
				
				inputWrapper.on('click',function(){
					$('.filter_popup_list .item').show(); //added new
					$('.filter_popup_list .no_records').remove(); //added new
				});
				
				
				/************************/
				/* Filter by Country */
				/************************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					countryFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				countryFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					difficultyFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					countryFilter.addClass('opened');
				});
				
				/* change placeholder to "Type Something" and backward */
				countryInput.focusout(function() {
					countryInput.attr('placeholder', countryPlaceholder);
				}).focus(function() {
					countryInput.attr('placeholder', countryType);
				});
				
				/* live search */
				countryInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= countryPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						countryFilter.addClass('ready clear');
					}else{
						countryFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				countryPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');

					if(!el.hasClass('sending')){
						el.addClass('sending');
						el.siblings().removeClass('sending');
						countryInput.attr('placeholder',''); // remove placeholder
						countryInput.val(statusName);
						countryFilter.addClass('ready'); // to enable reset button
						countryFilter.removeClass('opened');

						countryFilter.addClass('filtered');
						self.filterAjaxCall(el);
					}

					return false;
				});
				
				/* remove filter */
				countryFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					difficultyFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					
					countryInput.val(''); // added new
					countryPopup.find('.item').show(); //added new
					countryPopup.find('.no_records').remove(); // added new
					countryInput.attr('placeholder',countryPlaceholder);
					countryFilter.removeClass('ready');
					countryPopup.find('.item').removeClass('sending');
					countryFilter.removeClass('opened');
					countryFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
				
				/************************/
				/* Filter by Difficulty */
				/************************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					difficultyFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				difficultyFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();

					categoryFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					difficultyFilter.addClass('opened');
				});
				
				/* change placeholder to "Type Something" and backward */
				difficultyInput.focusout(function() {
					difficultyInput.attr('placeholder', difficultyPlaceholder);
				}).focus(function() {
					difficultyInput.attr('placeholder', difficultyType);
				});
				
				/* live search */
				difficultyInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= difficultyPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						difficultyFilter.addClass('ready clear');
					}else{
						difficultyFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				difficultyPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');

					if(!el.hasClass('sending')){
						el.addClass('sending');
						el.siblings().removeClass('sending');
						difficultyInput.attr('placeholder',''); // remove placeholder
						difficultyInput.val(statusName);
						difficultyFilter.addClass('ready'); // to enable reset button
						difficultyFilter.removeClass('opened');

						difficultyFilter.addClass('filtered');
						self.filterAjaxCall(el);
					}

					return false;
				});
				
				/* remove filter */
				difficultyFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					countryFilter.removeClass('opened');
					categoryFilter.removeClass('opened');
					
					difficultyInput.val(''); // added new
					difficultyPopup.find('.item').show(); //added new
					difficultyPopup.find('.no_records').remove(); // added new
					difficultyInput.attr('placeholder',difficultyPlaceholder);
					difficultyFilter.removeClass('ready');
					difficultyPopup.find('.item').removeClass('sending');
					difficultyFilter.removeClass('opened');
					difficultyFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
				
				
				
				
				
				/**********************/
				/* Filter by Category */
				/**********************/
				
				
				/* remove popup on window click */
				$(window).on('click',function(){
					categoryFilter.removeClass('opened');
				});
				
				/* open popup on filter click */
				categoryFilter.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					difficultyFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					categoryFilter.addClass('opened');
					categoryInput.focus();
				});
				
				/* change placeholder to "Type Something" and backward */
				categoryInput.focusout(function() {
					if(categoryNewValue.html() === ''){
						categoryInput.attr('placeholder', categoryPlaceholder);
					}else{
						categoryInput.attr('placeholder', '');
					}
					
				}).focus(function() {
					categoryInput.attr('placeholder', categoryType);
				});
				
				/* live search */
				categoryInput.on('keyup', function(){
					var searchText 	= $(this).val().toUpperCase();
					var list 		= categoryPopup.find('.filter_popup_list_in');
					var item 		= list.children('.item');
					var span, i, txtValue, counter=0;
					var norecord 	= list.find('.no_records');

					if(searchText !== ''){
						categoryFilter.addClass('ready clear');
					}else{
						categoryFilter.removeClass('ready clear');
					}
					for (i = 0; i < item.length; i++) {
						span 		= item[i].getElementsByTagName("span")[0];
						txtValue 	= span.textContent || span.innerText;
						if (txtValue.toUpperCase().indexOf(searchText) > -1) {
							item[i].style.display = "";
							counter--;
						} else {
							item[i].style.display = "none";
							counter++;
						}

					}
					if(counter === item.length && !norecord.length){
						list.append('<div class="no_records"><span>'+self.noRecords+'</span></div>');
					}else if(counter !== item.length){
						list.find('.no_records').remove();
					}

				});
				
				/* select function */
				categoryPopup.find('.item').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el 			= $(this);
					var statusName 	= el.data('name');
					var array = [],newvalue = '';
					
					console.log(categoryHidden.val());
					if(categoryHidden.val() !== ''){
						array = categoryHidden.val().split(',');
					}

					categoryInput.val('');
					categoryPopup.find('.item').show();
					categoryPopup.find('.no_records').remove();
					categoryInput.attr('placeholder','');
					categoryInput.bind('click');
					
					if(!el.hasClass('sending')){
						el.addClass('sending');
						array.push(statusName);
//						el.siblings().removeClass('sending');
//						categoryInput.attr('placeholder',''); // remove placeholder
//						categoryInput.val(statusName);
//						categoryFilter.addClass('ready'); // to enable reset button
//						categoryFilter.removeClass('opened');

//						categoryFilter.addClass('filtered');
//						self.filterAjaxCall(el);
					}else{
						el.removeClass('sending');
						var index = array.indexOf(statusName);
						if (index > -1) {
							array.splice(index, 1);
						}
					}
					categoryHidden.val(array.join(','));
					categoryHidden.triggerHandler("change");
					if(array.length){
						categoryFilter.addClass('ready'); // to enable reset button
						categoryFilter.addClass('filtered');
						newvalue += ''+array[0];
						if(array.length > 1){
							newvalue += ', + ' + (array.length - 1);
						}
					}else{
						categoryFilter.removeClass('ready'); // to disable reset button
						categoryFilter.removeClass('filtered');
					}
					categoryNewValue.html(newvalue);
					categoryInput.focus();
					self.filterAjaxCall(el);

					return false;
				});
				
				/* remove filter */
				categoryFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					difficultyFilter.removeClass('opened');
					countryFilter.removeClass('opened');
					
					categoryHidden.val('');
					categoryHidden.triggerHandler("change");
					categoryInput.val(''); // added new
					categoryNewValue.html('');
					categoryPopup.find('.item').show(); //added new
					categoryPopup.find('.no_records').remove(); // added new
					categoryInput.attr('placeholder',categoryPlaceholder);
					categoryFilter.removeClass('ready');
					categoryPopup.find('.item').removeClass('sending');
					categoryFilter.removeClass('opened');
					categoryFilter.removeClass('filtered');
					
					self.filterAjaxCall(el);
				});
			}
		},
		filterAjaxCall: function(element,filter_page){
			var pagination = true;
			if ( typeof filter_page === 'undefined') {
			  	filter_page = 1;
				pagination 	= false;
			}
			var parent = element.closest('.fn_cs_posts_filter');
			if(parent.hasClass('loading')){
				return false;
			}
			var read_more 				= parent.find('.fn_hidden_read_more').val();
			var filter_order 			= parent.find('.fn_hidden_post_order').val();
			var filter_orderby 			= parent.find('.fn_hidden_post_orderby').val();
			var filter_include 			= parent.find('.fn_hidden_post_include').val();
			var filter_exclude 			= parent.find('.fn_hidden_post_exclude').val();
			var filter_cat_include 		= parent.find('.fn_hidden_cat_include').val();
			var filter_cat_exclude 		= parent.find('.fn_hidden_cat_exclude').val();
			var filter_perpage 			= parent.find('.fn_hidden_perpage').val();
			var filter_difficulty		= '*';
			var filter_country			= '*';
			var filter_category_array	= '';
			filter_category_array 		= parent.find('.category_filters').val();
			if(parent.find('.filter_popup_list.difficulty div.sending').length){
				filter_difficulty		= parent.find('.filter_popup_list.difficulty .sending').data('filter');
			}
			if(parent.find('.filter_popup_list.country div.sending').length){
				filter_country			= parent.find('.filter_popup_list.country .sending').data('filter');
			}
			var requestData = {
				action: 'becipe_fn_cs_ajax_filter_posts',
				filter_order: filter_order,
				filter_orderby: filter_orderby,
				filter_include: filter_include,
				filter_exclude: filter_exclude,
				filter_category_array: filter_category_array,
				filter_cat_include: filter_cat_include,
				filter_cat_exclude: filter_cat_exclude,
				filter_perpage: filter_perpage,
				filter_difficulty: filter_difficulty,
				filter_country: filter_country,
				filter_page: filter_page,
				read_more: read_more,
			};


			$.ajax({
				type: 'POST',
				url: fn_ajax_object.fn_ajax_url,
				cache: false,
				data: requestData,
				success: function(data) {
					var fnQueriedObj 	= $.parseJSON(data);
					var html			= fnQueriedObj.becipe_fn_data;
					parent.find('.post_section_in').html(html);
					FrenifyBecipe.BgImg();
					FrenifyBecipe.ImgToSVG();
					FrenifyBecipe.like();
					parent.removeClass('loading');
					var speed			= 800;
					if(!pagination){
						speed = 0;
					}
					var listItem 		= parent.find('.my_list ul > li');
					if(listItem.length){
						setTimeout(function(){
							listItem.each(function(i, e){
								setTimeout(function(){
									$(e).addClass('fadeInTop done');
								}, (i*100));
							});
						}, speed+100);
					}else{
						parent.find('.fn_animated').addClass('fadeInTop done');
					}
					if(pagination){
						$([document.documentElement, document.body]).animate({
							scrollTop: parent.offset().top - 30
						}, speed);
					}
						
					FrenifyBecipe.paginationFilter();
				},
				error: function(xhr, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(xhr);
				}
			});
		},
		
		featuredPostsSlider: function(){
			FrenifyBecipe.BgImg();
			FrenifyBecipe.ImgToSVG();
			FrenifyBecipe.featuredSlider();
		},
		
		like: function(){
			var svg;
			if($('.becipe-fn-wrapper').length){
				svg = $('.becipe-fn-wrapper').data('like-url');
			}
			var ajaxRunningForLike = false;
			$('.becipe_fn_like').off().on('click', function(e) {
				e.preventDefault();

				var likeLink 		= $(this),
					ID 				= $(this).data('id'),
					likeAction,addAction;
				
				likeLink 			= $('.becipe_fn_like[data-id="'+ID+'"]');

				if(ajaxRunningForLike === true) {return false;}
				
				if(likeLink.hasClass('liked')){
					likeAction 		= 'liked';
					addAction		= 'not-rated';
				}else{
					likeAction 		= 'not-rated';
					addAction		= 'liked';
				}
				ajaxRunningForLike 	= true;
				
				var requestData 	= {
					action: 'becipe_fn_like', 
					ID: ID,
					likeAction: likeAction
				};
				
				$.ajax({
					type: 'POST',
					url: fn_ajax_object.fn_ajax_url,
					cache: false,
					data: requestData,
					success: function(data) {
						var fnQueriedObj 	= $.parseJSON(data); //get the data object
						likeLink.removeClass('animate ' + likeAction).addClass(addAction);
						likeLink.find('.becipe_w_fn_svg').remove();
						likeLink.find('.becipe_fn_like_count').before('<img src="'+fnQueriedObj.svg+'" class="becipe_w_fn_svg" alt="" />');
						FrenifyBecipe.ImgToSVG();
						likeLink.find('.count').html(fnQueriedObj.count);
						likeLink.find('.text').html(fnQueriedObj.like_text);
						likeLink.attr('title',fnQueriedObj.title);
						likeLink.addClass('animate');
						ajaxRunningForLike = false;
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
						console.log(MLHttpRequest);
						console.log(textStatus);
						console.log(errorThrown);
					}
				});	

				return false;
			});
		},
		
		featuredSlider: function(){
			$('.fn_cs_featured_posts_slider').each(function(){
				var element 	= $(this);
				var container 	= element.find('.swiper-container');
				var mySwiper 	= new Swiper (container, {
					loop: true,
					slidesPerView: 1,
					spaceBetween: 50,
					speed: 1000,
					loopAdditionalSlides: 0,
					autoplay: {
						delay: 70000,
					},
					on: {
						autoplayStop: function(){
							mySwiper.autoplay.start();
						},
						slideChange: function () {
							FrenifyBecipe.ImgToSVG();
							FrenifyBecipe.like();
						},
					},
					pagination: {
						el: '.fn_cs_swiper__progress',
						type: 'custom', // progressbar
						renderCustom: function (swiper,current,total) {
							// progress animation
							var scale,translateX;
							var progressDOM	= element.find('.fn_cs_swiper__progress');
							if(progressDOM.hasClass('fill')){
								translateX 	= '0px';
								scale		= parseInt((current/total)*100)/100;
							}else{
								scale 		= parseInt((1/total)*100)/100;
								translateX 	= (current-1) * parseInt((100/total)*100)/100 + 'px';
							}


							progressDOM.find('.all span').css({transform:'translate3d('+translateX+',0px,0px) scaleX('+scale+') scaleY(1)'});
							if(current<10){current = '0' + current;}
							if(total<10){total = '0' + total;}
							progressDOM.find('.current').html(current);
							progressDOM.find('.total').html(total);
						}
					},
				});
			});
			FrenifyBecipe.ImgToSVG();
		},
		
		allGalleryFunctions: function(){
			FrenifyBecipe.justifiedGallery();
			FrenifyBecipe.galleryMasonry();
			FrenifyBecipe.BgImg();
			FrenifyBecipe.gallerySlider();
		},
		
		gallerySlider: function(){
			$('.fn_cs_gallery_slider .inner').each(function(){
				var element 	= $(this);
				var container 	= element.find('.swiper-container');
				var mySwiper 	= new Swiper (container, {
					loop: true,
					slidesPerView: 1,
					spaceBetween: 100,
					speed: 800,
//					loopAdditionalSlides: 50,
					autoplay: {
						delay: 8000,
					},
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev',
				  	},
					on: {
						init: function(){
							element.closest('.fn_cs_gallery_slider').addClass('ready');
						},
						autoplayStop: function(){
							mySwiper.autoplay.start();
						},
				  	},
					pagination: {
						el: '.fn_cs_swiper_progress',
						type: 'custom', // progressbar
						renderCustom: function (swiper,current,total) {
							
							// progress animation
							var scale,translateX;
							var progressDOM	= container.find('.fn_cs_swiper_progress');
							if(progressDOM.hasClass('fill')){
								translateX 	= '0px';
								scale		= parseInt((current/total)*100)/100;
							}else{
								scale 		= parseInt((1/total)*100)/100;
								translateX 	= (current-1) * parseInt((100/total)*100)/100 + 'px';
							}
							
							
							progressDOM.find('.all span').css({transform:'translate3d('+translateX+',0px,0px) scaleX('+scale+') scaleY(1)'});
							if(current<10){current = '0' + current;}
							if(total<10){total = '0' + total;}
							progressDOM.find('.current').html(current);
							progressDOM.find('.total').html(total);
						}
				  	}
			  	});
			});
			FrenifyBecipe.BgImg();
		},
		
		galleryMasonry: function(){
			FrenifyBecipe.lightGallery();
			FrenifyBecipe.isotopeFunction();
		},
		
		justifiedGallery: function(){
			FrenifyBecipe.lightGallery();
			var justified = $(".fn_cs_gallery_justified");
			justified.each(function(){
				var element 	= $(this);
				var height		= parseInt(element.attr('data-height'));
				var gutter		= parseInt(element.attr('data-gutter'));
				if(!height || height === 0){height = 400;}
				if(!gutter || gutter === 0){gutter = 10;}
				if($().justifiedGallery){
					element.justifiedGallery({
						rowHeight : height,
						lastRow : 'nojustify',
						margins : gutter,
						refreshTime: 500,
						refreshSensitivity: 0,
						maxRowHeight: null,
						border: 0,
						captions: false,
						randomize: false
					});
				}
			});
		},
		
		postsSlider: function(){
			FrenifyBecipe.BgImg();
			$('.fn_cs_posts_slider').each(function(){
				var element 	= $(this);
				var container 	= element.find('.swiper-container');
				var mySwiper 	= new Swiper (container, {
					loop: true,
//					effect: 'fade',
					slidesPerView: 1,
					spaceBetween: 0,
					speed: 1600,
					loopAdditionalSlides: 20,
					hashNavigation: {
						watchState: true,
					},
					pagination: {
						el: '.fn_cs_swiper_number_progress',
						type: 'custom', // progressbar
						renderCustom: function (swiper,current,total) {
							var progressDOM	= container.find('.fn_cs_swiper_number_progress');
							progressDOM.find('.progress_wrap').removeClass('active');
							progressDOM.find('.progress_wrap').eq(current-1).addClass('active');
						}
					},
					autoplay: {
						delay: 7000,
						disableOnInteraction: false
					},
				});
			});
		},
		
		
		
		
		blogGroup: function(){
			FrenifyBecipe.BgImg();
			FrenifyBecipe.ImgToSVG();
			FrenifyBecipe.isotopeFunction();
		},
		
		
		
		/* COMMMON FUNCTIONS */
		BgImg: function(){
			var div = $('*[data-fn-bg-img]');
			div.each(function(){
				var element = $(this);
				var attrBg	= element.attr('data-fn-bg-img');
				var dataBg	= element.data('fn-bg-img');
				if(typeof(attrBg) !== 'undefined'){
					element.addClass('frenify-ready');
					element.css({backgroundImage:'url('+dataBg+')'});
				}
			});
		},
		
		ImgToSVG: function(){
			
			$('img.becipe_fn_svg,img.becipe_w_fn_svg').each(function(){
				var $img 		= $(this);
				var imgClass	= $img.attr('class');
				var imgURL		= $img.attr('src');

				$.get(imgURL, function(data) {
					var $svg = $(data).find('svg');
					if(typeof imgClass !== 'undefined') {
						$svg = $svg.attr('class', imgClass+' replaced-svg');
					}
					$img.replaceWith($svg);

				}, 'xml');

			});
		},
		
		jarallaxEffect: function(){
			$('.jarallax').each(function(){
				var element			= $(this);
				var	customSpeed		= element.data('speed');

				if(customSpeed !== "undefined" && customSpeed !== ""){
					customSpeed = customSpeed;
				}else{
					customSpeed 	= 0.5;
				}
				element.jarallax({
					speed: customSpeed,
					automaticResize: true
				});
			});
		},
		isotopeFunction: function(){
			var masonry = $('.fn_cs_masonry');
			if($().isotope){
				masonry.each(function(){
					$(this).isotope({
					  itemSelector: '.fn_cs_masonry_in',
					  masonry: {

					  }
					});
				});
			}
		},
		
		lightGallery: function(){
			if($().lightGallery){
				// FIRST WE SHOULD DESTROY LIGHTBOX FOR NEW SET OF IMAGES

				var gallery = $('.fn_cs_lightgallery');

				gallery.each(function(){
					var element = $(this);
					element.lightGallery(); // binding
					if(element.length){element.data('lightGallery').destroy(true); }// destroying
					$(this).lightGallery({
						selector: ".lightbox",
						thumbnail: 1,
						loadYoutubeThumbnail: !1,
						loadVimeoThumbnail: !1,
						showThumbByDefault: !1,
						mode: "lg-fade",
						download:!1,
						getCaptionFromTitleOrAlt:!1,
					});
				});
			}	
		},
	};
	
	$( window ).on( 'elementor/frontend/init', FrenifyBecipe.init );
	
	
	$( window ).on('resize',function(){
		setTimeout(function(){
			FrenifyBecipe.isotopeFunction();
		},700);
	});
	$( window ).on('load',function(){
		FrenifyBecipe.isotopeFunction();
	});
	
})(jQuery, window.elementorFrontend);
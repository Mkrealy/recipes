/*
 * Copyright (c) 2020 Frenify
 * Author: Frenify
 * This file is made for CURRENT THEME
*/


/*

	@Author: Frenify
	@URL: http://themeforest.net/user/frenify


	This file contains the jquery functions for the actual theme, this
	is the file you need to edit to change the structure of the
	theme.

	This files contents are outlined below.

*/




(function ($){

	"use strict";
	
    var BecipeInit 		= {
		
		
		
		pageNumber: 1,
		
        init: function () {
			
			
			this.hamburgerOpener__Mobile();
			this.submenu__Mobile();
			this.openShare();
			// global functions
			this.imgToSVG();
			this.isotopeMasonry();
			this.dataFnBgImg();
			
			
			// работа с виджетами
			this.estimateWidgetHeight();
			
			this.runPlayer();
			this.newPlayer();
			
			
			
			// used functions go here
			this.header_recipe_carousel();
			this.right_bar_opener();	
			this.categoryHook();	
			this.right_bar_height();	
			this.portable_menu();
			this.headerHeight();
			this.toTopJumper();
			this.like();
			this.rating();
			this.recipe_video();
			this.search_opener();
			this.search_filter();
			this.fixedTotopScroll();
			this.prev_next_posts();
			this.widget__pages();
			this.widget__archives();
        },
		
		widget__archives: function(){
			$('.widget_archive li').each(function(){
				var e = $(this);
				var a = e.find('a').clone();
				$('body').append('<div class="frenify_hidden_item"></div>');
				$('.frenify_hidden_item').html(e.html());
				$('.frenify_hidden_item').find('a').remove();
				var suffix = $('.frenify_hidden_item').html().match(/\d+/); // 123456
				$('.frenify_hidden_item').remove();
				suffix = parseInt(suffix);
				if(isNaN(suffix)){
					return false;
				}
				suffix = '<span class="count">'+suffix+'</span>';
				e.html(a);
				e.append(suffix);
			});
		},
		
		prev_next_posts: function(){
			if($('.becipe_fn_siblings')){
				$(document).keyup(function(e) {
					if(e.key.toLowerCase() === 'p') {
						var a = $('.becipe_fn_siblings').find('a.previous_project_link');
						if(a.length){
							window.location.href = a.attr('href');
							return false;
						}
					}
					if(e.key.toLowerCase() === 'n') {
						var b = $('.becipe_fn_siblings').find('a.next_project_link');
						if(b.length){
							window.location.href = b.attr('href');
							return false;
						}
					}
				});
			}
		},
		
		fixedTotopScroll: function(){
			var totop			= $('a.becipe_fn_totop');
			var bottom_panel	= $('.becipe_fn_right_panel .panel_bottom');
			var height 			= parseInt(totop.find('input').val());
			if(totop.length){
				if($(window).scrollTop() > height){
					bottom_panel.addClass('scrolled');
				}else{
					bottom_panel.removeClass('scrolled');
				}
			}
		},
		
		header_recipe_carousel: function(){
			 $(".becipe_fn_header .recipe_content .owl-carousel").owlCarousel({
				 items: 1,
				 margin: 5,
				 loop: true,
				 nav: true,
				 dosts: false,
				 autoplay: true,
				 autoplayTimeout: 9000,
				 smartSpeed: 1500,
				 navText: ['<span class="fn-prev"></span>','<span class="fn-next"></span>']
			 });
		},
		
		search_opener: function(){
			var opener = $('.becipe_fn_right_panel .panel_search a');
			var time = null;
			opener.off().on('click',function(){
				opener.toggleClass('opened');
				$('.becipe_fn_recipe_search').toggleClass('opened');
				clearTimeout(time);
				time = setTimeout(function(){
					$('.becipe_fn_recipe_search input[type="text"]').focus();
				},400);
				return false;
			});
			$('.becipe_fn_recipe_search .search_closer').on('click',function(){
				opener.removeClass('opened');
				$('.becipe_fn_recipe_search').removeClass('opened');
			});
		},
		
		paginationFilter: function(){
			var self			= this;
			if($('.becipe_fn_search_recipes').length){
				var pagination 	= $('.becipe_fn_search_recipes .my_pagination a');
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
		
		search_filter: function(){
			var self						= this;
			if($('.becipe_fn_search_recipes').length){
				self.paginationFilter();
				var inputWrapper			= $('.becipe_fn_search_recipes .input_wrapper');
				
				
				var textFilter				= $('.becipe_fn_search_recipe_filter.text_filter');
				var textInput				= textFilter.find('input[type="text"]');
				
				var categoryFilter			= $('.becipe_fn_search_recipe_filter.category_filter');
				var categoryPopup			= categoryFilter.find('.filter_popup_list');
				var categoryInput			= categoryFilter.find('input[type="text"]');
				var categoryHidden			= categoryFilter.find('input[type="hidden"]');
				var categoryNewValue		= categoryFilter.find('.new_value');
				var categoryPlaceholder		= categoryInput.attr('data-placeholder');
				var categoryType			= categoryInput.attr('data-type');
				
				var difficultyFilter		= $('.becipe_fn_search_recipe_filter.difficulty_filter');
				var difficultyPopup			= difficultyFilter.find('.filter_popup_list');
				var difficultyInput			= difficultyFilter.find('input');
				var difficultyPlaceholder	= difficultyInput.attr('data-placeholder');
				var difficultyType			= difficultyInput.attr('data-type');
				
				var countryFilter			= $('.becipe_fn_search_recipe_filter.country_filter');
				var countryPopup			= countryFilter.find('.filter_popup_list');
				var countryInput			= countryFilter.find('input');
				var countryPlaceholder		= countryInput.attr('data-placeholder');
				var countryType				= countryInput.attr('data-type');
				
				inputWrapper.on('click',function(){
					$('.becipe_fn_search_recipes .filter_popup_list .item').show(); //added new
					$('.becipe_fn_search_recipes .filter_popup_list .no_records').remove(); //added new
				});
				
				
				/************************/
				/* Filter by Text */
				/************************/
				var oldValue = textInput.val();
				var myVar 	= null;
				textInput.off().on('keyup', function(){
					var element		= $(this);
					if(element.val() === oldValue){
						return false;
					}
					if(element.val() === ''){
						textFilter.removeClass('ready filtered opened');
					}else{
						textFilter.addClass('ready filtered opened');
					}
					oldValue = element.val();
					clearTimeout(myVar);
					myVar = setTimeout(function(){ 
						self.filterAjaxCall(element);
					}, 700);
					return false;
				}).focusout(function() {
					textFilter.removeClass('opened');
				}).focus(function() {
					textFilter.addClass('opened');
				});
				
				/* remove filter */
				textFilter.find('.icon').off().on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					var el	= $(this);
					
					textInput.val(''); // added new
					textFilter.removeClass('ready filtered opened');
					
					self.filterAjaxCall(el);
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
		getQueryVariable: function(url, variable) {
			var query = url.substring(1);
			var vars = query.split('&');
			for (var i=0; i<vars.length; i++) {
				var pair = vars[i].split('=');
				if (pair[0] === variable) {
					return pair[1];
				}
			}

			return false;
		},
		filterAjaxCall: function(element,filter_page){
			var pagination = true;
			if ( typeof filter_page === 'undefined') {
			  	filter_page			= 1;
			  	pagination			= false;
			}
			var parent = element.closest('.becipe_fn_search_recipes');
			if(parent.hasClass('loading')){
				return false;
			}
			var self					= this;
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
			var search_term 			= parent.find('.text_filter input').val();
			var requestData = {
				action: 'becipe_fn_search_filter',
				filter_category_array: filter_category_array,
				filter_difficulty: filter_difficulty,
				filter_country: filter_country,
				filter_page: filter_page,
				search_term: search_term,
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
					self.dataFnBgImg();
					self.imgToSVG();
					self.like();
					parent.removeClass('loading');
					
					var speed		= 800;
					if(!pagination){
						speed 		= 0;
					}
					var listItem 	= parent.find('.my_list ul > li');
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
							scrollTop: parent.offset().top
						}, speed);
					}
						
					self.paginationFilter();
				},
				error: function(xhr, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(xhr);
				}
			});
		},
		
		right_bar_opener: function(){
			var trigger = $('.becipe_fn_right_panel .panel_trigger, .becipe_fn_right_panel .extra_closer');
			trigger.on('click',function(){
				$('body').toggleClass('fn_opened');
			});
		},
		
		categoryHook: function(){
			var self = this;
			
			
			var list = $('.wp-block-archives li, .widget_becipe_custom_categories li, .widget_categories li, .widget_archive li');
			list.each(function(){
				var item = $(this);
				if(item.find('ul').length){
					item.addClass('has-child');
				}
			});
			
			
			var html = $('.becipe_fn_hidden.more_cats').html();
			var cats = $('.widget_categories,.widget_archive,.widget_becipe_custom_categories');
			if(cats.length){
				cats.each(function(){
					var element = $(this);
					var limit	= 4;
					element.append(html);
					var li = element.find('ul:not(.children) > li');
					if(li.length > limit){
						var h = 0;
						li.each(function(i,e){
							if(i < limit){
								h += $(e).outerHeight(true,true);
							}else{
								return false;
							}
						});
						element.find('ul:not(.children)').css({height: h + 'px'});
						element.find('.becipe_fn_more_categories .fn_count').html('('+(li.length-limit)+')');
					}else{
						element.addClass('all_active');
					}
				});
				self.categoryHookAction();
			}
		},
		
		categoryHookAction: function(){
			var self			= this;
			$('.becipe_fn_more_categories').find('a').off().on('click',function(){
				var e 			= $(this);
				var limit		= 4;
				var myLimit		= limit;
				var parent 		= e.closest('.widget_block');
				var li 			= parent.find('ul:not(.children) > li');
				var liHeight	= li.outerHeight(true,true);
				var h			= liHeight*limit;
				var liLength	= li.length;
				var speed		= (liLength-limit)*50;
				e.toggleClass('show');
				if(e.hasClass('show')){
					myLimit		= liLength;
					h			= liHeight*liLength;
					e.find('.text').html(e.data('less'));
					e.find('.fn_count').html('');
				}else{
					e.find('.text').html(e.data('more'));
					e.find('.fn_count').html('('+(liLength-limit)+')');
				}
				
				
				var H = 0;
				li.each(function(i,e){
					if(i < myLimit){
						H += $(e).outerHeight(true,true);
					}else{
						return false;
					}
				});
				
				speed = (speed > 300) ? speed : 300;
				speed = (speed < 1500) ? speed : 1500;
				parent.find('ul:not(.children)').animate({height:H},speed);
				
				setTimeout(function(){
					self.right_bar_height();
				},(speed+1));
				
				
				return false;
			});
		},
		
		recipe_video: function(){
			$('.becipe_fn_single_recipe .popup-youtube').each(function() { // the containers for all your galleries
				$(this).magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			});
		},
		
		rating: function(){
			var radio 	= $('.comments-rating input[type="radio"]');
			radio.on('click',function(){
				var el 	= $(this);
				var id	= el.attr('id');
				$('.comments-rating .fn_radio').removeClass('clicked');
				$('.comments-rating .'+id).addClass('clicked');
		 	}).on('mouseenter',function(){
				var el 	= $(this);
				var id	= el.attr('id');
				$('.comments-rating .fn_radio').removeClass('hovered');
				$('.comments-rating .'+id).addClass('hovered');
		 	}).on('mouseleave',function(){
				$('.comments-rating .fn_radio').removeClass('hovered');
		 	});
		},
		
		
		
		portable_menu: function(){
			var self				= this;
			var fixedsub 			= $('#becipe_fn_portable_menu');
			var moveBG 				= $('.becipe_fn_header .fn_bg');
			var li					= $('.becipe_fn_header ul.becipe_fn_main_nav > li');
			var leftpartW			= $('.becipe_fn_header').width();
			var rightpart			= $('.becipe_fn_pages, .becipe_fn_header .header_logo, .becipe_fn_header .header_recipe, .becipe_fn_right_panel');
			var adminBar 			= 0;
			if($('body').hasClass('admin-bar')){
				adminBar  			= $('#wpadminbar').height();
			}
			fixedsub.css({left:leftpartW});
			
			var fisrtWidth			= li.first().children('a').find('span').width();
			moveBG.width((fisrtWidth+30)+'px');

			li.on('mouseenter', function(){
				var parentLi 		= $(this);
				var subMenu			= parentLi.children('ul.sub-menu');
				var subMenuHtml 	= subMenu.html();
				var span			= parentLi.find('.link');
				var spanWidth		= span.width();
				moveBG.addClass('active');
				moveBG.width((spanWidth+30)+'px');
				if(subMenu.length){
					li.removeClass('hovered');
					parentLi.addClass('hovered').parent().addClass('hovered');
					fixedsub.removeClass('opened').children('ul').html('').html(subMenuHtml);
					fixedsub.addClass('opened');
				}else{
					fixedsub.removeClass('opened');
					li.removeClass('hovered').parent().removeClass('hovered');
				}
				var topOffSet 		= parentLi.offset().top;
				var menuBar			= $('.becipe_fn_header');
				var menuBarOffSet	= menuBar.offset().top;
				var fromTop			= topOffSet-menuBarOffSet+adminBar;
				leftpartW 			= menuBar.width();
				
				moveBG.css({top:parentLi.index()*parentLi.outerHeight(true,true)+'px'});

				fixedsub.css({top:fromTop,left:leftpartW});
				
				self.portable_extra(rightpart,fixedsub,li,moveBG);
			});
			self.portable_extra(rightpart,fixedsub,li,moveBG);
		},
		
		portable_extra: function(rightpart,fixedsub,li,moveBG){
			rightpart.on('mouseenter', function(){
				fixedsub.removeClass('opened');
				li.removeClass('hovered').parent().removeClass('hovered');
				moveBG.removeClass('active');
			});
			$('html.elementor-html').on('mouseleave',function(){
				fixedsub.removeClass('opened');
				li.removeClass('hovered').parent().removeClass('hovered');
				moveBG.removeClass('active');
			});
		},
		
		headerHeight: function(){
			var H		= $(window).height(), recipeH = 0, adminH = 0,
				logoH	= $('.becipe_fn_header .header_logo').outerHeight(),
				recipe	= $('.becipe_fn_header .header_recipe'),
				nav		= $('.becipe_fn_header .header_nav');
			if(recipe.length){
				$(".becipe_fn_header .recipe_content .img_in img").one("load", function() {
					recipeH	= recipe.outerHeight();
					if($('#wpadminbar').length){
						adminH = $('#wpadminbar').height();
					}
					var padding = parseInt(nav.css('padding-top')) + parseInt(nav.css('padding-bottom'));
					nav.height((H-adminH-recipeH-logoH-padding) + 'px');
					if($().niceScroll){
						nav.niceScroll({
							touchbehavior: false,
							cursorwidth: 0,
							autohidemode: true,
							cursorborder: "0px solid #eee"
						});
					}
				}).each(function() {
				  if(this.complete) {
					  $(this).load(); // For jQuery < 3.0 
					  // $(this).trigger('load'); // For jQuery >= 3.0 
				  }
				});
			}else{
				if($('#wpadminbar').length){
					adminH = $('#wpadminbar').height();
				}
				var padding = parseInt(nav.css('padding-top')) + parseInt(nav.css('padding-bottom'));
				nav.height((H-adminH-recipeH-logoH-padding) + 'px');
				if($().niceScroll){
					nav.niceScroll({
						touchbehavior: false,
						cursorwidth: 0,
						autohidemode: true,
						cursorborder: "0px solid #eee"
					});
				}
			}
				
				
		},
		
		right_bar_height: function(){
			var H		= $(window).height(),
				bar		= $('.becipe_fn_popup_sidebar'),
				inner	= bar.find('.sidebar_wrapper');
			bar.height(H + 'px');
			if($().niceScroll){
				inner.height('100%').niceScroll({
					touchbehavior: false,
					cursorwidth: 0,
					autohidemode: true,
					cursorborder: "0px solid #e5e5e5"
				});
			}
		},
		
		
		toTopJumper: function(){
			var totop		= $('a.becipe_fn_totop');
			if(totop.length){
				totop.on('click', function(e) {
					e.preventDefault();		
					$("html, body").animate(
						{ scrollTop: 0 }, 'slow');
					return false;
				});
			}
		},
		
		
		
		runPlayer: function(){
			var parent		= $('.becipe_fn_main_audio');
			var audioVideo 	= parent.find('audio,video');
			audioVideo.each(function(){
				var element = $(this);
				element.mediaelementplayer({
					// Do not forget to put a final slash (/)
					pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
					// this will allow the CDN to use Flash without restrictions
					// (by default, this is set as `sameDomain`)
					shimScriptAccess: 'always',
					success: function(mediaElement, domObject) {
						mediaElement.addEventListener('play', function() {
							parent.removeClass('fn_pause').addClass('fn_play');
						}, false);
						mediaElement.addEventListener('pause', function() {
							parent.removeClass('fn_play').addClass('fn_pause');
						}, false);
					},
				});
			});
		},
		
		newPlayer: function(){
			var parent		= $('.becipe_fn_main_audio');
			var closer 	  	= parent.find('.fn_closer');
			var audioVideo 	= parent.find('audio,video');
			var icon 		= parent.find('.podcast_icon');
			var audios		= $('.becipe_fn_audio_button');
			var playButton	= $('.becipe_fn_audio_button a');
			var self		= this;
			audioVideo.each(function(){
				var element = $(this);
				element.mediaelementplayer({
					// Do not forget to put a final slash (/)
					pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
					// this will allow the CDN to use Flash without restrictions
					// (by default, this is set as `sameDomain`)
					shimScriptAccess: 'always',
					success: function(mediaElement, domObject) {
						mediaElement.addEventListener('pause', function() {
							parent.removeClass('fn_play').addClass('fn_pause');
						}, false);
						mediaElement.addEventListener('play', function() {
							parent.removeClass('fn_pause').addClass('fn_play');
						}, false);
					},
				});
			});
			closer.off().on('click', function(){
				if(parent.hasClass('closed')){
					parent.removeClass('closed');
					closer.find('span').html(closer.attr('data-close-text'));
				}else{
					parent.addClass('closed');
					closer.find('span').html(closer.attr('data-open-text'));
				}
			});
			icon.off().on('click', function(){
				if(parent.find('audio,video').length){
					if(parent.hasClass('fn_pause')){
						parent.removeClass('fn_pause').addClass('fn_play').find('audio,video')[0].play();
					}else{
						parent.removeClass('fn_play').addClass('fn_pause').find('audio,video')[0].pause();
					}
				}
			});
			playButton.off().on('click',function(){
				var button		= $(this);
				var wrapper		= button.parent();
				if(!wrapper.hasClass('active')){
					audios.removeClass('active fn_play fn_pause');
					wrapper.addClass('active');
				}
				if(wrapper.hasClass('fn_pause')){
					wrapper.removeClass('fn_pause').addClass('fn_play');
					parent.find('audio,video')[0].play();
				}else if(wrapper.hasClass('fn_play')){
					wrapper.removeClass('fn_play').addClass('fn_pause');
					parent.find('audio,video')[0].pause();
				}else{
					wrapper.addClass('fn_play');
					var src			= wrapper.attr('data-mp3');
					var audio	 	= '<audio controls><source src="'+src+'" type="audio/mpeg"></audio>';
					$('.becipe_fn_main_audio .audio_player').html(audio);
					self.runPlayer();
					setTimeout(function(){
						parent.find('audio,video')[0].play();
						parent.removeClass('fn_pause').addClass('fn_play');
						parent.removeClass('closed');
						closer.find('span').html(closer.attr('data-close-text'));
						self.playerSpace();
					},50);
				}
				
				return false;
			});
		},
		
		
		
		openShare: function(){
			var allSharebox = $('.becipe_fn_sharebox');
			var btn 		= $('.becipe_fn_sharebox .hover_wrapper');
			btn.off().on('click',function(e){
				var element = $(this),
					parent	= element.closest('.becipe_fn_sharebox');
				e.stopPropagation();
				allSharebox.removeClass('opened');
				parent.addClass('opened');
				parent.find('a').each(function(){
					var eachA 	= $(this),
						href 	= eachA.attr('data-href');
					eachA.attr('href',href);
				});
			});
			allSharebox.on('click',function(e){
				e.stopPropagation();
			});
			$(window).on('click',function(){
				allSharebox.removeClass('opened');
				allSharebox.find('a').each(function(){
					$(this).removeAttr('href');
				});
			});
		},
		
		widget__pages: function(){
			var nav 						= $('.widget_pages ul');
			nav.each(function(){
				$(this).find('a').off().on('click', function(e){
					var element 			= $(this);
					var parentItem			= element.parent('li');
					var parentItems			= element.parents('li');
					var parentUls			= parentItem.parents('ul.children');
					var subMenu				= element.next();
					var allSubMenusParents 	= nav.find('li');

					allSubMenusParents.removeClass('opened');

					if(subMenu.length){
						e.preventDefault();

						if(!(subMenu.parent('li').hasClass('active'))){
							if(!(parentItems.hasClass('opened'))){parentItems.addClass('opened');}

							allSubMenusParents.each(function(){
								var el = $(this);
								if(!el.hasClass('opened')){el.find('ul.children').slideUp();}
							});

							allSubMenusParents.removeClass('active');
							parentUls.parent('li').addClass('active');
							subMenu.parent('li').addClass('active');
							subMenu.slideDown();


						}else{
							subMenu.parent('li').removeClass('active');
							subMenu.slideUp();
						}
						return false;
					}
				});
			});
		},
		
		submenu__Mobile: function(){
			var nav 						= $('ul.vert_menu_list, .widget_nav_menu ul.menu');
			var mobileAutoCollapse			= $('.becipe-fn-wrapper').data('mobile-autocollapse');
			nav.each(function(){
				$(this).find('a').on('click', function(e){
					var element 			= $(this);
					var parentItem			= element.parent('li');
					var parentItems			= element.parents('li');
					var parentUls			= parentItem.parents('ul.sub-menu');
					var subMenu				= element.next();
					var allSubMenusParents 	= nav.find('li');

					allSubMenusParents.removeClass('opened');

					if(subMenu.length){
						e.preventDefault();

						if(!(subMenu.parent('li').hasClass('active'))){
							if(!(parentItems.hasClass('opened'))){parentItems.addClass('opened');}

							allSubMenusParents.each(function(){
								var el = $(this);
								if(!el.hasClass('opened')){el.find('ul.sub-menu').slideUp();}
							});

							allSubMenusParents.removeClass('active');
							parentUls.parent('li').addClass('active');
							subMenu.parent('li').addClass('active');
							subMenu.slideDown();


						}else{
							subMenu.parent('li').removeClass('active');
							subMenu.slideUp();
						}
						return false;
					}
					if(mobileAutoCollapse === 'enable'){
						if(nav.parent().parent().hasClass('opened')){
							nav.parent().parent().removeClass('opened').slideUp();
							$('.becipe_fn_mobilemenu_wrap .hamburger').removeClass('is-active');
						}
					}
				});
			});
		},
		
		hamburgerOpener__Mobile: function(){
			var hamburger		= $('.becipe_fn_mobilemenu_wrap .hamburger');
			hamburger.on('click',function(){
				var element 	= $(this);
				var menupart	= $('.becipe_fn_mobilemenu_wrap .mobilemenu');
				if(element.hasClass('is-active')){
					element.removeClass('is-active');
					menupart.removeClass('opened');
					menupart.slideUp(500);
				}else{
					element.addClass('is-active');
					menupart.addClass('opened');
					menupart.slideDown(500);
				}return false;
			});
		},
		
		like: function(){
			var svg;
			var self	= this;
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
						self.imgToSVG();
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
		
		
		imgToSVG: function(){
			$('img.becipe_fn_svg,img.becipe_w_fn_svg').each(function(){
				var img 		= $(this);
				var imgClass	= img.attr('class');
				var imgURL		= img.attr('src');

				$.get(imgURL, function(data) {
					var svg 	= $(data).find('svg');
					if(typeof imgClass !== 'undefined') {
						svg 	= svg.attr('class', imgClass+' replaced-svg');
					}
					img.replaceWith(svg);

				}, 'xml');

			});	
		},
		
		
		dataFnBgImg: function(){
			var bgImage 	= $('*[data-fn-bg-img]');
			bgImage.each(function(){
				var element = $(this);
				var attrBg	= element.attr('data-fn-bg-img');
				var bgImg	= element.data('fn-bg-img');
				if(typeof(attrBg) !== 'undefined'){
					element.addClass('frenify-ready').css({backgroundImage:'url('+bgImg+')'});
				}
			});
		},
		
		isotopeMasonry: function(){
			var masonry = $('.becipe_fn_masonry');
			if($().isotope){
				masonry.each(function(){
					$(this).isotope({
						itemSelector: '.becipe_fn_masonry_in',
						masonry: {
							columnWidth: '.grid-sizer'
						}
					});
				});
			}
		},
		
		estimateWidgetHeight: function(){
			var est 	= $('.becipe_fn_widget_estimate');
			est.each(function(){
				var el 	= $(this);
				var h1 	= el.find('.helper1');
				var h2 	= el.find('.helper2');
				var h3 	= el.find('.helper3');
				var h4 	= el.find('.helper4');
				var h5 	= el.find('.helper5');
				var h6 	= el.find('.helper6');
				var eW 	= el.outerWidth();
				var w1 	= Math.floor((eW * 80) / 300);
				var w2 	= eW-w1;
				var e1 	= Math.floor((w1 * 55) / 80);
				h1.css({borderLeftWidth:	w1+'px', borderTopWidth: e1+'px'});
				h2.css({borderRightWidth:	w2+'px', borderTopWidth: e1+'px'});
				h3.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h4.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
				h5.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h6.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
			});
		},
    };
	
	
	
	// ready functions
	$(document).ready(function(){
		BecipeInit.init();
	});
	
	// resize functions
	$(window).on('resize',function(e){
		e.preventDefault();
		BecipeInit.right_bar_height();
		BecipeInit.estimateWidgetHeight();
		BecipeInit.headerHeight();
	});
	
	// scroll functions
	$(window).on('scroll', function(e) {
		e.preventDefault();
		BecipeInit.fixedTotopScroll();
    });
	
	// load functions
	$(window).on('load', function(e) {
		e.preventDefault();
		BecipeInit.isotopeMasonry();
		setTimeout(function(){
			BecipeInit.isotopeMasonry();
		},100);
	});
	
})(jQuery);
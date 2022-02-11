jQuery( function($) {

    /*
     * Strips one query argument from a given URL string
     *
     */
    function remove_query_arg( key, sourceURL ) {

        var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";

        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }

            rtn = rtn + "?" + params_arr.join("&");

        }

        if(rtn.split("?")[1] == "") {
            rtn = rtn.split("?")[0];
        }

        return rtn;
    }


    /*
     * Adds an argument name, value pair to a given URL string
     *
     */
    function add_query_arg( key, value, sourceURL ) {

        return sourceURL + '&' + key + '=' + value;

    }
    

    /******************************************************************/
    /* Init chosen
    /******************************************************************/
    if( $.fn.chosen != undefined ) {

        $('.oih-chosen').chosen();

    }

	/******************************************************************/
	/* Init color picker
	/******************************************************************/
	$('.oih-colorpicker').wpColorPicker();


    /******************************************************************/
    /* Init date picker
    /******************************************************************/
    $('.oih-datepicker').datepicker( {dateFormat: 'yy-mm-dd'} );


    /******************************************************************/
    /* Init slider
    /******************************************************************/
    if( $.fn.slider != undefined ) {

        $('.oih-range').each( function() {
            $(this).slider({
                min   : ( typeof $(this).data('min') != 'undefined' ? $(this).data('min') : 0 ),
                max   : ( typeof $(this).data('max') != 'undefined' ? $(this).data('max') : 100 ),
                value : ( typeof $(this).data('value') != 'undefined' ? $(this).data('value') : 0 ),
                step  : 1,
                range : "min",
                orientation: "horizontal",
                slide  : oih_update_slider_input_value
            });
        });

        function oih_update_slider_input_value( event, ui ) {
            $(ui.handle).parent().siblings('input').val( ui.value );
        }

        $(document).on( 'keyup', '.oih-settings-field-range input', function() {

            var value = $(this).val();
            
            if( value == '' )
                value = $(this).siblings('.oih-range').slider( 'option', 'min' );

            $(this).siblings('.oih-range').slider( 'value', parseInt( $(this).val() ) );

        });

    }


	/******************************************************************/
	/* Tab Navigation
	/******************************************************************/
	$('.oih-nav-tab').on( 'click', function(e) {
		e.preventDefault();

		// Nav Tab activation
		$('.oih-nav-tab').removeClass('oih-active').removeClass('nav-tab-active');
		$(this).addClass('oih-active').addClass('nav-tab-active');

		// Show tab
		$('.oih-tab').removeClass('oih-active');

		var nav_tab = $(this).attr('data-tab');
		$('.oih-tab[data-tab="' + nav_tab + '"]').addClass('oih-active');
		$('input[name=active_tab]').val( nav_tab );

        // Change http referrer
        $_wp_http_referer = $('input[name=_wp_http_referer]');

        var _wp_http_referer = $_wp_http_referer.val();
        _wp_http_referer = remove_query_arg( 'tab', _wp_http_referer );
        $_wp_http_referer.val( add_query_arg( 'tab', $(this).attr('data-tab'), _wp_http_referer ) );
		
	});


    /******************************************************************/
    /* Sub Tab Navigation
    /******************************************************************/
    $('.oih-nav-sub-tab').on( 'click', function(e) {
        e.preventDefault();

        // Nav sub tab activation
        $('.oih-nav-sub-tab').removeClass('oih-active').removeClass('current');
        $(this).addClass('oih-active').addClass('current');

        // Show sub tab
        $('.oih-sub-tab').removeClass('oih-active');

        var nav_sub_tab = $(this).attr('data-sub-tab');
        $('.oih-sub-tab[data-sub-tab="' + nav_sub_tab + '"]').addClass('oih-active');
        $('input[name=active_sub_tab]').val( nav_sub_tab );

        // Change http referrer
        $_wp_http_referer = $('input[name=_wp_http_referer]');

        var _wp_http_referer = $_wp_http_referer.val();
        _wp_http_referer = remove_query_arg( 'sub-tab', _wp_http_referer );
        $_wp_http_referer.val( add_query_arg( 'sub-tab', $(this).attr('data-sub-tab'), _wp_http_referer ) );
        
    });


	/******************************************************************/
    /* Show and hide back-end settings tool-tips
	/******************************************************************/
	$(document).on( 'mouseenter', '.oih-settings-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.oih-settings-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 0).css('visibility', 'hidden');
	});

	$(document).on( 'mouseenter', '.oih-settings-field-tooltip-wrapper.oih-has-link', function() {
		$(this).find('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.oih-settings-field-tooltip-wrapper.oih-has-link', function() {
		$(this).find('div').css('opacity', 0).css('visibility', 'hidden');
	});


	/******************************************************************/
    /* Disable the uninstaller submit button until "REMOVE" is written in the input box
	/******************************************************************/
    $(document).on( 'keyup', '#oih-uninstall-confirmation', function(e) {
        
        e.preventDefault();
        
        $('#oih-uninstall-plugin-submit').prop('disabled', true);
        
        if( $(this).val() === 'REMOVE' )
            $('#oih-uninstall-plugin-submit').prop('disabled', false);

    });


    /******************************************************************/
    /* Enable the Continue button when selecting an opt-in type
	/******************************************************************/
	$('input[type=radio][name=opt_in_type]').click( function() {

		$('#oih-select-new-opt-in-type').attr( 'disabled', false );
		
	});

    /******************************************************************/
    /* Show the spinner next to the Continue button from the select
    /* opt-in type box
    /******************************************************************/
    $('#oih-select-new-opt-in-type').click( function() {
        $(this).siblings('.spinner').css( 'visibility', 'visible' ).css( 'opacity', 1 );
    });


    /******************************************************************/
    /* Settings Field: Image
    /******************************************************************/
    var frame;

    $(document).on('click', '.oih-settings-field-image-button-select, .oih-settings-field-image-button-replace', function(e) {
        
        e.preventDefault();

        $button      = $(this);

        $wrapper     = $button.closest('.oih-settings-field-image');
        $thumbnail   = $wrapper.find('img');
        $value_input = $wrapper.find('input[type=hidden]');

        // If the media frame already exists, reopen it.
        if ( frame ) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Use Image'
            },
            multiple: false
        });


        frame.on( 'select', function() {
      
            var attachment = frame.state().get('selection').first().toJSON();

            if( typeof attachment.sizes.medium != 'undefined' )
                attachment_url = attachment.sizes.medium.url;
            else
                attachment_url = attachment.url;
            
            $thumbnail.attr( 'src', attachment_url );
            $thumbnail.parent().show();
            $value_input.val( attachment.id ).trigger('change');

            $wrapper.find('.oih-settings-field-image-button-select').hide();

        });


        frame.open();

    });

    $('.oih-settings-field-image-button-remove').on('click', function(e) {

        e.preventDefault();

        if( ! confirm( "Are you sure you want to remove this image?" ) )
            return false;

        $button      = $(this);

        $wrapper     = $button.closest('.oih-settings-field-image');
        $thumbnail   = $wrapper.find('img');
        $value_input = $wrapper.find('input[type=hidden]');

        $thumbnail.attr( 'src', '' );
        $thumbnail.parent().hide();
        $value_input.val( '' ).trigger('change');

        $wrapper.find('.oih-settings-field-image-button-select').show();

    });


    /******************************************************************/
    /* Display settings fields based on checkbox field conditional value
    /******************************************************************/

    // Handle on page load
    $('.oih-settings-field[data-conditional]').each( function() {

        // Handle checkboxes, because they are special
        if( $( '.oih-settings-field input[type="checkbox"][name="' + $(this).data('conditional') + '"]' ).is(':checked') )
            $(this).show();

        // Handle rest of the fields if conditional value is set
        if( $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]' ).attr('type') != 'checkbox' ) {

            if( typeof $(this).data('conditional-value') != 'undefined' ) {

                // Handle radios
                if( $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]' ).attr('type') == 'radio' ) {

                    if( $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]:checked' ).val() == $(this).data('conditional-value') )
                        $(this).show();

                // Handle rest of the fields
                } else {

                    if( $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]' ).val() == $(this).data('conditional-value') )
                        $(this).show();

                }

            } else {

                if( $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]' ).val() != 0 || $( '.oih-settings-field [name="' + $(this).data('conditional') + '"]' ).val() != '' )
                    $(this).show();

            }

        }

    });

    // Handle on field value change
    $(document).on( 'change', '.oih-settings-field *', function() {

        $this = $(this);

        // Handle checkboxes
        if( $this.attr('type') == 'checkbox' ) {

            if( $this.is(':checked') )
                $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]').show();
            else
                $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]').hide();            

        // Handle rest of the fields
        } else {

            $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]' ).each( function() {

                if( typeof $(this).data('conditional-value') == 'undefined' ) {

                    if( $this.val() != '' )
                        $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]').show();
                    else
                        $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]').hide();

                } else {

                    $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"]:not([data-conditional-value="' + $this.val() + '"])').hide();

                    $('.oih-settings-field[data-conditional="' + $this.attr('name') + '"][data-conditional-value="' + $this.val() + '"]').show();

                }

            });

        }
        
    });


    /******************************************************************/
    /* Disable a buttons
    /******************************************************************/
    $('a.oih-button-primary.disabled').click( function(e) {
        e.preventDefault();
    });


    /******************************************************************/
    /* Opt-in Schedules
    /******************************************************************/

    /**
     * Modifies the details panel for the given schedule
     *
     */
    function oih_update_schedule_details_panel( $schedule ) {

        var schedule_type      = $schedule.find( '[name="' + $schedule.data('name') + '[type]' + '"] option:selected' ).val();
        var schedule_type_name = $schedule.find( '[name="' + $schedule.data('name') + '[type]' + '"] option:selected' ).html();

        var schedule_value = '';

        // Handle Date Range
        if( schedule_type == 'date_range' ) {

            var $datepickers = $schedule.find('.oih-datepicker');

            schedule_value = $datepickers.first().val() + ' - ' + $datepickers.last().val();

        }

        // Handle Recurring Weekly
        if( schedule_type == 'recurring_weekly' ) {

            var $selected_options = $schedule.find( '[name="' + $schedule.data('name') + '[weekdays][]' + '"] option:selected' );

            $selected_options.each( function() {
                schedule_value += $(this).html() + ', ';
            });

            schedule_value = schedule_value.slice(0,-2);

        }

        // Handle Recurring Monthly
        if( schedule_type == 'recurring_monthly' ) {

            var $selected_options = $schedule.find( '[name="' + $schedule.data('name') + '[monthdays][]' + '"] option:selected' );

            $selected_options.each( function() {
                schedule_value += $(this).html() + ', ';
            });

            schedule_value = schedule_value.slice(0,-2);

        }

        if( schedule_value == '' )
            schedule_value = '-';

        $schedule.find('.oih-settings-field-schedule-details-type').html( schedule_type_name );
        $schedule.find('.oih-settings-field-schedule-details-value').html( schedule_value );

    }


    /**
     * Shows/hides the No Schedules placeholder if no schedules are found
     *
     */
    function oih_show_hide_no_schedules_placeholder() {

        if( $('.oih-settings-field-schedule').length > 0 )
            $('.oih-no-schedules').hide();
        else
            $('.oih-no-schedules').show();

    }


    /**
     * Open and close the opt-in schedule edit panel
     *
     */
    $(document).on( 'click', '.oih-edit-schedule', function(e) {

        e.preventDefault();

        $(this).toggleClass('active');
        $(this).closest('.oih-settings-field-schedule').find('.oih-settings-field-schedule-fields').slideToggle( 250 );

    });

    /**
     * Update the schedule details on pageload with data from the
     * values of the schedule fields
     *
     */
    $(document).ready( function() {

        oih_show_hide_no_schedules_placeholder();

        $('.oih-settings-field-schedule').each( function() {
            oih_update_schedule_details_panel( $(this) );
        });

    });

    /**
     * Update the schedule details when changing the values from the schedule fields
     *
     */
    $(document).on( 'change', '.oih-settings-field-schedule select, .oih-settings-field-schedule input', function() {

        oih_update_schedule_details_panel( $(this).closest( '.oih-settings-field-schedule' ) );

    });

    /**
     * Handle "Add New Schedule" button click
     *  
     */
    $(document).on( 'click', '#oih-add-new-schedule', function(e) {

        e.preventDefault();

        // Prepare post data
        var data = {
            action : 'oih_add_new_schedule',
            id     : ( $('.oih-settings-field-schedule').length > 0 ? parseInt( $('.oih-settings-field-schedule').last().data('id') ) + 1 : 1 )
        }

        var $button = $(this);

        // Disable the button and show the spinner
        $button.siblings('.spinner').css( 'visibility', 'visible' );
        $button.attr( 'disabled', true );

        $.post( ajaxurl, data, function( response ) {

            // Enable again the button and hide the spinner
            $button.siblings('.spinner').css( 'visibility', 'hidden' );
            $button.attr( 'disabled', false ).blur();

            // Add the HTML of the new schedule before the button
            $('#oih-add-new-schedule').parent().before( response );

            $('.oih-settings-field-schedule').last().find('.oih-chosen').chosen();
            $('.oih-settings-field-schedule').last().find('.oih-datepicker').datepicker( {dateFormat: 'yy-mm-dd'} );

            $('.oih-settings-field-schedule').last().find('.oih-settings-field-select select').trigger('change');

            oih_show_hide_no_schedules_placeholder();

            setTimeout( function() {
                $('.oih-settings-field-schedule').last().find('.oih-edit-schedule').trigger('click');
            }, 300 )

        });

    });

    /**
     * Handle "remove" schedule
     *
     */
    $(document).on( 'click', '.oih-settings-field-schedule .oih-trash', function(e) {

        e.preventDefault();

        if( ! confirm( 'Are you sure you want to remove this schedule?' ) )
            return false;

        $(this).closest('.oih-settings-field-schedule').fadeOut( 400, function() {
            $(this).remove();
            oih_show_hide_no_schedules_placeholder();
        });

    });


    /******************************************************************/
    /* List Linking Table
    /******************************************************************/

    /*
    // Adding a table row
    $(document).on( 'click', '.oih-table-list-linking .button-secondary', function(e) {

        e.preventDefault();

        $this = $(this);

        $this.blur();

        $table = $this.closest('table');

        $new_row = $table.find('tr.oih-placeholder').clone();
        $new_row.removeClass('oih-placeholder');

        $this.closest('tr').before( $new_row.attr( 'data-index', $table.find('tr[data-index]').last().data('index') + 1 ) );

    });

    // Removing a table row
    $(document).on( 'click', '.oih-table-list-linking tr .oih-remove', function() {

        $table = $(this).closest('table');

        $(this).closest('tr').remove();

        $table.find('select').first().trigger('change');

    });

    // Updating value for the hidden field
    $(document).on( 'change', '.oih-table-list-linking select', function() {

        var values = [];

        $table = $(this).closest('table');

        $table.find( 'tr[data-index]' ).each( function( index ) {

            var first = $(this).find('select').first().val();
            var last  = $(this).find('select').last().val();

            var value = {};

            value[first]  = last;
            values[index] = value;

        });

        values = ( values.length != 0 ? JSON.stringify( values ) : '' );

        $table.siblings('input[name=' + $table.data('name') + ']').val( values );

    });
    */


    /******************************************************************/
    /* Deactivation Form
    /******************************************************************/
    $('select[name=email_provider_account_id]').change( function() {

        $select = $(this);

        // Remove all related fields
        $('div[data-conditional=email_provider_account_id]').remove();
        
        if( $select.val() == 0 )
            return;

        // Disable select and show spinner
        $select.blur().attr( 'disabled', true );
        $select.siblings('.spinner').css( 'visibility', 'visible' );

        // Set-up the data
        data = {
            action : 'oih_opt_in_settings_email_provider_account_change',
            email_provider_account_id : $select.val()
        }

        // Get email provider account fields
        $.post( ajaxurl, data, function( response ) {

            response = JSON.parse( response );

            // Enable select and hide spinner
            $select.attr( 'disabled', false );
            $select.siblings('.spinner').css( 'visibility', 'hidden' );

            // If all good add fields and show them
            if( response.success == 1 ) {

                $select.closest('.oih-settings-field').after( response.data );
                $('[data-conditional=email_provider_account_id][data-conditional-value=' + data.email_provider_account_id + ']').show();

            }

        });

    });


    /******************************************************************/
    /* Statistics Page
    /******************************************************************/
    if( typeof $.fn.daterangepicker != 'undefined' ) {

        /**
         * Refreshes the entire statistics page with new data
         *
         */
        function refresh_statistics_panels( start_date, end_date, optins ) {

            $daterange.data( 'selected_start_date', start_date );
            $daterange.data( 'selected_end_date', end_date );

            // Add loading spinners
            $('.oih-statistics-main-interaction-value').before( '<div class="oih-overlay"><div class="spinner"></div></div>' );
            $('.oih-wp-list-table').before( '<div class="oih-overlay"><div class="spinner"></div></div>' );
            $('#oih-statistics-chart').before( '<div class="oih-overlay"><div class="spinner"></div></div>' );

            // Destroy and add chart
            $('#oih-statistics-chart').remove();
            $('#oih-statistics-chart-wrapper').append( '<canvas id="oih-statistics-chart" height="85px;"></canvas>' );

            // Disable all inputs
            $('.oih-wrap').find( 'input, select' ).attr( 'disabled', true );

            // Prepare POST data
            var data = {
                action      : "oih_ajax_load_statistics",
                start_date  : start_date,
                end_date    : end_date,
                optins      : ( typeof optins != 'undefined' ? optins : '' ),
                filter_by_top_optins : $('#oih-statistics-filter-top-optins').val(),
                filter_by_top_pages  : $('#oih-statistics-filter-top-pages').val()
            };

            // Make the request
            $.post( ajaxurl, data, function( response ) {

                response = JSON.parse( response );

                // Add chart
                var data = {
                    labels: response.chart.labels,
                    datasets: [
                        {
                            label: 'Impressions',
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "rgba(0,115,170,.2)",
                            borderColor: "#0073aa",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#0073aa",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#0073aa",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data: response.chart.impressions,
                            spanGaps: false
                        },
                        {
                            label: 'Conversions',
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "rgba(225, 112, 85, .2)",
                            borderColor: "#e17055",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#e17055",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#e17055",
                            pointHoverBorderColor: "rgba(225, 112, 85, 1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data: response.chart.conversions,
                            spanGaps: false
                        },
                        {
                            label: 'Conversion Rate',
                            yAxisID: 'Conversion Rate',
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "rgba(0, 184, 148, .2)",
                            borderColor: "#00b894",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "#00b894",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#00b894",
                            pointHoverBorderColor: "rgba(0, 184, 148, 1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 4,
                            pointHitRadius: 10,
                            data: response.chart.conversion_rate,
                            spanGaps: false
                        }
                    ]
                };

                var ctx = document.getElementById( 'oih-statistics-chart' );

                var chart = new Chart( ctx, {
                    type    : 'line',
                    data    : data,
                    options : {

                        // Tooltips
                        tooltips : {
                            mode : 'x-axis',
                            callbacks : {
                                label : function( tooltipItem, data ) {

                                    if( tooltipItem.datasetIndex == 0 )
                                        return data.datasets[0].label +  ' : ' + data.datasets[0].data[tooltipItem.index];

                                    return data.datasets[tooltipItem.datasetIndex].label + ' : ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                                }
                            }
                        },

                        // Legend
                        legend : {
                            position : 'bottom',
                            labels   : {
                                padding  : 20,
                                boxWidth : 30
                            }
                        },

                        // Scales
                        scales: {
                            xAxes : [{
                                display : true,
                                stacked : false
                            }],
                            yAxes : [{
                                display : true,
                                stacked : false,
                                ticks   : {
                                    beginAtZero : true
                                }
                            },
                            {
                                id : 'Conversion Rate',
                                display : true,
                                stacked : false,
                                ticks   : {
                                    beginAtZero  : true,
                                    suggestedMin : 0,
                                    suggestedMax : 100
                                }
                            }]
                        }
                    }
                });

                // Add overview data
                $('#oih-statistics-value-impressions').html( response.impressions );
                $('#oih-statistics-value-conversions').html( response.conversions );
                $('#oih-statistics-value-conversion-rate').html( response.conversion_rate + '%' );

                // Add top optins table
                $('.oih-wp-list-table.oih_statistics_top_opt_ins').replaceWith( response.top_optins_table );

                // Add top pages table
                $('.oih-wp-list-table.oih_statistics_top_pages').replaceWith( response.top_pages_table );

                // Remove loading spinners
                $('.oih-overlay').remove();

                // Enable all inputs
                $('.oih-wrap').find( 'input, select' ).attr( 'disabled', false );

            });

        }

        /**
         * Initializes the daterange picker
         *
         */
        var date = new Date();

        var $daterange = $('#oih-statistics-daterange input').daterangepicker({
            "autoApply" : true,
            "startDate" : date.getFullYear() + '-' + ( '0' + ( date.getMonth() + 1 ) ).slice(-2) + '-01',
            "endDate"   : date.getFullYear() + '-' + ( '0' + ( date.getMonth() + 1 ) ).slice(-2) + '-' + ( '0' + date.getDate() ).slice(-2),
            "maxDate"   : date.getFullYear() + '-' + ( '0' + ( date.getMonth() + 1 ) ).slice(-2) + '-' + ( '0' + date.getDate() ).slice(-2),
            "opens"     : "left",
            "locale"    : {
                "format" : "YYYY-MM-DD"
            }
        }, function( start, end, label ) {

            refresh_statistics_panels( start.format( 'YYYY-MM-DD' ), end.format( 'YYYY-MM-DD' ) );

        });

        /**
         * Trigger the loading of the statistics on document ready
         *
         */
        $(document).on( 'apply.daterangepicker', function() {

            refresh_statistics_panels( $daterange.data().startDate, $daterange.data().endDate );

        });

        $(document).trigger( 'apply.daterangepicker' );

        /**
         * Show statistics filter by optin input
         *
         */
        $(document).on( 'change', '#oih-statistics-filter-selected-optins', function() {

            if( $(this).val() == 'selected' )
                $('#oih-statistics-filter-optins-wrapper').slideDown( 250 );

            else {

                $('#oih-statistics-filter-optins-wrapper').slideUp( 250 );

                refresh_statistics_panels( $daterange.data().selected_start_date, $daterange.data().selected_end_date );

            }

        });

        $(document).on( 'change', '#oih-statistics-filter-optins-wrapper select', function() {

            refresh_statistics_panels( $daterange.data().selected_start_date, $daterange.data().selected_end_date, $(this).val() );

        });


        /**
         * Refresh the Top Optins table when changing the filter selector
         *
         */
        $(document).on( 'change', '#oih-statistics-filter-top-optins', function() {

            var $select = $(this);

            // Prepare post data
            var data = {
                action     : 'oih_ajax_load_top_optins',
                start_date : $daterange.data().selected_start_date,
                end_date   : $daterange.data().selected_end_date,
                filter_by  : $select.val()
            }

            // Add loading spinners
            $(this).attr( 'disabled', true );
            $('.oih-wp-list-table.oih_statistics_top_opt_ins').before( '<div class="oih-overlay"><div class="spinner"></div></div>' );

            $.post( ajaxurl, data, function( response ) {

                $('.oih-wp-list-table.oih_statistics_top_opt_ins').replaceWith( response );
                
                // Remove loading spinners
                $('.oih-overlay').remove();
                $select.attr( 'disabled', false );

            });

        });


        /**
         * Refresh the Top Pages table when changing the filter selector
         *
         */
        $(document).on( 'change', '#oih-statistics-filter-top-pages', function() {

            var $select = $(this);

            // Prepare post data
            var data = {
                action     : 'oih_ajax_load_top_pages',
                start_date : $daterange.data().selected_start_date,
                end_date   : $daterange.data().selected_end_date,
                filter_by  : $select.val()
            }

            // Add loading spinners
            $(this).attr( 'disabled', true );
            $('.oih-wp-list-table.oih_statistics_top_pages').before( '<div class="oih-overlay"><div class="spinner"></div></div>' );

            $.post( ajaxurl, data, function( response ) {

                $('.oih-wp-list-table.oih_statistics_top_pages').replaceWith( response );
                
                // Remove loading spinners
                $('.oih-overlay').remove();
                $select.attr( 'disabled', false );

            });

        });

    }

});
(function($){
	"use strict";
	$(document).ready(function () {
	    // Advance Search Expend
	    $(".adv-search-btn").on("click", function(){
	    	$(".advance-search-opt").slideToggle(100);
	    });

	    // Advance Search Expend Widget
	    $(".adv-search-btn-widget").on("click", function(){
	    	$(".advance-search-opt-widget").slideToggle(100);
	    });

		$('.select.agency-agents').select2({
		  placeholder: 'Select your agents',
		  allowClear: true
		});

		// Properties List / Gird View
	    // List View / Grid View Button
	    $('#list').on("click", function(event){
	        event.preventDefault();
	        
	        $('#properties .sl-col').removeClass('col-lg-6');
	        $('#properties .sl-col').addClass('col-lg-12');
	        $('#properties .sl-col').removeClass('col-md-6');
	        $('#properties .sl-col').addClass('col-md-12');
	        $('#properties .sl-item').addClass('property-grid');
	        $('#properties .sl-item').addClass('property-list');

	    });
	    $('#grid').on("click", function(event){
	        event.preventDefault();

	        $('#properties .sl-col').removeClass('col-lg-12');
	        $('#properties .sl-col').addClass('col-lg-6');
	        $('#properties .sl-col').removeClass('col-md-12');
	        $('#properties .sl-col').addClass('col-md-6');
	        $('#properties .sl-item').removeClass('property-list');
	        $('#properties .sl-item').addClass('property-grid');
	    });

		if ( $.isFunction($.fn.datetimepicker) ) {
		        // Date Picker
			$('#date_picker').datetimepicker({
				timepicker:false,
				datepicker:true,
				format:'Y/m/d',
			});
			
			// Time Picker
			$('#time_picker').datetimepicker({
				datepicker:false,
				timepicker:true,
				// formatTime:'H:i A',
				// format:'H:i A',
				format:'g:i A',
				formatTime:'g:i A',
				step:30,
				validateOnBlur:false,
				// hours12:true,
			});
		}
		
		// Add Class On Property Slider
		if ($(window).width() <= 767) {
			$(".sl-property-slider").addClass("mobile");
		}  
		if ($(window).width() >= 768) {
			$(".sl-property-slider").removeClass("mobile");
		}

		if ($('body').hasClass("rtl")) {
	       var _rtl = true;
	    } else {
	       var _rtl = false;
	    }

        // Property Single One Images
        $('.property-single-images').slick({ 
            infinite: true,
            // centerMode: true,
            centerPadding: '0px',
            dots: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            rtl: _rtl,
            responsive: [
            	{
                    breakpoint: 1200,
                    settings: {
                        arrows: true,
                        // centerMode: true,
                        centerPadding: '0px',
                        slidesToShow: 2,
                    }
                },
            	{
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        // centerMode: true,
                        centerPadding: '0px',
                        slidesToShow: 1,
                    }
                }
            ]
        });
        
        $('.property-single-images').show();
			
	});
	
	// Add Class On Property Slider Window Resize
	$(window).resize(function(){
		if ($(window).width() <= 767) {
			$(".sl-property-slider").addClass("mobile");
		}  

		if ($(window).width() >= 768) {
			$(".sl-property-slider").removeClass("mobile");
		} 
	});

	// Submit Sort By Form
	$('.sort-by-select').on('change', function() {
		$('#set_sort_filter').submit();
	});

	// Sort By Form Value Update to URL Parameters
	$('#set_sort_filter').on('submit',function(e){
		e.preventDefault();

		// Sort By Form Data
		var formData = $(this).serializeArray()

		// Get the current URL
        var currentUrl = window.location.href;

        // Parse the URL
        var url = new URL(currentUrl);
        var params = new URLSearchParams(url.search);

        // Check if 'sort_by' parameter exists
        if (params.has('sort_by')) {

        	// Delete Sort_by from URL parameter
            params.delete('sort_by');

            // Set Sort by Form Data to URL
            formData.forEach(function(field) {
                params.set(field.name, field.value);
            });

            // Construct the new URL with form data
            var newUrl = url.origin + url.pathname + '?' + params.toString();

        } else {

			// Check if 'sort_by' parameter not exists Set parameter to url
        	formData.forEach(function(field) {
                params.set(field.name, field.value);
            });

            // Construct the new URL with form data
            var newUrl = url.origin + url.pathname + '?' + params.toString();
        }

		window.location.href = newUrl;

	});
	
})(jQuery);

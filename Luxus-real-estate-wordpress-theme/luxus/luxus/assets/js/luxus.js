(function($){
    "use strict";
    $(document).ready(function ($) {

    	$(window).preloader({

          // preloader selectors
          selector:'#sl-preloader',

          // Preloader container holder
          type:'document',

          // 'fade' or 'remove'
          removeType:'fade',

          // fade duration
          fadeDuration: 500,

          // auto disimss after x milliseconds
          delay: 700

        });

        // check browser width in real-time
        luxusWindowCheck();

        function luxusWindowCheck() {

            let header = $('.luxus-header');
            let breakpoint = header.data('breakpoint');
            let browserWidth = window.innerWidth;

            if( browserWidth <= breakpoint ) {

                // mobile/tablet header
                header.addClass('mobile');
                header.removeClass('desktop');

            } else {

                // desktop header
                header.addClass('desktop');
                header.removeClass('mobile');
            }
        }

        $(window).on('resize', function() {
            luxusWindowCheck();
        });

        // Responsive Navigation
        let breakpoint = $('.luxus-header').data('breakpoint');
        $('.stellarnav').stellarNav({

            theme: 'dark', // 'light', 'dark'
            breakpoint: breakpoint, // 1200, 992, 768, 480
            position: 'left', // 'left', 'right'

        });

        // User Loged-in Avatae click action
        $(".user-pic").on("click", function(){
            $(".quick-links").slideToggle(200);
        });

        // Back To Top
        $(window).scroll(function() {
          if ($(window).scrollTop() > 1500) {
            $('#backtoTop').addClass('bottom');
            $('#backtoTop').removeClass('top');
          } else if ($(window).scrollTop() < 1500)  {
    		$('#backtoTop').addClass('top');
            $('#backtoTop').removeClass('bottom');
          }else{
    		  
    	  }
        });

        $('#backtoTop').on('click', function(e) {
          e.preventDefault();
          $('html, body').animate({scrollTop:0}, '300');
        });

        // Sticky Sidebar
        if ( $.isFunction($.fn.theiaStickySidebar) ) {
            // Sticky Sidebar
            $('.sl-sticky').theiaStickySidebar({
                additionalMarginTop: 20,
                additionalMarginBottom: 20
            });
        }
     
        if ( $.isFunction($.fn.magnificPopup) ) {
            // Video PopUp
            $('.video-popup').magnificPopup({
                type: 'iframe'
            });

            // Magnific Popup
            $('.sl-popup').magnificPopup({
                type: 'image',

                gallery: {
                    enabled: true
                },

                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it

                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function

                    // The "opener" function should return the element from which popup will be zoomed in
                    // and to which popup will be scaled down
                    // By defailt it looks for an image tag:
                    opener: function(openerElement) {
                        // openerElement is the element on which popup was initialized, in this case its <a> tag
                        // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                },
            });
        }

        // Cart Popup
        var slCartItems = $(".sl-cart-count").text();

        if ( slCartItems >= 1 ) {

            $(".sl-cart-popup").css('visibility','visible');
            $(".sl-cart-popup").css('opacity','1');

            if ($('body').hasClass("rtl")) {
                $(".sl-cart-popup").animate({"left":"0"}, "slow");
            } else {
                $(".sl-cart-popup").animate({"right":"0"}, "slow");
            }
            
            
        } else {

            $(".add_to_cart_button").click(function(){
                $(".sl-cart-popup").css('visibility','visible');
                $(".sl-cart-popup").css('opacity','1');
                $(".sl-cart-popup").fadeIn(500);

                if ($('body').hasClass("rtl")) {
                    $(".sl-cart-popup").animate({"left":"0"}, "slow");
                } else {
                    $(".sl-cart-popup").animate({"right":"0"}, "slow");
                }

            });
        }

    	//	check if the parallax element is in viewport
        $.fn.parallax_element = function() {
        	const self = $(this);
            let elementTop = self.offset().top;
            let elementBottom = elementTop + self.outerHeight();
    		
            let viewportTop = $(window).scrollTop();
            let viewportBottom = viewportTop + $(window).height();

            return elementBottom > viewportTop && elementTop < viewportBottom;
        };
    	
    	//	Parallax Effect
        $(window).on("load scroll", () => {
            let scroll = $(document).scrollTop();
            const offset = -0.3;
    		
    		//	Background
            $(".sl-parallax").each(function() {
                const self = $(this);
                let selfPosition = self.offset().top;
    			
    			let position = selfPosition * offset - scroll * offset;

                if (self.parallax_element()) {
                    self.css({
                        "background-position": "50% " + position + "px"
                    });
                }
            });
        });

        // Select 2
        $('select').select2({
            minimumResultsForSearch: 10
        });

        // Adding custom class to Select2 dropdown
        $("select").on("select2:open", function (e) {
            var select_id = $(this).attr('id');
            var container = $(".select2-dropdown");
            container.addClass(select_id);
        });
        $("select").on("select2:closing", function (e) {
            var select_id = $(this).attr('id');
            var container = $(".select2-dropdown");
            container.removeClass(select_id);
        });

        // Remove empty p tag
        $('p:empty').remove();

    });

})(jQuery);
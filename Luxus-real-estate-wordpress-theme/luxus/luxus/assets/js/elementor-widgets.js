( function( $ ) {

    if ($('body').hasClass("rtl")) {
       var _rtl = true;
    } else {
       var _rtl = false;
    }
    
    var LuxusCarousel = function( $scope, $ ) {
        var $_this = $scope.find( '.luxus-carousel' );
        var $currentID = '#'+$_this.attr( 'id' ),
            $stshow   = $_this.data( 'stshow' ),
            $stscroll   = $_this.data( 'stscroll' );
            $cpaddinglg   = $_this.data( 'cpaddinglg' );
            $cpaddingmd   = $_this.data( 'cpaddingmd' );
            $cpaddingsm   = $_this.data( 'cpaddingsm' );

        var carousel = $( $currentID );
        carousel.slick({
          // dots: true,
          // infinite: false,
          speed: 300,
          slidesToShow: $stshow,
          slidesToScroll: $stscroll,
          centerPadding: $cpaddinglg,
          rtl: _rtl,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                centerPadding: $cpaddinglg,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerPadding: $cpaddingmd
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerPadding: $cpaddingsm,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        })
    }

    var LuxusSlider = function( $scope, $ ) {
        var $_this = $scope.find( '.luxus-slider' );
        var $currentID = '#'+$_this.attr( 'id' ),
            $stshow   = $_this.data( 'stshow' ),
            $stscroll   = $_this.data( 'stscroll' );
            $cpadding   = $_this.data( 'cpadding' );

        var carousel = $( $currentID );
        carousel.slick({
          // dots: true,
          // infinite: false,
          speed: 1000,
          slidesToShow: $stshow,
          slidesToScroll: $stscroll,
          centerPadding: $cpadding,
          cssEase: 'ease-in-out',
          fade: true,
          rtl: _rtl,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        })
    }

    var LuxusFeaturedPropsCarousel = function( $scope, $ ) {
        var $_this = $scope.find( '.luxus-carousel' );
        var $currentID = '#'+$_this.attr( 'id' ),
            $stshowxl = $_this.data( 'stshowxl' ),
            $stshowlg = $_this.data( 'stshowlg' ),
            $stshow = $_this.data( 'stshow' ),
            $stscroll   = $_this.data( 'stscroll' );
            $cpaddinglg   = $_this.data( 'cpaddinglg' );
            $cpaddingmd   = $_this.data( 'cpaddingmd' );
            $cpaddingsm   = $_this.data( 'cpaddingsm' );

        var carousel = $( $currentID );
        carousel.slick({
          // dots: true,
          // infinite: false,
          speed: 300,
          slidesToShow: $stshow,
          slidesToScroll: $stscroll,
          centerPadding: $cpaddinglg,
          rtl: _rtl,
          responsive: [
            {
              breakpoint: 2550,
              settings: {
                slidesToShow: $stshowxl,
                slidesToScroll: $stshowxl,
                centerPadding: $cpaddinglg,
              }
            },
            {
              breakpoint: 1920,
              settings: {
                slidesToShow: $stshowlg,
                slidesToScroll: $stshowlg,
                centerPadding: $cpaddinglg,
              }
            },
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                centerPadding: $cpaddinglg,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerPadding: $cpaddingmd
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerPadding: $cpaddingsm,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        })
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-property-slider.default', LuxusSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-blog-caousel.default', LuxusCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-testimonial-caousel.default', LuxusCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-property-caousel.default', LuxusCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-property-caousel-featured.default', LuxusFeaturedPropsCarousel);
    });

} )( jQuery );
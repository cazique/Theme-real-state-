( function( $ ) {
    
    var LuxusCarousel = function( $scope, $ ) {
        var $_this = $scope.find( '.luxus-carousel' );
        var $currentID = '#'+$_this.attr( 'id' ),
            $stshow   = $_this.data( 'stshow' ),
            $stscroll   = $_this.data( 'stscroll' );
            $cpadding   = $_this.data( 'cpadding' );

        var carousel = $( $currentID );
        carousel.slick({
          // dots: true,
          // infinite: false,
          speed: 300,
          slidesToShow: $stshow,
          slidesToScroll: $stscroll,
          centerPadding: $cpadding,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
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


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-blog-caousel.default', LuxusCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-testimonial-caousel.default', LuxusCarousel);
    });

} )( jQuery );
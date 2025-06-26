// Google Map Script

function initMap() {

    // Getting Data Attr
    var element = document.querySelector('#half_map');
    var settings = JSON.parse(element.getAttribute('data-settings'));
    var properties = JSON.parse(element.getAttribute('data-properties'));
    
    var mapLat = settings.lat;
    var mapLng = settings.lng;
    var mapZoom = settings.zoom;
    var iconImg = settings.iconImg;
    var iconWidth = settings.iconWidth;
    var iconHeight = settings.iconHeight;
    var m1 = settings.m1;
    var m2 = settings.m2;
    var m3 = settings.m3;
    var m4 = settings.m4;
    var m5 = settings.m5;

    var center = new google.maps.LatLng(mapLat, mapLng);

    // Map Options
    var mapOptions = {
        zoom: mapZoom,
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        gestureHandling: 'greedy',
        styles:[
            {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#e0efef"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#1900ff"
                    },
                    {
                        "color": "#c0e8e8"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on",
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 700
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#7dcdcd"
                    }
                ]
            }
        ]
    }

    // Half Map
    var map = new google.maps.Map(document.getElementById('half_map'), mapOptions);

    // Markers
    var markers = [];

    // Market Icon
    var markerUrl = iconImg;
    var markerWidth = iconWidth;
    var markerHeight = iconHeight;

    // Info Window
    var infowindow = new google.maps.InfoWindow();

    var sl_properties = properties;

    if(sl_properties!==''){

        for (i = 0; i < sl_properties.length; i++){

            if ( sl_properties[i]['post_id'] == 'notFound' ){

                var marker = new google.maps.Marker({
                    position: center,
                    map: map,
                    icon: {
                        url: sl_properties[i]['broken_icon'],
                        scaledSize: new google.maps.Size( markerWidth, markerHeight ),
                    }
                });

                markers.push(marker);

                google.maps.event.addListener(marker, 'click', (function(marker, i){
                    return function(){

                        infowindow.setContent('<div class="infowin-not-found" style="position: relative;"> No Properties Found!</div>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));

            } else {

                var latLng = new google.maps.LatLng(sl_properties[i].lat,sl_properties[i].lng);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: {
                        url: markerUrl,
                        scaledSize: new google.maps.Size( markerWidth, markerHeight ),
                    }
                });

                markers.push(marker);

                google.maps.event.addListener(marker, 'mouseover', (function(marker, i){
                    return function(){

                        infowindow.setContent('<div class="infowin-property" style="position: relative;"><div class="image"><img src="'+sl_properties[i].image+'"><div class="image-top"><a href="'+sl_properties[i].link+'" class="type">'+sl_properties[i].type+'</a><a href="'+sl_properties[i].link+'" class="status">For '+sl_properties[i].status+'</a></div><div class="image-bottom"><p class="address"><i class="sl-icon sl-place"></i>'+sl_properties[i].address+'</p><a href="'+sl_properties[i].link+'"><h6 class="title">'+sl_properties[i].title+'</h6></a></div></div><div class="property-info"><div class="content"><ul class="features"><li><p>Bedrooms</p><p><i class="sl-icon sl-bedroom"></i><span>'+sl_properties[i].bedrooms+'</span></p></li><li><p>Bathrooms</p><p><i class="sl-icon sl-bathroom"></i><span>'+sl_properties[i].bathrooms+'</span></p></li><li><p>Parking</p><p><i class="sl-icon sl-car"></i><span>'+sl_properties[i].parking+'</span></p></li></ul></div><div class="footer"><span class="agent"><i class="sl-icon sl-user-o"></i>'+sl_properties[i].author +'</span><span class="date"><i class="sl-icon sl-calendar"></i>'+sl_properties[i].date +'</span></div></div></div>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));

            }

        }

        jQuery(document).ready(function($) {

            // Propery Hover Popup Marker New
            $('.property-inner').hover(
                function() {

                    if($(this).attr('data-lat') != undefined && $(this).attr('data-lng') != undefined ) {

                        LatLng =  {
                            lat: parseInt($(this).attr('data-lat')),
                            lng: parseInt($(this).attr('data-lng'))
                        };

                        map.setCenter(LatLng);
                        map.setZoom(10);
                        map.panTo(LatLng);

                        google.maps.event.trigger(markers[$(this).attr('data-index')], 'mouseover');

                    }
                },
                function() {
                    map.setZoom(8);
                }
            );

            $(".sl-col").hover(
                function(){},
                function(){
                     map.setZoom(8);
                  }
            );
        });
    }

    var clusterOptoins = {
        styles: [
            {
                url: m1,
                width: 53,
                height: 52,
                textSize: 15,
                textColor: "#F7F7FF",
                textLineHeight: 54,
            },
            {   
                url: m2,
                width: 56,
                height: 55,
                textSize: 15,
                textColor: "#F7F7FF",
                textLineHeight: 57,
            },
            {
                url: m3,
                width: 66,
                height: 65,
                textSize: 15,
                textColor: "#F7F7FF",
                textLineHeight: 67,
            },
            {
                url: m4,
                width: 78,
                height: 77,
                textSize: 15,
                textColor: "#F7F7FF",
                textLineHeight: 79,
            },
            {
                url: m5,
                width: 90,
                height: 89,
                textSize: 16,
                textColor: "#F7F7FF",
                textLineHeight: 91,
            }
        ]
    }

    var markerCluster = new MarkerClusterer(map, markers, clusterOptoins);
}

window.addEventListener('load', initMap);

// Half Map Style
jQuery(document).ready(function($) {

    var window_height = $(window).height();
    var header_height = $('header').height()
    var map_height = (window_height - header_height);

    if ($(window).width() > 1200) {
        $('.site-header').css({'position':'fixed'});
        // $('.halfmap-page-content').css({'margin-top': header_height+'px'});
        $('.half-map_outer').css({'height': map_height+'px'});
        $('.half-map_outer').css({'width':'calc(50% - 15px)'});
        $('.half-map_outer').css({'position':'fixed'});
    }
    else {

        $('.half-map_outer').css({'height':'650px'});
        $('.half-map_outer').css({'margin-bottom':'30px'});
        $('.half-map_outer').css({'width':'100%'});
        $('.half-map_outer').css({'position':'relative'});
    }

});

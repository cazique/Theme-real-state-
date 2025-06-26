/**
 * Gmap Properties
 */

( function( $, elementor ) {

    // 'use strict';

    var PropertiesGmap = function( $scope, $ ) {

        var $propertyGmap = $scope.find( '#sl_properties_gmap' ),
            settings       = $propertyGmap.data('settings'),
            properties        = $propertyGmap.data('properties');

        var center = new google.maps.LatLng(settings.lat, settings.lng);

        // Map Options
        var mapOptions = {
            zoom: settings.zoom,
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

        var map = new google.maps.Map(document.getElementById('sl_properties_gmap'), mapOptions);

        // Markers
        var markers = [];

        // Info Window
        var infowindow = new google.maps.InfoWindow();

        // Properties Json
        var sl_properties ='';

        if (properties!='') {

            var sl_properties = properties;
        }

        // Properties Loop
        if(sl_properties!='') {
            
            for (i = 0; i < sl_properties.length; i++){

                if ( sl_properties[i]['post_id'] == 'notFound' ){

                    var latLng = new google.maps.LatLng(sl_properties[i].lat,sl_properties[i].lng);
                    var marker = new google.maps.Marker({
                        position: center,
                        map: map,
                        // icon: sl_properties[i].iconUrl,
                        icon: {
                            url: sl_properties[i]['broken_icon'],
                            scaledSize: new google.maps.Size( settings.iconWidth, settings.iconHeight ),
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
                        // icon: sl_properties[i].iconUrl,
                        icon: {
                            url: sl_properties[i].iconUrl,
                            scaledSize: new google.maps.Size( settings.iconWidth, settings.iconHeight ),
                        }
                    });

                    markers.push(marker);
                    
                    google.maps.event.addListener(marker, 'click', (function(marker, i){
                        return function(){

                            infowindow.setContent('<div class="infowin-property" style="position: relative;"><div class="image"><img src="'+sl_properties[i]['infoWin'].image+'"><div class="image-top"><a href="'+sl_properties[i]['infoWin'].link+'" class="type">'+sl_properties[i]['infoWin'].type+'</a><a href="'+sl_properties[i]['infoWin'].link+'" class="status">For '+sl_properties[i]['infoWin'].status+'</a></div><div class="image-bottom"><p class="address"><i class="sl-icon sl-place"></i>'+sl_properties[i]['infoWin'].address+'</p><a href="'+sl_properties[i]['infoWin'].link+'"><h6 class="title">'+sl_properties[i]['infoWin'].title+'</h6></a></div></div><div class="property-info"><div class="content"><ul class="features"><li><p>Bedrooms</p><p><i class="sl-icon sl-bedroom"></i><span>'+sl_properties[i]['infoWin'].bedrooms+'</span></p></li><li><p>Bathrooms</p><p><i class="sl-icon sl-bathroom"></i><span>'+sl_properties[i]['infoWin'].bathrooms+'</span></p></li><li><p>Parking</p><p><i class="sl-icon sl-car"></i><span>'+sl_properties[i]['infoWin'].parking+'</span></p></li></ul></div><div class="footer"><span class="agent"><i class="sl-icon sl-user-o"></i>'+sl_properties[i]['infoWin'].author +'</span><span class="date"><i class="sl-icon sl-calendar"></i>'+sl_properties[i]['infoWin'].date +'</span></div></div></div>');
                            infowindow.open(map, marker);
                        }
                    })(marker, i));

                }
            }
        }

        var clusterOptoins = {
            styles: [
                {
                    url: settings.m1,
                    width: 53,
                    height: 52,
                    textSize: 15,
                    textColor: "#F7F7FF",
                    textLineHeight: 54,
                },
                {   
                    url: settings.m2,
                    width: 56,
                    height: 55,
                    textSize: 15,
                    textColor: "#F7F7FF",
                    textLineHeight: 57,
                },
                {
                    url: settings.m3,
                    width: 66,
                    height: 65,
                    textSize: 15,
                    textColor: "#F7F7FF",
                    textLineHeight: 67,
                },
                {
                    url: settings.m4,
                    width: 78,
                    height: 77,
                    textSize: 15,
                    textColor: "#F7F7FF",
                    textLineHeight: 79,
                },
                {
                    url: settings.m5,
                    width: 90,
                    height: 89,
                    textSize: 16,
                    textColor: "#F7F7FF",
                    textLineHeight: 91,
                }
            ]
        }

        var markerCluster = new MarkerClusterer(map, markers, clusterOptoins);

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-property-gmap.default', PropertiesGmap);
    });

} )( jQuery );
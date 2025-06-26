/**
 * OSMap Properties
 */

( function( $, elementor ) {

    // 'use strict';

    var PropertiesOSMap = function( $scope, $ ) {

        var $propertyOSM = $scope.find( '.sl-properties-osm' ),
            settings       = $propertyOSM.data('settings'),
            properties        = $propertyOSM.data('properties'),
            tileSource = '';

        var markerLocation = [settings.lat, settings.lng];
        var mapZoom = settings.zoom;
        var iconWidth = settings.iconWidth;
        var iconHeight = settings.iconHeight;
        var iconWidthPA = -+settings.iconWidth/2;
        var iconHeightPA = -+settings.iconHeight;

        // Map
        var propertyMap = L.map($propertyOSM[0], {
            center: markerLocation,
            zoom: mapZoom,
            scrollWheelZoom: false,
            'layers': [
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
                })
            ]
        });

        // CLuster Marker
        var cMarkers = L.markerClusterGroup({
            spiderfyOnMaxZoom: false,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true
        });

        // Marker Locations and Data
        for (var i in properties) {

            if ( properties[i]['post_id'] == 'notFound' ){

                // create custom icon
                var markerIconBroken = L.icon({
                        iconUrl: properties[i]['broken_icon'],
                        iconSize   : [ iconWidth, iconHeight ],
                        iconAnchor : [ iconWidth, iconHeight ],
                        popupAnchor: [ iconWidthPA, iconHeightPA ]
                    });

                var propertyMarker = new L.marker( markerLocation, {icon: markerIconBroken} );

                propertyMarker.bindPopup('<div class="infowin-not-found" style="position: relative;"> No Properties Found!</div>');

                cMarkers.addLayer(propertyMarker);


            } else {

                // create custom icon
                var markerIcon = L.icon({
                        iconUrl: properties[i]['iconUrl'],
                        iconSize   : [ iconWidth, iconHeight ],
                        iconAnchor : [ iconWidth, iconHeight ],
                        popupAnchor: [ iconWidthPA, iconHeightPA ]
                    });

                var propertyMarker = new L.marker( [properties[i]['lat'], properties[i]['lng']], {icon: markerIcon} );

                propertyMarker.bindPopup('<div class="infowin-property" style="position: relative;"><div class="image"><img src="'+properties[i]['infoWin'].image+'"><div class="image-top"><a href="'+properties[i]['infoWin'].link+'" class="type">'+properties[i]['infoWin'].type+'</a><a href="'+properties[i]['infoWin'].link+'" class="status">For '+properties[i]['infoWin'].status+'</a></div><div class="image-bottom"><p class="address"><i class="sl-icon sl-place"></i>'+properties[i]['infoWin'].address+'</p><a href="'+properties[i]['infoWin'].link+'"><h6 class="title">'+properties[i]['infoWin'].title+'</h6></a></div></div><div class="property-info"><div class="content"><ul class="features"><li><p>Bedrooms</p><p><i class="sl-icon sl-bedroom"></i><span>'+properties[i]['infoWin'].bedrooms+'</span></p></li><li><p>Bathrooms</p><p><i class="sl-icon sl-bathroom"></i><span>'+properties[i]['infoWin'].bathrooms+'</span></p></li><li><p>Parking</p><p><i class="sl-icon sl-car"></i><span>'+properties[i]['infoWin'].parking+'</span></p></li></ul></div><div class="footer"><span class="agent"><i class="sl-icon sl-user-o"></i>'+properties[i]['infoWin'].author +'</span><span class="date"><i class="sl-icon sl-calendar"></i>'+properties[i]['infoWin'].date +'</span></div></div></div>')
                // propertyMarker.addTo(propertyMap);

                cMarkers.addLayer(propertyMarker);


            }

        }

        // CLuster Markers
        propertyMap.addLayer(cMarkers);

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/luxus-property-map-osm.default', PropertiesOSMap);
    });

} )( jQuery );
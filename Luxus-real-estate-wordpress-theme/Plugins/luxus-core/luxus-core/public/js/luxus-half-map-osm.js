(function($){
	"use strict";

    // Half Map Style
    var window_height = $(window).height();
    var header_height = $('header').height();
    var map_height = window_height - header_height;

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

    // Getting Data Attr
	var settings = $('#half_map').data('settings');
    var properties = $('#half_map').data('properties');

    var markerLocation = [settings.lat, settings.lng];
    var mapZoom = settings.zoom;
    var markerImg = settings.iconImg;
    var markerWidth = settings.iconWidth;
    var markerHeight = settings.iconHeight;
    var markerWidthPA = -+settings.iconWidth/2;
    var markerHeightPA = -+settings.iconHeight;

    // Map
    var map_osm = L.map('half_map', {
        center: markerLocation,
        zoom: mapZoom,
        'layers': [
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
            })
        ]
    });

    // create custom icon
    var markerIcon = L.icon({
            iconUrl: markerImg,
            iconSize   : [ markerWidth, markerHeight ],
            iconAnchor : [ markerWidth, markerHeight ],
            popupAnchor: [ markerWidthPA, markerHeightPA ]
        });

    // Data For Hover Property
    var propMarkers = [];

    // CLuster Marker
    var clusterMarkers = L.markerClusterGroup({
        spiderfyOnMaxZoom: false,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        disableClusteringAtZoom: 10
    });

    // Marker Locations and Data
    for (var i in properties) {

        if ( properties[i]['post_id'] == 'notFound' ){

                // create custom icon
            var markerIconBroken = L.icon({
                    iconUrl: properties[i]['broken_icon'],
                    iconSize   : [ markerWidth, markerHeight ],
                    iconAnchor : [ markerWidth, markerHeight ],
                    popupAnchor: [ markerWidthPA, markerHeightPA ]
                });

            var propertyMarker = new L.marker( markerLocation, {
                    icon: markerIconBroken,
                });

            propertyMarker.bindPopup('<div class="infowin-not-found" style="position: relative;"> No Properties Found!</div>');

            cMarkers.addLayer(propertyMarker);

        } else {

            var propertyMarker = new L.marker( [properties[i]['lat'], properties[i]['lng']], {
                    icon: markerIcon,
                    title: properties[i]['title'],
                    index: properties[i]['post_index'],
                    lat: properties[i]['lat'],
                    lng: properties[i]['lng']
                });

            propertyMarker.bindPopup('<div class="infowin-property" style="position: relative;"><div class="image"><img src="'+properties[i].image+'"><div class="" title="Featured"><i class="fa fa-fire"></i></div><div class="image-top"><a href="'+properties[i].link+'" class="type">'+properties[i].type+'</a><a href="'+properties[i].link+'" class="status">For '+properties[i].status+'</a></div><div class="image-bottom"><a href="'+properties[i].link+'"><h6 class="title">'+properties[i].title+'</h6></a><p class="address"><i class="sl-icon sl-place"></i>'+properties[i].address+'</p></div></div><div class="property-info"><div class="content"><ul class="features"><li><p>Bedrooms</p><p><i class="sl-icon sl-bedroom"></i><span>'+properties[i].bedrooms+'</span></p></li><li><p>Bathrooms</p><p><i class="sl-icon sl-bathroom"></i><span>'+properties[i].bathrooms+'</span></p></li><li><p>Parking</p><p><i class="sl-icon sl-car"></i><span>'+properties[i].parking+'</span></p></li></ul></div><div class="footer"><span class="agent"><i class="sl-icon sl-user-o"></i>'+properties[i].author +'</span><span class="date"><i class="sl-icon sl-calendar"></i>'+properties[i].date +'</span></div></div></div>');

            propMarkers.push(propertyMarker);
            clusterMarkers.addLayer(propertyMarker);

            propertyMarker.on('mouseover',function(event) {
              event.target.openPopup();
            });

        }

    }

    // Open InfoWindo on Property Hover
    function markerPopupMouseOver(index){
        for (var i in propMarkers){
            var markerIndex = propMarkers[i].options.index;
            if (markerIndex == index){
                map_osm.flyTo([propMarkers[i].options.lat, propMarkers[i].options.lng], 10, {
                    animate: true,
                    duration: 1
                });
                propMarkers[i].openPopup();
            };
        }
    }
    
    $('.property-inner').mouseover(function(){
        var propIndex = $(this).attr('data-index');
        markerPopupMouseOver(propIndex);
    });

    function markerPopupMouseLeave(index){
        for (var i in propMarkers){
            var markerIndex = propMarkers[i].options.index;
            if (markerIndex == index){

                map_osm.setView([propMarkers[i].options.lat, propMarkers[i].options.lng], 8);

            };
        }
    }

    $('.property-inner').mouseleave(function(){
        var propIndex = $(this).attr('data-index');
        markerPopupMouseLeave(propIndex);
    });

    // CLuster Markers
    map_osm.addLayer(clusterMarkers)

})(jQuery);

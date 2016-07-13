/* ========================================================================
 * google.js
 * Page/renders: maps-google.html
 * Plugins used: gmaps
 * ======================================================================== */

/* global GMaps */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'tinyMap'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // gmaps - geocoding
        // ================================
        // Basic
        // var addr_lat, addr_lng;
        // $('#search_address').on('click', function() {
        //     // $('#map').tinyMap('panTo', $('input[name="restaurant_address"]').val());
        //     var address = '臺北市信義區市府路1號';
            
        //     // $('#map').tinyMap('destroy');
        //     $('#map').tinyMap('query', address, function (addr) {
        //         console.log(addr.geometry.location.lat()); // Latitude
        //         console.log(addr.geometry.location.lng()); // Longitude
        //         addr_lat = addr.geometry.location.lat();
        //         // console.log(address);
        //     });
        //     // return false;
        //     $('#map').tinyMap('clear', 'marker');
        //     console.log(addr_lat);
        //     $('#map').tinyMap({
        //         'center': address,
        //         'zoom'  : 15,
        //         'marker': [
        //             {
        //                 'addr': [addr_lat, addr_lng],
        //                 'text': '<strong>' + address + '</strong>',
        //                 'animation': 'DROP'
        //             }
        //         ]
        //     });
        // });
        // $('#map').tinyMap({
        //     'center': '台灣台北市信義區逸仙路288號',
        //     'zoom'  : 15,
        //     'marker': [
        //         {
        //             'addr': ['25.039065815333753', '121.56097412109375'],
        //             'text': '<strong>110台灣台北市信義區逸仙路288號</strong>',
        //             'animation': 'DROP'
        //         }
        //     ]
        // });
        // var geocoding = new GMaps({
        //     el: '#map-canvas',
        //     lat: -12.043333,
        //     lng: -77.028333
        // });
        // GMaps.geocode({
        //   // address: $('#address').val(),
        //   address: '永美街',
        //   callback: function(results, status) {
        //     if (status == 'OK') {
        //       var latlng = results[0].geometry.location;
        //       geocoding.setCenter(latlng.lat(), latlng.lng());
        //       geocoding.addMarker({
        //         lat: latlng.lat(),
        //         lng: latlng.lng()
        //       });
        //     }
        //   }
        // });
        // $('#geocoding-form').submit(function (e) {
        //     e.preventDefault();
        //     GMaps.geocode({
        //         address: $('#geocoding-address').val().trim(),
        //         callback: function(results, status){
        //             if(status === 'OK'){
        //                 var latlng = results[0].geometry.location;
        //                 geocoding.setCenter(latlng.lat(), latlng.lng());
        //                 geocoding.addMarker({
        //                     lat: latlng.lat(),
        //                     lng: latlng.lng()
        //                 });
        //             }
        //         }
        //     });
        // });
       //  var myLatLng = new google.maps.LatLng(0, -180);
       //  var myOptions = {
       //    zoom: 3,
       //    center: myLatLng,
       //    mapTypeId: google.maps.MapTypeId.TERRAIN
       //  };

       //  var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

       //  var flightPlanCoordinates = [
       //      new google.maps.LatLng(37.772323, -122.214897),
       //      new google.maps.LatLng(21.291982, -157.821856),
       //      new google.maps.LatLng(-18.142599, 178.431),
       //      new google.maps.LatLng(-27.46758, 153.027892)
       //  ];
       //  var flightPath = new google.maps.Polyline({
       //    path: flightPlanCoordinates,
       //    strokeColor: "#FF0000",
       //    strokeOpacity: 1.0,
       //    strokeWeight: 2
       //  });

       // flightPath.setMap(map);
       // $('#map-model').modal({
       //  show: false,
       //  remote: 'http://events.fooriends.dev/admin/events/'
       // });
       // $("#test").on('click', function (e) {
       //  $('#map-model').removeData('bs.modal');
       //  $('#map-model').modal({remote: 'http://events.fooriends.dev/admin/events/' });
       //  $('#map-model').modal('show');
       //  e.preventDefault();
       // });
       // $("#map-model").on("show.bs.modal", function(e) {
       //      var link = 'http://events.fooriends.dev/api/map';
       //      console.log(link);
       //      $(this).find(".modal-body").load(link);
       //  });
        var map;        
        var myCenter=new google.maps.LatLng(53, -1.33);
        var marker=new google.maps.Marker({
            position:myCenter
        });

        function initialize() {
          var mapProp = {
              center:myCenter,
              zoom: 14,
              draggable: false,
              scrollwheel: false,
              mapTypeId:google.maps.MapTypeId.ROADMAP
          };
          
          map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);
          marker.setMap(map);
            
          google.maps.event.addListener(marker, 'click', function() {
              
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
            
          }); 
        };
        google.maps.event.addDomListener(window, 'load', initialize);

        google.maps.event.addDomListener(window, "resize", resizingMap());

        $('#map-model').on('show.bs.modal', function() {
           //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
           resizeMap();
        })

        function resizeMap() {
           if(typeof map =="undefined") return;
           setTimeout( function(){resizingMap();} , 400);
        }

        function resizingMap() {
           if(typeof map =="undefined") return;
           var center = map.getCenter();
           google.maps.event.trigger(map, "resize");
           map.setCenter(center); 
        }
    });

}));
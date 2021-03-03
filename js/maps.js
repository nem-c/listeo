// Default infoBox Rating Type

(function ( $ ) {
  "use strict";

  $(function () {
    
    var infoBox_ratingType = 'star-rating';
    var geooptions = {};  
     if(listeo_core.country){
      geooptions = {componentRestrictions:{country:listeo_core.country}}; 
    } 

    var geocoder = new google.maps.Geocoder();  
    $("#_address").geocomplete(geooptions).bind("geocode:result", function(event, result){

        var loc = result.geometry.location,
            lat = loc.lat(),
            lng = loc.lng();
        var filtered_array = result.address_components.filter(function(address_component){
            return address_component.types.includes("administrative_area_level_2");
        }); 
        var county = filtered_array.length ? filtered_array[0].long_name: "";
     
          $('#_geolocation_lat').val(lat);
          $('#_geolocation_long').val(lng);
          $('#_city').val(county);

    });

  
    var center;

    if(listeo_core.centerPoint) {
      var latlngStr = listeo_core.centerPoint.split(",",2);
      console.log(latlngStr);
      var lat = parseFloat(latlngStr[0]);
      var lng = parseFloat(latlngStr[1]);
        console.log(lat);
        console.log(lng);
      center = new google.maps.LatLng(lat, lng);
      console.log(center);
    } else {
      center = new google.maps.LatLng(-33.92, 151.25);
    }

    var geooptions = {};  
     if(listeo_core.country){
      geooptions = {componentRestrictions:{country:listeo_core.country}}; 
    } 
  //$("#location_search").geocomplete(geooptions);

 
   
    if ($('.main-search-input-item')[0]) {
      
      var input = document.getElementById('location_search');
      var autocomplete = new google.maps.places.Autocomplete(input);

      autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();
        if (!place.geometry) {
          window.alert("No details available for input: '" + place.name + "'");
          return;
        }

      });
      $('#location_search').on('focus', function(){
            setTimeout(function(){ 
                $(".pac-container").prependTo("#autocomplete-container");
            }, 300);  
        });
    } else {

      $("#location_search").geocomplete(geooptions).bind("geocode:result", function(event, result){
          $(this).data('lastlat',result.geometry.location.lat()).data('lastlng',result.geometry.location.lng())
          $("#location_search").data('lastlat',result.geometry.location.lat()).data('lastlng',result.geometry.location.lng())
          var target   = $('div#listeo-listings-container' );
          target.triggerHandler( 'update_results', [ 1, false ] );
      });

    }
    

    // var input = document.getElementById('location_search');
    // var autocomplete = new google.maps.places.Autocomplete(input);
    function locationData(locationURL,locationImg,locationTitle, locationAddress, locationRating, locationRatingCounter) {
          
      var output;
      var output_top;
      var output_bottom;
      output_top= ''+
            '<a href="'+ locationURL +'" class="listing-img-container">'+
               '<div class="infoBox-close"><i class="fa fa-times"></i></div>'+
               '<img src="'+locationImg+'" alt="">'+

               '<div class="listing-item-content">'+
                  '<h3>'+locationTitle+'</h3>'+
                  '<span>'+locationAddress+'</span>'+
               '</div>'+

            '</a>'+

            '<div class="listing-content">'+
               '<div class="listing-title">';
        if(locationRating>0){
            output_bottom = '<div class="'+infoBox_ratingType+'" data-rating="'+locationRating+'"><div class="rating-counter">('+locationRatingCounter+' reviews)</div></div>'+
               '</div>'+
            '</div>';
        } else {
          output_bottom = '<div class="'+infoBox_ratingType+'"><span class="not-rated">'+listeo_core.maps_noreviews_text+'</span></div>'+
               '</div>'+
            '</div>';
        }
        output = output_top+output_bottom;
        return output;
      }
      function getMarkers() {
        var arrMarkers = [];
        $('.listing-geo-data').each(function(index) {
          var point_address;
          if( $( this ).data('friendly-address') ){
            point_address = $( this ).data('friendly-address');
          } else {
            point_address = $( this ).data('address');
          }
          var url;
          if( $( this ).is('a') ){
            url = $(this).find('a').attr('href');
          } else {
            url = $(this).find('a').attr('href');
          }

          if( $( this ).data('longitude') ) {
            arrMarkers.push([ 
              locationData(
                $(this).find('a').attr('href') ? $(this).find('a').attr('href') : $(this).attr('href'),
                $(this).data('image'),
                $(this).data('title'),
                point_address,
                $(this).data('rating'),
                $(this).data('reviews')
              ),
              $( this ).data('longitude'), $( this ).data('latitude'), 1, $(this).data('icon'),
            ]);
            
          }
        });
        return arrMarkers;
      }
 
    window.mainMap= function(){
    //function mainMap() {

      // Locations
      // ----------------------------------------------- //
      var ib = new InfoBox();

      // Infobox Output


      // Chosen Rating Type
      google.maps.event.addListener(ib,'domready',function(){
         if (infoBox_ratingType == 'numerical-rating') {
            $('.infoBox .'+infoBox_ratingType).numericalRating();
         }
         if (infoBox_ratingType == 'star-rating') {
            $('.infoBox .'+infoBox_ratingType).starRating();
         }
      });

      var center_map;

      if(listeo_core.centerPoint) {
        var lat = parseFloat($("#location_search").data('lastlat'));
        var lng = parseFloat($("#location_search").data('lastlng'));
        if(lat){
            center_map = new google.maps.LatLng(lat, lng); 
        } else if($("#location_search").val()!="") {
            $("#location_search").trigger("geocode");
        } else {
            var latlngStr = listeo_core.centerPoint.split(",",2);
            var lat = parseFloat(latlngStr[0]);
            var lng = parseFloat(latlngStr[1]);
            center_map = new google.maps.LatLng(lat, lng);
        }
      } else {

            center_map = new google.maps.LatLng(-33.92, 151.25);

          
      }

      // Map Attributes
      // ----------------------------------------------- //

      var mapZoomAttr = $('#map').attr('data-map-zoom');
      var mapScrollAttr = $('#map').attr('data-map-scroll');
      var zoomLevel = 6;
      if (typeof mapZoomAttr !== typeof undefined && mapZoomAttr !== false) {
          zoomLevel = parseInt(mapZoomAttr);
      }
      
      var scrollEnabled = false;
              
      if (typeof mapScrollAttr !== typeof undefined && mapScrollAttr !== false) {
         scrollEnabled = parseInt(mapScrollAttr);
      } 


      // Main Map
      var bounds;
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoomLevel,
        scrollwheel: scrollEnabled,
        center: center_map,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        panControl: false,
        navigationControl: false,
        streetViewControl: false,
        gestureHandling: 'cooperative',

        // Google Map Style
        styles: [{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"23"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#f38eb0"}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"color":"#ced7db"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#ffa5a8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c7e5c8"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#d6cbc7"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c4c9e8"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#b1eaf1"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"100"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"},{"lightness":"100"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffd4a5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffe9d2"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"weight":"3.00"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"weight":"0.30"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"36"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"color":"#e9e5dc"},{"lightness":"30"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":"100"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d2e7f7"}]}]

      });


      // Marker highlighting when hovering listing item
      $('.listing-item-container').on('mouseover', function(){

        var listingAttr = $(this).data('marker-id');

        if(listingAttr !== undefined) {
          var listing_id = $(this).data('marker-id') - 1;
          var marker_div = allMarkers[listing_id].div;

          $(marker_div).addClass('clicked');

          $(this).on('mouseout', function(){
              if ($(marker_div).is(":not(.infoBox-opened)")) {
                 $(marker_div).removeClass('clicked');
              }
           });
        }

      });


      // Infobox
      // ----------------------------------------------- //

      var boxText = document.createElement("div");
      boxText.className = 'map-box';

      var currentInfobox;

      var boxOptions = {
              content: boxText,
              disableAutoPan: false,
              alignBottom : true,
              maxWidth: 0,
              pixelOffset: new google.maps.Size(-134, -55),
              zIndex: null,
              boxStyle: {
                width: "270px"
              },
              closeBoxMargin: "0",
              closeBoxURL: "",
              infoBoxClearance: new google.maps.Size(25, 25),
              isHidden: false,
              pane: "floatPane",
              enableEventPropagation: false,
      };


      var markerCluster, overlay, i;
      var allMarkers = [];

      var clusterStyles = [
        {
          textColor: 'white',
          url: '',
          height: 50,
          width: 50
        }
      ];

      var locations = getMarkers();
      bounds = new google.maps.LatLngBounds();
      var markerIco;
      for (i = 0; i < locations.length; i++) {

        markerIco = locations[i][4];

        var overlaypositions = new google.maps.LatLng(locations[i][1], locations[i][2]),

        overlay = new CustomMarker(
         overlaypositions,
          map,
          {
            marker_id: i
          },
          markerIco
        );

        allMarkers.push(overlay);
        bounds.extend(overlaypositions);

        google.maps.event.addDomListener(overlay, 'click', (function(overlay, i) {

          return function() {
            
             ib.setOptions(boxOptions);
             boxText.innerHTML = locations[i][0];
             ib.close();
             ib.open(map, overlay);

             currentInfobox = locations[i][3];
             // var latLng = new google.maps.LatLng(locations[i][1], locations[i][2]);
             // map.panTo(latLng);
             // map.panBy(0,-90);


            google.maps.event.addListener(ib,'domready',function(){
              
              $('.infoBox-close').click(function(e) {
                  e.preventDefault();
                  ib.close();
                  $('.map-marker-container').removeClass('clicked infoBox-opened');
              });

            });

          };
        })(overlay, i));

        //fix for single marker zoom
        var offset = 0.002;     
        var center = bounds.getCenter();                            
        bounds.extend(new google.maps.LatLng(center.lat() + offset, center.lng() + offset));
        bounds.extend(new google.maps.LatLng(center.lat() - offset, center.lng() - offset));
        map.fitBounds(bounds); 

      }


      // Marker Clusterer Init
      // ----------------------------------------------- //

      var options = {
          imagePath: 'images/',
          styles : clusterStyles,
          minClusterSize : 2
      };

      markerCluster = new MarkerClusterer(map, allMarkers, options);

      google.maps.event.addDomListener(window, "resize", function() {
          var center = map.getCenter();
          google.maps.event.trigger(map, "resize");
          map.setCenter(center);
      });



      // Custom User Interface Elements
      // ----------------------------------------------- //

      // Custom Zoom-In and Zoom-Out Buttons
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);

        function ZoomControl(controlDiv, map) {

          zoomControlDiv.index = 1;
          map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
          // Creating divs & styles for custom zoom control
          controlDiv.style.padding = '5px';
          controlDiv.className = "zoomControlWrapper";

          // Set CSS for the control wrapper
          var controlWrapper = document.createElement('div');
          controlDiv.appendChild(controlWrapper);

          // Set CSS for the zoomIn
          var zoomInButton = document.createElement('div');
          zoomInButton.className = "custom-zoom-in";
          controlWrapper.appendChild(zoomInButton);

          // Set CSS for the zoomOut
          var zoomOutButton = document.createElement('div');
          zoomOutButton.className = "custom-zoom-out";
          controlWrapper.appendChild(zoomOutButton);

          // Setup the click event listener - zoomIn
          google.maps.event.addDomListener(zoomInButton, 'click', function() {
            map.setZoom(map.getZoom() + 1);
          });

          // Setup the click event listener - zoomOut
          google.maps.event.addDomListener(zoomOutButton, 'click', function() {
            map.setZoom(map.getZoom() - 1);
          });

      }


      // Scroll enabling button
      var scrollEnabling = $('#scrollEnabling');

      $(scrollEnabling).click(function(e){
          e.preventDefault();
          $(this).toggleClass("enabled");

          if ( $(this).is(".enabled") ) {
             map.setOptions({'scrollwheel': true});
          } else {
             map.setOptions({'scrollwheel': false});
          }
      });


      // Geo Location Button
      $("#geoLocation, .form-field-_address-container a").click(function(e){
          
          e.preventDefault();
          geolocate();
      });

      function geolocate() {

          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function (position) {
                  var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                  map.setCenter(pos);
                  map.setZoom(12);
              });
          }
      }

    };

      // Geo location button
      $(".geoLocation, .form-field-_address-container a").on("click", function (e) {
          e.preventDefault();
          geolocate();
      });

      function geolocate() {

          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function (position) {
                  var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                  var latitude = position.coords.latitude;
                  var longitude = position.coords.longitude;
                  if(map){
                  map.setCenter(pos);
                  map.setZoom(12);  
                  }
                  
                  var geocoder = new google.maps.Geocoder();
                  geocoder.geocode( { 'latLng': pos}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      if (results[1]) {
                        $('#location_search').val(results[1].formatted_address);
                        
                      }
                    }else{
                      console.log("Geocode was not successful for the following reason: " + status);
                    }
                  });
              });
          }
      }



    // Map Init
    var map_html =  document.getElementById('map');
    if (typeof(map_html) != 'undefined' && map_html != null) {
      google.maps.event.addDomListener(window, 'load',  mainMap);
      //google.maps.event.addDomListener(window, 'resize',  mainMap);
    }


    // ---------------- Main Map / End ---------------- //


    // Single Listing Map
    // ----------------------------------------------- //

    function singleListingMap() {

      var myLatlng = new google.maps.LatLng({lng: parseFloat($( '#singleListingMap' ).data('longitude')) ,lat: parseFloat($( '#singleListingMap' ).data('latitude')), });

      var single_map = new google.maps.Map(document.getElementById('singleListingMap'), {
        zoom: 15,
        center: myLatlng,
        scrollwheel: false,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        panControl: false,
        navigationControl: false,
        streetViewControl: false,
        styles:  [{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"23"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#f38eb0"}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"color":"#ced7db"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#ffa5a8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c7e5c8"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#d6cbc7"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c4c9e8"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#b1eaf1"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"100"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"},{"lightness":"100"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffd4a5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffe9d2"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"weight":"3.00"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"weight":"0.30"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"36"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"color":"#e9e5dc"},{"lightness":"30"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":"100"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d2e7f7"}]}]
      });

      // Steet View Button
      $('#streetView').click(function(e){
         e.preventDefault();
         single_map.getStreetView().setOptions({visible:true,position:myLatlng});
         // $(this).css('display', 'none')
      });


      // Custom zoom buttons
      var zoomControlDiv = document.createElement('div');
      var zoomControl = new ZoomControl(zoomControlDiv, single_map);

      function ZoomControl(controlDiv, single_map) {

        zoomControlDiv.index = 1;
        single_map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);

        controlDiv.style.padding = '5px';

        var controlWrapper = document.createElement('div');
        controlDiv.appendChild(controlWrapper);

        var zoomInButton = document.createElement('div');
        zoomInButton.className = "custom-zoom-in";
        controlWrapper.appendChild(zoomInButton);

        var zoomOutButton = document.createElement('div');
        zoomOutButton.className = "custom-zoom-out";
        controlWrapper.appendChild(zoomOutButton);

        google.maps.event.addDomListener(zoomInButton, 'click', function() {
          single_map.setZoom(single_map.getZoom() + 1);
        });

        google.maps.event.addDomListener(zoomOutButton, 'click', function() {
          single_map.setZoom(single_map.getZoom() - 1);
        });

      }


      // Marker
      var singleMapIco =  "<i class='"+$('#singleListingMap').data('map-icon')+"'></i>";

      new CustomMarker(
        myLatlng,
        single_map,
        {
          marker_id: '1'
        },
        singleMapIco
      );


    }

    // Single Listing Map Init
    var single_map =  document.getElementById('singleListingMap');
    if (typeof(single_map) != 'undefined' && single_map != null) {
      google.maps.event.addDomListener(window, 'load',  singleListingMap);
    }

    // -------------- Single Listing Map / End -------------- //


    function submitPropertyMap() {
    var submitcenter;

      if(listeo_core.submitCenterPoint) {
        var latlngStr = listeo_core.submitCenterPoint.split(",",2);
        var lat = parseFloat(latlngStr[0]);
        var lng = parseFloat(latlngStr[1]);
        submitcenter = new google.maps.LatLng(lat, lng);
      } else {
        submitcenter = new google.maps.LatLng(-33.92, 151.25);
      }
        geocoder = new google.maps.Geocoder();
        if($('#_geolocation_long').val() && $('#_geolocation_lat').val()) {
          submitcenter = {lng: parseFloat($( '#_geolocation_long' ).val()),lat: parseFloat($('#_geolocation_lat').val()) };
        }
        var submit_map = new google.maps.Map(document.getElementById('submit_map'), {
          zoom: 10,
          center:submitcenter,
          scrollwheel: false,
          zoomControl: true,
          zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
          },
          mapTypeControl: false,
          scaleControl: false,
          panControl: false,
          navigationControl: false,  
          streetViewControl: false,
          styles:  [{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"23"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#f38eb0"}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"color":"#ced7db"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#ffa5a8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c7e5c8"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#d6cbc7"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c4c9e8"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#b1eaf1"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"100"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"},{"lightness":"100"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffd4a5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffe9d2"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"weight":"3.00"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"weight":"0.30"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"36"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"color":"#e9e5dc"},{"lightness":"30"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":"100"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d2e7f7"}]}]

        });

        var marker = new google.maps.Marker({
            position: submitcenter,
            map: submit_map,
            draggable:true,
            animation   : google.maps.Animation.DROP,       
        });

        var mainmarker = marker;

        google.maps.event.addListener(marker, 'dragend', function(evt){
          $("#_geolocation_lat").val(evt.latLng.lat());
          $("#_geolocation_long").val(evt.latLng.lng());
        
          geocoder.geocode({
            latLng: this.getPosition()
          }, function(responses) {
            if (responses && responses.length > 0) {
              marker.formatted_address = responses[0].formatted_address;
            } else {
              marker.formatted_address = 'Cannot determine address at this location.';
            }
            $("#_address").val(marker.formatted_address);
          });
        });


        $("#_address").geocomplete(geooptions).bind("geocode:result", function(event, result){
          var loc = result.geometry.location,
              lat = loc.lat(),
              lng = loc.lng();
              $("#_geolocation_lat").val(lat);
              $("#_geolocation_long").val(lng);
              moveMarker(mainmarker,loc);
              submit_map.panTo(loc);
        }); 



    }
    function moveMarker( marker, position ) {
        marker.setPosition( position );
    }

        
    $("#location_search").geocomplete(geooptions);

 // Geo location button
      $(".geoLocation").on("click", function (e) {
          e.preventDefault();
         
          geolocate_nomap();
      });

      function geolocate_nomap() {

          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function (position) {
                  var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                  var latitude = position.coords.latitude;
                  var longitude = position.coords.longitude;
                 
                  var geocoder = new google.maps.Geocoder();
                  geocoder.geocode( { 'latLng': pos}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      if (results[1]) {
                        $('#location_search').val(results[1].formatted_address);
                        $('#keyword_search').val(results[1].formatted_address);
                      }
                    }else{
                      console.log("Geocode was not successful for the following reason: " + status);
                    }
                  });
              });
          }
      }

        // Map Init
    var submit_map_cont =  document.getElementById('submit_map');
    if (typeof(submit_map_cont) != 'undefined' && submit_map_cont != null) {
        google.maps.event.addDomListener(window, 'load',  submitPropertyMap);
        google.maps.event.addDomListener(window, 'resize',  submitPropertyMap);
    }
    // Custom Map Marker
    // ----------------------------------------------- //

    function CustomMarker(latlng, map, args, markerIco) {
      this.latlng = latlng;
      this.args = args;
      this.markerIco = markerIco;
      this.setMap(map);
    }

    CustomMarker.prototype = new google.maps.OverlayView();

    CustomMarker.prototype.draw = function() {

      var self = this;

      var div = this.div;

      if (!div) {

        div = this.div = document.createElement('div');
        div.className = 'map-marker-container';

        div.innerHTML = '<div class="marker-container">'+
                            '<div class="marker-card">'+
                               '<div class="front face">' + self.markerIco + '</div>'+
                               '<div class="back face">' + self.markerIco + '</div>'+
                               '<div class="marker-arrow"></div>'+
                            '</div>'+
                          '</div>';


        // Clicked marker highlight
        google.maps.event.addDomListener(div, "click", function(event) {
            $('.map-marker-container').removeClass('clicked infoBox-opened');
            google.maps.event.trigger(self, "click");
            $(this).addClass('clicked infoBox-opened');
        });


        if (typeof(self.args.marker_id) !== 'undefined') {
          div.dataset.marker_id = self.args.marker_id;
        }

        var panes = this.getPanes();
        panes.overlayImage.appendChild(div);
      }

      var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

      if (point) {
        div.style.left = (point.x) + 'px';
        div.style.top = (point.y) + 'px';
      }
    };

    CustomMarker.prototype.remove = function() {
      if (this.div) {
        this.div.parentNode.removeChild(this.div);
        this.div = null; $(this).removeClass('clicked');
      }
    };

    CustomMarker.prototype.getPosition = function() { return this.latlng; };

    // -------------- Custom Map Marker / End -------------- //

  
  });
}(jQuery));
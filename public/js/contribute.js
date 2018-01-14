function initAutocomplete() {

        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 28.6139, lng: 77.2090},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');

        var searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
}

$(document).ready(function() { 

$('#categoriesInput').tagsinput({});

$( ".add_tip_btn" ).on( "click", function() {
  $('#tip_section').append('<textarea class="form-control alert-warning" name="tip[]" rows="4" placeholder="Add tip to your place" ></textarea>');
});

$( ".remove_tip_btn" ).on( "click", function() {
  $( "#tip_section textarea" ).each(function( index ) {
     if($( this ).val().trim()=="") {
       $( this ).remove(); 
     }
  });

});

$(".suggestion_name").on('blur',function(){
    $('.suggestion_location').val($('.suggestion_name').val()+" "+global_search_append_str);
    $('.suggestion_location').focus(); 
});

$(".suggestion_location").on('blur',function(){
    $('.bootstrap-tagsinput').focus(); 
});

 CKEDITOR.replace( 'detailed_input' );

}); 
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
    <title>Directions service</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
#floating-panel {
  position: absolute;  
  top: 10px;
  left: 25%;
  z-index: 5;
  background-color: #fff;
  padding: 5px;
  border: 1px solid #999;
  text-align: center;
  font-family: 'Roboto','sans-serif';
  line-height: 30px;
  padding-left: 10px;
}

#start, #end {
  background-color: #fff;
  font-family: Roboto;
<!--  font-size: 15px; -->
<!--  font-weight: 300;  -->
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px; 
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}


    </style>
  </head>
  <body>


    <div id="floating-panel" class="row">
    <b>Start: </b>

	<input id="start" onchange="calcRoute();" class="controls" type="text" placeholder="Search Box">

    <b>End: </b>

	<input id="end" onchange="calcRoute();" class="controls" type="text" placeholder="Search Box">

     <span id="total">Total: </span>

    </div>

    <div id="start1"></div>
    <div id="end1"></div>



    <div id="map"></div>
    <script>
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11,
    center: {lat: 54.71, lng: 20.51},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  directionsDisplay.addListener('directions_changed', function() {
    computeTotalDistance(directionsDisplay.getDirections());
  });

  directionsDisplay.setMap(map);

  var onChangeHandler = function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  };
  document.getElementById('start').addEventListener('change', onChangeHandler);
  document.getElementById('end').addEventListener('change', onChangeHandler);

  var defaultBounds = new google.maps.LatLngBounds(
  new google.maps.LatLng(54.8188, 20.0532),
  new google.maps.LatLng(54.6058, 20.9149));


  var options = {
	componentRestrictions: {country: 'ru'},
	bounds: defaultBounds,
	types: ['address']
	};

// Create the search box and link it to the UI element.
  var input = document.getElementById('start');
  var searchBox = new google.maps.places.Autocomplete(input, options);

  //var searchBox = new google.maps.places.SearchBox(input);
//  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  var input2 = document.getElementById('end');
  var searchBox2 = new google.maps.places.Autocomplete(input2, options);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  map.addListener('bounds_changed', function() {
    searchBox2.setBounds(map.getBounds());
  });


}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  directionsService.route({
    origin: document.getElementById('start').value,
    destination: document.getElementById('end').value,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function computeTotalDistance(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  document.getElementById('total').innerHTML = total + ' km';
  document.getElementById('start1').innerHTML = document.getElementById('start').value;
  document.getElementById('end1').innerHTML = document.getElementById('end').value;
}



    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAr1rxZY8MquNLG9e7YgVokiQAF1x8TZEA&signed_in=true&libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>

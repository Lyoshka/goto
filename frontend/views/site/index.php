<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\IndexForm */

use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$script = <<< JS
jQuery(function($){
   $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#phone").mask("+7(999)999-99-99");
   $("#kod").mask("9999");
});

$(document).ready(function(){
    $("#myModal").click(function(){
        $("#modal").modal('show');
    });
});
$('#modal-btn').on('click', function() {
        $('#openModal').modal('show')
    });


window.initMap = function(){
  var origin_place_id = null;
  var destination_place_id = null;
  var travel_mode = google.maps.TravelMode.WALKING;


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

  var origin_input = document.getElementById('start');
  var destination_input = document.getElementById('end');

  var origin_autocomplete = new google.maps.places.Autocomplete(origin_input);
  origin_autocomplete.bindTo('bounds', map);
  var destination_autocomplete =
      new google.maps.places.Autocomplete(destination_input);
  destination_autocomplete.bindTo('bounds', map);



function expandViewportToFitPlace(map, place) {
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
  }

  origin_autocomplete.addListener('place_changed', function() {
    var place = origin_autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    expandViewportToFitPlace(map, place);

    // If the place has a geometry, store its place ID and route if we have
    // the other place ID
    origin_place_id = place.place_id;
    route(origin_place_id, destination_place_id, travel_mode,
          directionsService, directionsDisplay);
  });

  destination_autocomplete.addListener('place_changed', function() {
    var place = destination_autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    expandViewportToFitPlace(map, place);

    // If the place has a geometry, store its place ID and route if we have
    // the other place ID
    destination_place_id = place.place_id;
    route(origin_place_id, destination_place_id, travel_mode,
          directionsService, directionsDisplay);
  });

  function route(origin_place_id, destination_place_id, travel_mode,
                 directionsService, directionsDisplay) {
    if (!origin_place_id || !destination_place_id) {
      return;
    }
    directionsService.route({
      origin: {'placeId': origin_place_id},
      destination: {'placeId': destination_place_id},
      travelMode: travel_mode
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
  document.getElementById('total').innerHTML = 'Дистанция: ' + total + ' km';
}

}

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

$this->title = 'GoTo WEB';
?>

<header class="header" data-stellar-background-ratio="0.5" id="home">
	<div class="color-overlay">
	                              
	<div class="container">
	    <div class="row hi-line">

	        <a class="menu-country" href="#">Россия</a>
	        <a class="menu-city" href="#">Калининград</a>

	    </div>
	    <div class="row">
			<div class="intro">
	    		<h1>GoTo WEB - современный сервис перевозок :)</h1>
			</div>
			<div class="white-line"> </div>
	    </div>
	    <div class="row inputs-main main">
	        <div class="col-md-5">
	           <p>Откуда</p>
		       <input type="text" id="start" name="street" class="form-control input-lg input-main" placeholder="Адрес">
			</div>
			
	        <div class="col-md-2">
	        </div>
	        <div class="col-md-5">
				<p>Куда</p>
				<input type="text" id="end" class="form-control input-lg input-main" placeholder="Адрес">
			</div>
	    </div>
		
		<div class="row input-main">
			     <span id="total"></span>
		</div>
		
	    <div class="row">
			<div class="btn-main">	
				<div class="buttons wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
					<a href="#" class="btn btn-success btn-lg standard-button"><i class="icon-app-store"></i>Заказать такси</a>
				</div>

            </div>
	    </div>


	   </div>

	</div>
</header>

<section id="map-container">
	<div id="map" style="width: 100%; height: 600px"></div>        
</section>



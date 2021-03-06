<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\IndexForm */
/* @var $tarif \frontend\models\Tarif */

use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveField;
use yii\helpers\ArrayHelper;
use frontend\models\Tarif;
use frontend\widgets\JobWidget;

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

//*******************************************************
// Обработка нажатия на кнопку 'Вызов такси'
//*******************************************************
$('#send-button').click(function() {
    //$('#openModal').modal('show');

	if ( document.getElementById('phone').value == ""  ) {
	     alert('Заполните номер телефона');
	} else {
	    document.getElementById('kod').style.display = "block";		
	    document.getElementById('signup-button').style.display = "block";		
	    document.getElementById('send-button').style.backgroundColor = "grey";
	    document.getElementById('send-button').innerHTML = "Выслать СМС код";	    
	}
});

//*******************************************************
// Карта Google
//*******************************************************
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
  
/* 
 var infoWindow = new google.maps.InfoWindow({map: map});

  
  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Вы');
	  map.setZoom(14);
	  map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
*/

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
  var price = 0;
  var myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  price = total * document.getElementById('indexform-codesms').value; 
  document.getElementById('total').innerHTML = 'Дистанция: ' + total.toFixed(0) + ' km';
  document.getElementById('price').innerHTML = 'Стоимость: ' + price.toFixed(0) + ' руб';
  }
  
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
  }

}

new CBPFWTabs( document.getElementById( 'tabs' ) );

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

$this->title = 'GoTo WEB';
?>


	<div class="col-md-3">
	                             
		<div class="container-tab">

			<div id="tabs" class="tabs">
				<nav>
					<ul>
						<li><a href="#section-1"><span>Заказ такси</span></a></li>
						<li><a href="#section-2"><span>Мои заказы</span></a></li>
					</ul>
				</nav>
				<div class="content">
					<section id="section-1">
					        <?php 	$form = ActiveForm::begin( ); ?>
						
						<div class="row">
							<input type="text" id="start" class="form-control" placeholder="Откуда">
						</div>
						<hr>
						<div class="row">
							<input type="text" id="end" class="form-control" placeholder="Куда">
						</div>
						<hr>
						<?php echo $form->field($model, 'username', ['enableLabel' => false] )->textInput(array('placeholder'=>'Телефон', 'id'=>'phone'));  ?>

						<?php  if (  Yii::$app->user->isGuest  ) { ?>
						    <p><a href="#" class="btn btn-success" id="send-button">Вход</a> </p>
                                                <?php } 	?>

<?php Pjax::begin(); ?>
    <?= Html::a(
        'Обновить',
        ['check-username'],
        ['class' => 'btn btn-lg btn-primary']
    ) ?>
    <p>User: <?php echo $user_id ?></p>
<?php Pjax::end(); ?>

						<?php echo $form->field($model, 'codeSMS', ['enableLabel' => false] )->textInput(array('placeholder'=>'SMS код', 'id'=>'kod'));  ?>

						<?= Html::submitButton('Заказать такси', ['class' => 'btn btn-success', 'id' => 'signup-button']) ?>
		
                                                <?php ActiveForm::end(); ?>

					</section>
					<section id="section-2">
							<p>Вы не авторизованы</p>
					</section>
				</div>
			</div>

		</div>

    <div id="openModal" class="modalDialog">
	<div>
		<h2>Ведите код для входа</h2>
		<div class="row">
			<h3></h3>
		</div>
		<Hr>
		    <div class="row">
   		<?php Pjax::begin(); ?>
			<div class="col-md-6 col-md-offset-3">
   				<input type="text" id="end" class="form-control" placeholder="КОД">
			</div>
   		<?php Pjax::end(); ?>
		    </div>

		<Hr>
		<p><a class="btn btn-lg btn-success close1" href="#">Вход</a></p>
	</div>
    </div>


	</div>

	<div class="col-md-9 no-padd">

	<div id="map1" style="width: 100%; height: 1000px"></div>        

	</div>

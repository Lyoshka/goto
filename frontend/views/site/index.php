<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\IndexForm */

use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

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
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

$this->title = 'GoToWEB';

//$coord = new LatLng(['lat' => 54.709545, 'lng' => 20.510527]);
$coord = new LatLng(['lat' => 39.720089311812094, 'lng' => 2.91165944519042]);
$map = new Map([
    'center' => $coord,
    'zoom' => 12,
]);

// lets use the directions renderer
$home = new LatLng(['lat' => 39.720991014764536, 'lng' => 2.911801719665541]);
$school = new LatLng(['lat' => 39.719456079114956, 'lng' => 2.8979293346405166]);
$santo_domingo = new LatLng(['lat' => 39.72118906848983, 'lng' => 2.907628202438368]);
 
// setup just one waypoint (Google allows a max of 8)
$waypoints = [
    new DirectionsWayPoint(['location' => $santo_domingo])
];
 
$directionsRequest = new DirectionsRequest([
    'origin' => $home,
    'destination' => $school,
    'waypoints' => $waypoints,
    'travelMode' => TravelMode::DRIVING
]);
 
// Lets configure the polyline that renders the direction
$polylineOptions = new PolylineOptions([
    'strokeColor' => '#FFAA00',
    'draggable' => true
]);
 
// Now the renderer
$directionsRenderer = new DirectionsRenderer([
    'map' => $map->getName(),
    'polylineOptions' => $polylineOptions
]);
 
// Finally the directions service
$directionsService = new DirectionsService([
    'directionsRenderer' => $directionsRenderer,
    'directionsRequest' => $directionsRequest
]);
 
// Thats it, append the resulting script to the map
$map->appendScript($directionsService->getJs());
 

?>

<div class="site-index">


<div class="col-md-6 login-form">

    <?php    if (!Yii::$app->user->isGuest) { ?>

    <h2><?php echo Yii::$app->user->identity->username; ?>  

	<!-- <a href="#" ><img src="images/exit.png" width="20" title="Выход"> </a>   -->

	  <?php echo Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username  . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
           ?>

    </h2> 

    <?php  }  ?>


    <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'form-booking', 'options' => ['class' => 'form-2'] ]); ?>
	        <h1><span class="sign-up">Заказать такси</span></h1>
	            <span class="col-md-6">
                	<?= $form->field($model, 'username')->textInput(['id' => 'from'])->label('Откуда') ?>
                    </span>
		    <span class="col-md-6">
                	<?= $form->field($model, 'codeSMS')->textInput(['id' => 'to'])->label('Куда') ?>
                    </span>




                <div class="col-md-6">
                	<?= $form->field($model, 'codeSMS') ->dropDownList(['1' => 'Эконом', '2' => 'Комфорт', '3' => 'Бизнес', ], [ 'prompt' => 'Выберите тариф', 'options' => [ '1' => ['Selected' => true] ] ])->label('Тариф') ?>
                </div>

                <div class="col-md-6">
                	<?= $form->field($model, 'codeSMS')->textInput(['id' => 'to'])->label('Телефон') ?>
                </div>
		  <hr>
  		  <p class="clearfix col-md-offset-4">
       			 <input type="submit" name="Submit" value="Заказать такси">
   		 </p>      

            <?php ActiveForm::end(); ?>

<!--
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'form-2'] ]); ?>
	        <h1><span class="log-in">Войти</span> или <span class="sign-up">зарегистрироваться</span></h1>

                <?= $form->field($model, 'username')->textInput(['id' => 'phone'])->label('Телефон') ?>

                <?= $form->field($model, 'codeSMS')->textInput(['id' => 'kod'])->label('КОД') ?>

                <div class="form-group">
                </div>
  		  <p class="clearfix">
			 <?= Html::a('Получить код по СМС',Url::toRoute(['index']),['class' => 'log-twitter']) ?>
       			 <input type="submit" name="Submit" value="Войти">
   		 </p>      

            <?php ActiveForm::end(); ?>

-->

        </div>


  </div>

  <div class="col-md-6">


     <div id="googlemaps" style="width: 100%"><?php echo $map->display(); ?></div>        



  </div>  


    <div id="openModal" class="modalDialog">
	<div>
		<h2>Ваш код для входа</h2>
		<Hr>

   		<?php Pjax::begin(); ?>
		    <?php if (!Yii::$app->user->isGuest) { ?>
   			<h2><?php echo $model->codeSMS; ?></h2>
		    <?php }  ?>
   		<?php Pjax::end(); ?>

		<Hr>
		<p><a class="btn btn-lg btn-success close1" href="#">OK</a></p>
	</div>
    </div>

</div>

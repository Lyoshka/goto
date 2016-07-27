<?php
use yii\bootstrap\ActiveForm;
use frontend\models\Tarif;
use yii\widgets\ActiveField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


	$items_cat=[
	   1=>'Пассажирские перевозки',
	   2=>'Грузовые перевозки',
	   3=>'Спецтехника',
	];

	$items_type=[
	   1=>'Обычная',
	   2=>'Аукцион',
	];

	$items_dop=[
	   0=>'Дополнительные услуги ...',
	   1=>'Перевозка животных',
	   2=>'Перевозка лыж или сноуборда',
	   3=>'Встреча с табличкой',
	   4=>'Бгаж в салоне',
	];

	echo '<div class="main-block">';
	$form = ActiveForm::begin(); 
	$tarifs = Tarif::find()->all(); 
	$items = ArrayHelper::map($tarifs,'price','name'); 

	echo '<div class="row">';
		echo '<div class="col-md-4">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->dropDownList($items_cat); 
		echo '</div>';

		echo '<div class="col-md-4">';
		echo '</div>';

		echo '<div class="col-md-4">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->dropDownList($items_type); 
		echo '</div>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="col-md-6">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->textInput(array('placeholder'=>'Откуда', 'id'=>'start')); 
			//echo '<input type="text" id="start" name="street" class="form-control" placeholder="Откуда">';
		echo '</div>';
		echo '<div class="col-md-6">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->textInput(array('placeholder'=>'Куда', 'id'=>'end')); 
			//echo '<input type="text" id="start" name="street" class="form-control" placeholder="Куда">';
		echo '</div>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="col-md-4">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->dropDownList($items); 
		echo '</div>';

		echo '<div class="col-md-3">';
		echo '</div>';

		echo '<div class="col-md-5">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->textInput(array('placeholder'=>'Телефон', 'id'=>'phone')); 
		echo '</div>';
	echo '</div>';

	echo '<hr>';

	echo '<div class="row">';
		echo '<div class="col-md-4">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->dropDownList($items_dop); 
		echo '</div>';

		echo '<div class="col-md-8">';
			echo '<div class="form-group">';
				echo Html::submitButton('Заказать такси', ['class' => 'btn-lg btn-success', 'name' => 'signup-button']);
			echo '</div>';
		echo '</div>';
	echo '</div>';

	echo '<hr>';

	echo '<div class="row">';
		echo '<div class="col-md-12">';
			echo $form->field($model, 'text', ['enableLabel' => false] )->textArea(array('placeholder'=>'Коментарии', 'id'=>'memo')); 
		echo '</div>';
	echo '</div>';

	
	ActiveForm::end(); 
	echo '</div>';


?>
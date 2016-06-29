<?php

/* @var $this yii\web\View */

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
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

$this->title = 'GoToWEB';
?>
<div class="site-index">
<div class="col-md-6 login-form">
<!--      moya-pervaya-novost
    <h3>Для заказа нужно пройти авторизацию</h3>

    <input  id="phone" type="tel" class="form-control" placeholder="Номер телефона" size="40">
-->
  <form class="form-2">
    <h1><span class="log-in">Войти</span> или <span class="sign-up">зарегистрироваться</span></h1>
    <p class="float">
        <label for="login"><i class="icon-user"></i>Телефон</label>
        <input type="text" id="phone" placeholder="Номер телефона">
    </p>
    <p class="float">
        <label for="kod"><i class="icon-lock"></i>Код</label>
        <input type="text" id="kod" placeholder="Код СМС">
    </p>
    <p class="clearfix">
        <a href="#openModal" class="log-twitter">Получить код по СМС</a>   
        <input type="submit" name="submit" value="Войти">
    </p>      
  </form>

  </div>

  <div class="col-md-6">
    <div class="jumbotron">
        <h1>Добро пожаловать</h1>


        <p class="lead">GoToWEB сервис перевозок.</p>

        <p><a class="btn btn-lg btn-success" href="#">Связаться с нами</a></p>
    </div>

    <div class="body-content">


    <div id="openModal" class="modalDialog">
	<div>
		<h2>Ваш код для входа</h2>
		<Hr>
		<h2>4545</h>
		<Hr>
		<p><a class="btn btn-lg btn-success close1" href="#">OK</a></p>
	</div>
    </div>


    </div>

  </div>  

</div>

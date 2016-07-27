<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
 
class JobWidget extends Widget
{

   public $message;
   public $model;                        

   /**
     * Запуск виджета
     */
    public function run()
    {   
	return $this->render('newjob',['model'=>$this->model]);
    }
}

?>
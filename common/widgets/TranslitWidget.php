<?php

namespace common\widgets;

use yii\helpers\Html;

class TranslitWidget extends \yii\bootstrap\Widget
{
    public $url;
    // функция описывает определенные действия
    public function init(){
        parent::init();
            // устанавливаем кодировку 
            mb_http_input('UTF-8');
            mb_http_output('UTF-8');
            mb_internal_encoding("UTF-8");
            
            $this->url = (string )$this->url; // преобразуем в строковое значение
            $this->url = strip_tags($this->url); // убираем HTML-теги
            $this->url = str_replace(array("\n", "\r"), " ", $this->url); // убираем перевод каретки
            $this->url = preg_replace("/\s+/", ' ', $this->url); // удаляем повторяющие пробелы
            $this->url = trim($this->url); // убираем пробелы в начале и конце строки
                        
            $this->url = function_exists('mb_strtolower') ? mb_strtolower($this->url) : strtolower($this->url); // переводим строку в нижний регистр (иногда надо задать локаль)
            $this->url = strtr($this->url, array('а' => 'a','б' => 'b','в' => 'v','г' => 'g','д' => 'd','е' => 'e','ё' => 'e','ж' => 'j','з' => 'z','и' => 'i','й' => 'y','к' => 'k',
                'л' => 'l','м' => 'm','н' => 'n','о' => 'o','п' => 'p','р' => 'r','с' => 's','т' => 't','у' => 'u','ф' => 'f','х' => 'h','ц' => 'c','ч' => 'ch','ш' => 'sh','щ' => 'shch',
                'ы' => 'y','э' => 'e','ю' => 'yu','я' => 'ya','ъ' => '','ь' => ''));
            $this->url = preg_replace("/[^0-9a-z-_ ]/i", "", $this->url); // очищаем строку от недопустимых символов
            $this->url = str_replace(" ", "-", $this->url); // заменяем пробелы знаком минус
    }
    // возвращаем результат
    public function run(){
        return Html::encode($this->url);
    }
}

?>
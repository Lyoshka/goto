<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/jquery.maskedinput.min.js',
	'https://maps.googleapis.com/maps/api/js?key=AIzaSyAr1rxZY8MquNLG9e7YgVokiQAF1x8TZEA&signed_in=true&libraries=places&callback=initMap',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD, 'async'=>'async', 'defer'=>'defer'];
}

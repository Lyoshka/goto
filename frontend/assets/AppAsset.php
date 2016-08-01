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
	'css/demo.css',
	'css/component.css',
    ];
    public $js = [
        'js/jquery.maskedinput.min.js',
	'js/cbpFWTabs.js',
	'https://maps.googleapis.com/maps/api/js?key=AIzaSyAr1rxZY8MquNLG9e7YgVokiQAF1x8TZEA&signed_in=true&libraries=places&callback=initMap',
	'http://html5shiv.googlecode.com/svn/trunk/html5.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD, 'async'=>'async', 'defer'=>'defer'];
}

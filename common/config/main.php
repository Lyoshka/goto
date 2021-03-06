<?php
return [
    'language' => 'ru-RU',
//    'language' => 'en-US',
    'sourceLanguage' => 'ru-RU',
    'name' => 'GoToWEB',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/auth' => 'auth.php'
                    ]
                ],
            ],
        ],


        'authManager' => [
            'class' => 'yii\rbac\DbManager', 
        ],

	'assetManager' => [
        'bundles' => [
            'dosamigos\google\maps\MapAsset' => [
                'options' => [
                    'key' => 'AIzaSyAr1rxZY8MquNLG9e7YgVokiQAF1x8TZEA',
                    'language' => 'ru-RU',
                    'version' => '3.1.18'
                 ]
              ]
           ]
        ],

    ],


    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
	    'layout' => 'left-menu',
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '89.110.62.*', '95.140.92.*', '78.25.122.62'],
        ],
    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
	    'gii/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],

];

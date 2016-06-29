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

	'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
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
    ],
];

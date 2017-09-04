<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'test.akuznecov.ru',

    'name'=>'test.akuznecov.ru',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-AIrBsAV18R2WgiT433ccARcCrj1rVlh',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','trace','info'],//,'trace','info'
                ],
            ],
        ],

        'db' => $db,

       'urlManager' => [
            'enablePrettyUrl' => true,

            'showScriptName' => false,
            'enableStrictParsing' => false,
            'suffix'=>'/',
            'rules' =>
                [
                    '/'=>'name/index',
                    '<action>' => 'name/<action>',
                    '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                    '<controller:(post|comment)>/<id:\d+>' => '<controller>/view',
                    '<controller:(post|comment)>s' => '<controller>/index',

                    '<module:\w+>/<_c:[\w\-]+>/view/<id:\d+>' => '<module>/<_c>/view',
                    '<module:\w+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<module>/<_c>/<_a>',
                    '<module:\w+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<module>/<_c>/<_a>',
                ]
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
       // 'allowedIPs' => ['127.0.0.1', '::1','*'],
        'allowedIPs' => ['127.0.0.1', '::1','176.195.84.78'],
        'panels' => [
            'views' => ['class' => 'app\panels\ViewsPanel'],
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
      'allowedIPs' => ['127.0.0.1', '::1','176.195.84.78'],
    ];
}

return $config;

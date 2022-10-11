<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'manager' =>[
            'class' => 'app\modules\manager\Module',

        ]
    ],
    'language' => "ru",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
       'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' =>  'smtp.send-box.ru',
                'username' => 'sendbox@jobgis.ru',
                'password' => 'Ekq27Kb6p3s',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Asasd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_m:debug>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',

            ],
        ],
        
    ],
    'params' => $params,
];


    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
	'class' => 'yii\debug\Module',
	'allowedIPs' => ['*'],		
	'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
	'panels' => [
	        'db' => [
	            'class' => 'yii\debug\panels\DbPanel',
	            'defaultOrder' => [
	                'seq' => SORT_ASC
	            ],
	            'defaultFilter' => [
	                'type' => 'SELECT'
	            ]
	        ],
	    ],
];




return $config;

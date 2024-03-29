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

        ],
        'recruiter' => [
            'class' => 'app\modules\recruiter\Module',
        ],
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
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
           'useFileTransport' => false,
                'htmlLayout'=>false,
                'textLayout'=>false,

                'transport' => [
                        'class' => 'Swift_SmtpTransport',
                        'host' => 'smtp.yandex.ru',
                        'username' => 'jobgis.ru@yandex.ru',
                        'password' => 'g02091988G777',
                        'port' => '465',
                        'encryption' => 'ssl',
                ],
        ],
        /*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
         * 
         */
         
        /**
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
         * 
         */


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
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
            ],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'crm' => 'site/hr',
                'privacy' => 'site/personal',
                'cookie' => 'site/cookie',
                'terms' => 'site/terms'
            ],
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

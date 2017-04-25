<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            'modelClasses'  => [
                'User' => 'amnah\yii2\user\models\User',
            ],
            'emailViewPath' => '@app/mail/user', // example: @app/mail/user/confirmEmail.php
        ],
        'finance' => [
            'class' => 'app\finance\Finance',
        ],
        'payroll' => [
            'class' => 'app\payroll\Payroll',
        ],
        'operational' => [
            'class' => 'app\operational\Operational',
        ],
        'master' => [
            'class' => 'app\master\Master',
        ],
        'eprocess' => [
            'class' => 'app\eprocess\eprocess',
        ],        
        'global' => [
            'class' => 'app\global\global',
        ],
        'general' => [
            'class' => 'app\general\general',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
            'identityClass' => 'amnah\yii2\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'formatter' => [
            'class' => 'yii\i18n\formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'Rp ',
            'dateFormat' => 'php:d M Y',
            'datetimeFormat'=>'php:d M Y H:i'
        ],
        'request' => [
            'cookieValidationKey' => '123k4hg123k4hg1234kh12g43',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            // 'class' => 'yii\caching\MemCache',
            // 'servers' => [
            //     [
            //         'host' => 'localhost',
            //         'port' => 11211,
            //         'weight' => 60,
            //     ],
            // ],
            // 'useMemcached' => true,
            // 'serializer' => false,
            // 'options' => [
            //     'Memcached::OPT_COMPRESSION' => false,
            // ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.intra.tunasgroup.com',
                'username' => 'dariaman.siagian@intra.tunasgroup.com',
                'password' => 'D@riaman46',
                'port' => '25',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
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
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

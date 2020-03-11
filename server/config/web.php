<?php

$modules = require __DIR__ . '/modules.php';
$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';
$rules = require __DIR__ . '/rules.php';

$config = [
    'id' => 'yii-api',
    'name' => 'Shop cosmetic',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'default/index',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@upload' => '@app/web/public/'
    ],
    'modules' => $modules,
    'components' => [
        'response' => [
            'class' => 'yii\web\Response'
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/json; charset=UTF-8' => 'yii\web\JsonParser',
            ],
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'cookieValidationKey' => md5('yahve89'),
        ],
        'urlManager' => [
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => $rules,
        ],
        'user' => [
            'enableAutoLogin' => false
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],   
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => '',
                'password' => '',
                'port' => '25',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                  //  'levels' => ['error', 'warning', 'notice'],
                ],
            ],
        ],        
        'db' => $db
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
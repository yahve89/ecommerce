<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require __DIR__ . '/../config/web.php';

if (file_exists(__DIR__ . '/../config/web-local.php')) {
    $local = require __DIR__ . '/../config/web-local.php';
    $config = \yii\helpers\ArrayHelper::merge(
        $config,
        $local
    );
}

(new yii\web\Application($config))->run();
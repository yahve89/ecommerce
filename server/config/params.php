<?php

$params = [
    'adminEmail' => 'dosug-2013@mail.ru',
    'senderEmail' => 'dosug-2013@mail.ru',
    'senderName' => 'Example.com mailer',
    'clientHost' => 'http://localhost:8080'
];

if (file_exists(__DIR__ . '/params-local.php')) {
    $local = require __DIR__ . '/params-local.php';
    $params = \yii\helpers\ArrayHelper::merge(
        $params,
        $local
    );
}

return $params;
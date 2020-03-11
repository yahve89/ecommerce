<?php

namespace app\controllers\bases;

use Yii;

class CorsController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                '*' => ['GET', 'POST', 'PUT', 'HEAD', 'OPTIONS'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [Yii::$app->params['clientHost']],
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Headers' => [
                    'Access-Control-Allow-Headers', 
                    'Origin', 
                    'Accept', 
                    'X-Requested-With', 
                    'Content-Type', 
                    'Access-Control-Request-Method', 
                    'Access-Control-Request-Headers', 
                    'Authorization'
                ]
            ]
        ];
        return $behaviors;
    }
}

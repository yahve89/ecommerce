<?php
namespace app\controllers\bases;

use Yii;
use yii\web\Response;
use yii\base\Security;
use yii\filters\auth\HttpBasicAuth;
use dektrium\user\helpers\Password;
use dektrium\user\models\User;

class AuthController extends CorsController
{

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        Yii::$app->setComponents([
            'response' => [
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_XML,
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    
                    if ($response->data !== null && !empty($response->data['status'])) {
                        if ($response->data['status'] === 401) {
                            $response->statusCode = 204;
                            $headers = $response->headers;
                            $headers->set('Access-Control-Allow-Methods', '*');
                            $headers->set('Access-Control-Allow-Credentials', 'true');
                            $headers->set('Access-Control-Allow-Origin', Yii::$app->params['clientHost']);
                            $headers->set('Content-Type', 'application/json');
                            $headers->set('Access-Control-Max-Age', (int) 3600);
                            $headers->set('Access-Control-Allow-Headers', ['Authorization']);
                        }
                    }
                }
            ]
        ]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    public function auth($email, $password)
    {
        if (!empty($user = User::findOne(['email' => $email]))){
            return Password::validate($password, $user->password_hash) ? $user : null; 
        }

        return null;
    }
} 
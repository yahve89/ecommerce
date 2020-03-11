<?php

namespace app\controllers;

use Yii;
use app\controllers\bases\AuthController;
use app\models\UserProfile;
use app\models\User;

class SecurityController extends AuthController
{
    public function actionSignIn()
    {
        $auth = Yii::$app->authManager;

        foreach ($auth->getRolesByUser(Yii::$app->user->identity->id) as $role) {
            $roleUser = $role->name;    
        }

        return $roleUser;
    }

    public function actionUser()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();

        $response['user']['email'] = Yii::$app->user->identity->email;
        $response['profile'] = $user->userProfile;
        return $response;        
    }

    public function actionUpdateProfile()
    {
        $request = Yii::$app->getRequest();

        if ($request->isPut) {
            foreach ($request->getBodyParams() as $data => $null) {
                foreach (json_decode($data, true)['Profile'] as $key => $value) {
                    $attributes[$key] = str_replace('_', ' ', str_replace('%dot%', '.', $value));
                }
            }

            $model = UserProfile::findOne(['user_id' => Yii::$app->user->identity->id]);
            $model->load($attributes, '');

            if ($model->save() === false && !$model->hasErrors())
                throw new ServerErrorHttpException('Failed');
            
            return $model;
        }
    }

    public function actionSignOut()
    {
        return Yii::$app->user->logout();
    }

}
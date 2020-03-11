<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class MainController extends Controller
{
    /**
     * Создание Ролей по умолчанию 
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createPost);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $user);

        //$auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
}

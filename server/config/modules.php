<?php 

return [
    'user' => [
        'admins' => ['yahve89'],
        'class' => 'dektrium\user\Module',
        'urlRules' => [
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'user',
                'except' => ['*'],
            ]
        ],
        'modelMap' => [
            'User' => 'app\models\User',
        ],
//        'controllerMap' => [
//            'registration' => [
//                'class' => \dektrium\user\controllers\RegistrationController::className(), 'on '
//                .\dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER  => function ($e) {
//                        $auth = Yii::$app->authManager;
//                        $role = $auth->getRole('user');
//                        $user = \dektrium\user\models\User::findOne([
//                            'username' => $e->form->username
//                        ]);
//                        $auth->assign($role, $user->id);
//                    }
//            ]
//        ]
    ],
    'rbac' => [
        'class' => 'dektrium\rbac\RbacWebModule',
        'controllerMap' => [
            'role' => [
                'class' => 'dektrium\rbac\controllers\RoleController',
                //'layout' => '@app/modules/admin/views/layouts/admin',
            ],
            'permission' => [
                'class' => 'dektrium\rbac\controllers\PermissionController',
                //'layout' => '@app/modules/admin/views/layouts/admin',
            ],
            'rule' => [
                'class' => 'dektrium\rbac\controllers\RuleController',
               // 'layout' => '@app/modules/admin/views/layouts/admin',
            ],
        ],
    ]
];
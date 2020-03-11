<?php 

return [
    'site/product/<alias:\S+>' => 'site/product',
    'site/catalog/<alias:\S+>' => 'site/catalog',
    '<controller>' => '<controller>/index',
    '<controller>/<id:\d+>' => '<controller>/view',
    '<controller>/<id:\d+>/<action>' => '<controller>/<action>',
    '<controller>' => '<controller>/index',
    '<controller>/<id:\d+>/<action>' => '<controller>/<action>',
/*    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'default',
        'except' => ['delete', 'create', 'update'],
        'extraPatterns' => [
            'GET index' => 'index',
        ],
    ],*/
];

<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'mongoDbModel' => [
                    'class' => 'yii\mongodb\gii\model\Generator'
                ]
            ],
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\mongodb\rbac\MongoDbManager',
            'defaultRoles' => ['author'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

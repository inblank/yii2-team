<?php
return [
    'id' => 'unitTest',
    'basePath' => __DIR__ . '/../app',
    'components'=>[
        'db'=>[
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=testdb',
            'username' => 'travis',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    'bootstrap'=>[
        [
            'class'=>'inblank\team\Bootstrap',
        ],
    ],
    'modules'=>[
        'user'=>[
            'class'=>'dektrium\user\Module',
            'admins'=>['admin'],
            'enableRegistration'=>false,
        ],
        'team'=>[
            'class'=>'inblank\team\Module',
            'modelMap'=>[
                'User' => 'dektrium\user\models\User',
            ]
        ]
    ],
];

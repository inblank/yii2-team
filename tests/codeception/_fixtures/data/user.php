<?php

$time = time();
$date = date('Y-m-d', $time);
$dateTime = date('Y-m-d H:i:s', $time);
$sec = Yii::$app->security;

return [
    'admin'=>[
        'id'=>1,
        'username'=>'admin',
        'email' => 'admin@example.com',
        'password_hash' => \dektrium\user\helpers\Password::hash('admin'),
        'auth_key'=>$sec->generateRandomString(),
        'created_at'=>time(),
        'updated_at'=>time(),
    ],
    'user'=>[
        'id'=>2,
        'username'=>'user',
        'email' => 'user@example.com',
        'password_hash' => \dektrium\user\helpers\Password::hash('user'),
        'auth_key'=>$sec->generateRandomString(),
        'created_at'=>time(),
        'updated_at'=>time(),
    ],
];

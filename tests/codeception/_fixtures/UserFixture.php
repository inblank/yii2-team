<?php
namespace tests\codeception\_fixtures;

class UserFixture extends \yii\test\ActiveFixture{
    public $modelClass = 'app\models\User';
    public $dataFile = '@tests/codeception/_fixtures/data/user.php';
}

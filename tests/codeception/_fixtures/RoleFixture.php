<?php
namespace tests\codeception\_fixtures;

class RoleFixture extends \yii\test\ActiveFixture{
    public $modelClass = 'inblank\team\models\Role';
    public $dataFile = '@tests/codeception/_fixtures/data/role.php';
}

<?php
namespace tests\codeception\_fixtures;

class MemberFixture extends \yii\test\ActiveFixture{
    public $modelClass = 'inblank\team\models\Member';
    public $dataFile = '@tests/codeception/_fixtures/data/member.php';
}

<?php
namespace tests\codeception\_fixtures;

class TeamFixture extends \yii\test\ActiveFixture{
    public $modelClass = 'inblank\team\models\Team';
    public $dataFile = '@tests/codeception/_fixtures/data/team.php';
}

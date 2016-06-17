<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\History;
use tests\codeception\_fixtures\MemberFixture;
use tests\codeception\_fixtures\RoleFixture;
use tests\codeception\_fixtures\SpecialityFixture;
use tests\codeception\_fixtures\TeamFixture;
use tests\codeception\_fixtures\UserFixture;
use yii;
use yii\codeception\TestCase;

class HistoryTest extends TestCase
{
    use Specify;

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'user' => UserFixture::className(),
            'role' => RoleFixture::className(),
            'speciality' => SpecialityFixture::className(),
            'team' => TeamFixture::className(),
            'member' => MemberFixture::className(),
        ];
    }

    /**
     * General test for model
     */
    public function testCreate()
    {
        $this->specify("we want to add the history record", function () {
            /** @var History $history history record */
            $history = Yii::createObject('inblank\team\models\History');
            expect("we can't add the history without team or user", $history->save())->false();
            expect("we must see error message `team_id`", $history->getErrors('team_id'))->notEmpty();
            expect("we must see error message `user_id`", $history->getErrors('user_id'))->notEmpty();
            $history->team_id = 999;
            $history->user_id = 999;
            expect("we can't add the history with not existing team or user", $history->save())->false();
            expect("we must see error message `team_id`", $history->getErrors('team_id'))->notEmpty();
            expect("we must see error message `user_id`", $history->getErrors('user_id'))->notEmpty();
            $history->team_id = 1;
            $history->user_id = 2;
            expect("we can't add the history if user not in team", $history->save())->false();
            expect("we must see error message `user_id`", $history->getErrors('user_id'))->notEmpty();
            $history->user_id = 1;
            expect("we can't add the history without action", $history->save())->false();
            expect("we must see error message `action`", $history->getErrors('action'))->notEmpty();
            $history->action = History::ACTION_ADD;
            expect("we can add the history", $history->save())->true();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\Member;
use tests\codeception\_fixtures\SpecialityFixture;
use tests\codeception\_fixtures\TeamFixture;
use tests\codeception\_fixtures\UserFixture;
use yii;
use yii\codeception\TestCase;

class MemberTest extends TestCase
{
    use Specify;

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'speciality' => SpecialityFixture::className(),
            'team' => TeamFixture::className(),
            'user' => UserFixture::className(),
        ];
    }

    /**
     * General test for Product model
     */
    public function testCreate()
    {
        $this->specify("we want to create the member without speciality", function () {
            /** @var Member $member */
            $member = Yii::createObject('inblank\team\models\Member');
            expect("we can't create member without team", $member->save())->false();
            expect("we must see error message `team_id`", $member->getErrors('team_id'))->notEmpty();
            $member->team_id = 999;
            expect("we can't create member with not existing team", $member->save())->false();
            expect("we must see error message `team_id`", $member->getErrors('team_id'))->notEmpty();
            $member->team_id = 1;
            expect("we can't create member without user", $member->save())->false();
            expect("we must see error message `user_id`", $member->getErrors('user_id'))->notEmpty();
            expect("we must not see error message `team_id`", $member->getErrors('team_id'))->isEmpty();
            $member->user_id = 999;
            expect("we can't create member wit not existing user", $member->save())->false();
            expect("we must see error message `user_id`", $member->getErrors('user_id'))->notEmpty();
            expect("we must not see error message `team_id`", $member->getErrors('team_id'))->isEmpty();
            $member->user_id = 1;
            expect("we can create member", $member->save())->true();

            $member = Yii::createObject([
                'class' => 'inblank\team\models\Member',
                'team_id' => 1,
                'user_id' => 2,
                'speciality_id' => 999,
            ]);
            expect("we can't create member with not existing speciality", $member->save())->false();
            expect("we must see error message `speciality_id`", $member->getErrors('speciality_id'))->notEmpty();
            $member->speciality_id = 1;
            expect("we can create member with exists speciality", $member->save())->true();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

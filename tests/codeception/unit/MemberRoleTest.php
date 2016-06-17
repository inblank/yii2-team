<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\MemberRole;
use tests\codeception\_fixtures\MemberFixture;
use tests\codeception\_fixtures\RoleFixture;
use tests\codeception\_fixtures\SpecialityFixture;
use tests\codeception\_fixtures\TeamFixture;
use tests\codeception\_fixtures\UserFixture;
use yii;
use yii\codeception\TestCase;

class MemberRoleTest extends TestCase
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
     * General test for Product model
     */
    public function testCreate()
    {
        $this->specify("we want to add the role to member", function () {
            /** @var MemberRole $member role */
            $memberRole = Yii::createObject('inblank\team\models\MemberRole');
            expect("we can't add the role without team or user or role", $memberRole->save())->false();
            expect("we must see error message `team_id`", $memberRole->getErrors('team_id'))->notEmpty();
            expect("we must see error message `user_id`", $memberRole->getErrors('user_id'))->notEmpty();
            expect("we must see error message `role_id`", $memberRole->getErrors('role_id'))->notEmpty();
            $memberRole->team_id = 999;
            $memberRole->user_id = 999;
            $memberRole->role_id = 999;
            expect("we can't add the role with not existing team or user or role", $memberRole->save())->false();
            expect("we must see error message `team_id`", $memberRole->getErrors('team_id'))->notEmpty();
            expect("we must see error message `user_id`", $memberRole->getErrors('user_id'))->notEmpty();
            expect("we must see error message `role_id`", $memberRole->getErrors('role_id'))->notEmpty();
            $memberRole->team_id = 1;
            $memberRole->user_id = 2;
            $memberRole->role_id = 1;
            expect("we can't add the role if user not in team", $memberRole->save())->false();
            expect("we must see error message `user_id`", $memberRole->getErrors('user_id'))->notEmpty();
            $memberRole->user_id = 1;
            expect("we can add the role", $memberRole->save())->true();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

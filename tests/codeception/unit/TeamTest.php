<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\Team;
use yii;
use yii\codeception\TestCase;

class TeamTest extends TestCase
{
    use Specify;

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
        ];
    }

    /**
     * General test for Product model
     */
    public function testCreate()
    {
        /** @var Team $team */
        $team = null;
        $this->specify("we want to create the team", function () use (&$team) {
            $team = Yii::createObject('inblank\team\models\Team');
            expect("we can't create team without name", $team->save())->false();
            expect("we must see error message for `name`", $team->getErrors('name'))->notEmpty();
            $team->name = "Test team";
            expect("we can create team with", $team->save())->true();
            expect("slug must be filled", $team->slug)->notEmpty();
        });
        $this->specify("we want to create the team with same name", function () use ($team) {
            /** @var Team $team1 */
            $team1 = Yii::createObject([
                'class' => 'inblank\team\models\Team',
                'name' => 'Test team',
            ]);
            expect("we can create team with same name", $team1->save())->true();
            expect("slug must be differ", $team1->slug)->notEquals($team->slug);
        });
        $this->specify("we want to create the team with same slug", function () use ($team) {
            /** @var Team $team1 */
            $team1 = Yii::createObject([
                'class' => 'inblank\team\models\Team',
                'name' => 'Test team',
                'slug' => $team->slug,
            ]);
            expect("we can't create team with same slug", $team1->save())->false();
            expect("we must see error message for `slug`", $team1->getErrors('slug'))->notEmpty();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

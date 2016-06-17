<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\Role;
use yii;
use yii\codeception\TestCase;

class RoleTest extends TestCase
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
        $this->specify("we want to create the role", function(){
            /** @var Role $role */
            $role = Yii::createObject('inblank\team\models\Role');
            expect("we cannot create role without name", $role->save())->false();
            expect("we must see error message", $role->getErrors('name'))->notEmpty();
            $role->name="Test role";
            expect("we can create role with name", $role->save())->true();
        });
        $this->specify("we want to create the role with same name", function(){
            /** @var Role $role */
            $role = Yii::createObject([
                'class'=>'inblank\team\models\Role',
                'name'=>'Test role',
            ]);
            expect("we can create role with same name", $role->save())->true();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

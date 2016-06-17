<?php

namespace tests\codeception;

use Codeception\Specify;
use inblank\team\models\Speciality;
use yii;
use yii\codeception\TestCase;

class SpecialityTest extends TestCase
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
        $this->specify("we want to create the speciality", function(){
            /** @var Speciality $speciality */
            $speciality = Yii::createObject('inblank\team\models\Speciality');
            expect("we cannot create speciality without name", $speciality->save())->false();
            expect("we must see error message", $speciality->getErrors('name'))->notEmpty();
            $speciality->name="Test speciality";
            expect("we can create speciality with name", $speciality->save())->true();
        });
        $this->specify("we want to create the speciality with same name", function(){
            /** @var Speciality $speciality */
            $speciality = Yii::createObject([
                'class'=>'inblank\team\models\Speciality',
                'name'=>'Test speciality',
            ]);
            expect("we can create speciality with same name", $speciality->save())->true();
        });
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}

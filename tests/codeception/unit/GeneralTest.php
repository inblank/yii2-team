<?php

namespace tests\codeception;

use Codeception\Specify;
use yii;
use yii\codeception\TestCase;

class GeneralTest extends TestCase
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
    public function testGeneral()
    {
    }
    
    protected function tearDown()
    {
        parent::tearDown();
    }
}

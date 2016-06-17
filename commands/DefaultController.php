<?php
/**
 * Default console controller
 *
 * @link https://github.com/inblank/yii2-team
 * @copyright Copyright (c) 2016 Pavel Aleksandrov <inblank@yandex.ru>
 * @license http://opensource.org/licenses/MIT
 */

namespace inblank\team\commands;

use inblank\team\components\ConsoleController;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\Console;

/**
 * 
 * @package inblank\team\commands
 */
class DefaultController extends ConsoleController
{

    /**
     * Default action
     */
    public function actionIndex()
    {
        $this->showUsage('', '', []);
    }

}

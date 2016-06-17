<?php

namespace inblank\team\traits;

use Yii;
use yii\base\InvalidConfigException;

trait CommonTrait
{

    static protected $_module;

    protected $userClass = 'inblank\team\models\User';

    /**
     * @return \inblank\team\Module
     * @throws InvalidConfigException
     */
    static function getModule()
    {
        if (self::$_module === null) {
            if (empty(Yii::$app->modules['team'])) {
                throw new InvalidConfigException('You must configure module as `team`');
            }
            self::$_module = Yii::$app->getModule('team');
        }
        return self::$_module;
    }

    /**
     * Get user class primary key name
     * @return string
     * @throws InvalidConfigException
     */
    protected function userClassPK()
    {
        static $pk;
        if ($pk === null) {
            $pk = implode('', Yii::createObject($this->userClass)->primaryKey());
        }
        return $pk;
    }
}

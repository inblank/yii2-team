<?php

namespace inblank\team\traits;

use Yii;
use yii\base\InvalidConfigException;

trait CommonTrait
{

    static protected $_module;

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
    protected function userPKName()
    {
        static $pk;
        if ($pk === null) {
            $class = $this->di('User');
            $pk = implode('', $class::primaryKey());
        }
        return $pk;
    }

    /**
     * Models dependency injection resolver
     * @param string $name class name for resolve
     * @return mixed
     * @throws InvalidConfigException
     */
    public function di($name)
    {
        $class = 'inblank\team\models\\' . $name;
        return empty($this->getModule()->modelMap[$name]) ? $class : $this->getModule()->modelMap[$name];
    }
}

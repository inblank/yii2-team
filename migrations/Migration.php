<?php

namespace inblank\team\migrations;

use ReflectionException;
use yii;
use yii\helpers\Console;

class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;

    /**
     * Tables prefix
     * @var string
     */
    protected $tableGroup = 'team_';

    /**
     * Class for manage user
     * @var \yii\db\ActiveRecord
     */
    protected $userObject;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        switch (Yii::$app->db->driverName) {
            case 'mysql':
            case 'pgsql':
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
        try {
            $this->userObject = Yii::$container->get('inblank\\team\\models\\User');
        } catch (ReflectionException $e) {
            $this->stderr($e->getMessage() . '. Specify the name of an existing class to manage users.' . PHP_EOL);
            exit;
        }
        if (count($this->userObject->primaryKey()) != 1) {
            throw new \RuntimeException('User table primary key must contain one field.');
        }
    }

    protected function stderr($string)
    {
        if (Console::streamSupportsAnsiColors(\STDOUT)) {
            $string = Console::ansiFormat("    Error: " . $string, [Console::FG_RED]);
        }
        return fwrite(\STDERR, $string);
    }

    /**
     * Real table name builder
     * @param string $name table name
     * @return string
     */
    protected function tn($name)
    {
        return '{{%' . $this->tableGroup . $name . '}}';
    }

    /**
     * Foreign key relation names generator
     * @param string $table1 first table in relation
     * @param string $table2 second table in relation
     * @return string
     */
    protected function fk($table1, $table2)
    {
        $table1 = Yii::$app->db->tablePrefix.$table1;
        $table2 = Yii::$app->db->tablePrefix.$table2;
        return 'fk__' . $this->tableGroup . $table1 . '__' . $table2;
    }

    /**
     * Primary key names generator
     * @param string $table table name
     * @return string
     */
    protected function pk($table)
    {
        return 'pk__' . $this->tableGroup . $table;
    }

}

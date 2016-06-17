<?php
/**
 * Team history model in the module yii2-team
 *
 * @link https://github.com/inblank/yii2-team
 * @copyright Copyright (c) 2016 Pavel Aleksandrov <inblank@yandex.ru>
 * @license http://opensource.org/licenses/MIT
 */

namespace inblank\team\models;

use inblank\team\traits\CommonTrait;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%team_history}}".
 *
 * @property integer $id history record identifier
 * @property integer $team_id team identifier
 * @property integer $user_id user identifier
 * @property integer $role_id role identifier
 * @property integer $speciality_id speciality id
 * @property integer $action history action
 * @property string $date date
 *
 * @property Role $role role
 * @property Speciality $speciality speciality
 * @property Team $team team
 * @property ActiveRecord $user user
 */
class History extends \yii\db\ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id', 'action', 'date'], 'required'],
            [['team_id', 'user_id', 'role_id', 'speciality_id', 'action'], 'integer'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team_general', 'ID'),
            'team_id' => Yii::t('team_general', 'Team'),
            'user_id' => Yii::t('team_general', 'User'),
            'role_id' => Yii::t('team_general', 'Role'),
            'speciality_id' => Yii::t('team_general', 'Speciality'),
            'action' => Yii::t('team_general', 'Action'),
            'date' => Yii::t('team_general', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne($this->di('Role'), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne($this->di('Speciality'), ['id' => 'speciality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne($this->di('Team'), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->di('User'), [$this->userPKName() => 'user_id']);
    }
}

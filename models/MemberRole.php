<?php
/**
 * Member's role in team model in the module yii2-team
 *
 * @link https://github.com/inblank/yii2-team
 * @copyright Copyright (c) 2016 Pavel Aleksandrov <inblank@yandex.ru>
 * @license http://opensource.org/licenses/MIT
 */

namespace inblank\team\models;

use inblank\team\traits\CommonTrait;
use yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%team_member_role}}".
 *
 * @property integer $team_id team identifier
 * @property integer $user_id user identifier
 * @property integer $role_id role identifier
 * @property string $date date from
 *
 * @property Role $role role
 * @property Team $team team
 * @property ActiveRecord $user user
 */
class MemberRole extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_member_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id', 'role_id'], 'required'],
            [['team_id', 'user_id', 'role_id'], 'integer'],
            [
                'team_id', 'exist',
                'targetClass' => 'inblank\team\models\Team',
                'targetAttribute' => 'id'
            ],
            [
                'user_id', 'exist',
                'targetClass' => $this->userClass,
                'targetAttribute' => $this->userClassPK()
            ],
            ['role_id', 'exist',
                'targetClass' => 'inblank\team\models\Role',
                'targetAttribute' => 'id'
            ],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'team_id' => Yii::t('team_general', 'Team'),
            'user_id' => Yii::t('team_general', 'User'),
            'role_id' => Yii::t('team_general', 'Role'),
            'date' => Yii::t('team_general', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne('inblank\team\models\Role', ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne('inblank\team\models\Team', ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->userClass, [$this->userClassPK() => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

}

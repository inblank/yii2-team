<?php
/**
 * Member model in the module yii2-team
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
 * This is the model class for table "{{%team_member}}".
 *
 * @property integer $team_id team identifier
 * @property integer $user_id user identifier
 * @property integer $speciality_id member speciality
 * @property string $joined_at team join date
 *
 * @property Speciality $speciality member speciality
 * @property Team $team team
 * @property ActiveRecord $user user
 */
class Member extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_member}}';
    }

    /**
     * Find member
     * @param Team $team team for search
     * @param ActiveRecord $user user for search
     * @return null|static
     */
    static public function findMember(Team $team, $user)
    {
        return self::findOne(['team_id' => $team->id, 'user_id' => $user->id]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id'], 'required'],
            [['team_id', 'user_id', 'speciality_id'], 'integer'],
            [
                'team_id', 'exist',
                'targetClass' => self::di('Team'),
                'targetAttribute' => 'id',
            ],
            [
                'user_id', 'exist',
                'targetClass' => self::di('User'),
                'targetAttribute' => $this->userPKName(),
            ],
            [
                'speciality_id', 'exist',
                'targetClass' => self::di('Speciality'),
                'targetAttribute' => 'id',
                'skipOnEmpty' => true,
            ],
            [['joined_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
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
            'speciality_id' => Yii::t('team_general', 'Speciality'),
            'joined_at' => Yii::t('team_general', 'Joined'),
        ];
    }

    /**
     * @return Speciality
     */
    public function getSpeciality()
    {
        return $this->hasOne(self::di('Speciality'), ['id' => 'speciality_id']);
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->hasOne(self::di('Team'), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(self::di('User'), [$this->userPKName() => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'joined_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }
}

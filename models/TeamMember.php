<?php
/**
 * Team's member model in the module yii2-team
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
 * This is the model class for table "{{%team_team_member}}".
 *
 * @property integer $team_id team identifier
 * @property integer $member_id member identifier
 * @property integer $speciality_id member speciality
 * @property string $joined_at team join date
 *
 * @property Speciality $speciality member speciality
 * @property Team $team team
 * @property ActiveRecord $user user
 */
class TeamMember extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_team_member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'member_id'], 'required'],
            [['team_id', 'member_id', 'speciality_id'], 'integer'],
            [
                'team_id', 'exist',
                'targetClass' => self::di('Team'),
                'targetAttribute' => 'id',
            ],
            [
                'member_id', 'exist',
                'targetClass' => self::di('Member'),
                'targetAttribute' => 'id',
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
            'member_id' => Yii::t('team_general', 'Member'),
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
    public function getMember()
    {
        return $this->hasOne(self::di('Member'), ['id' => 'user_id']);
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

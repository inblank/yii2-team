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

/**
 * This is the model class for table "{{%team_member}}".
 *
 * @property integer $id member identifier
 * @property integer $user_id user identifier
 * @property integer $speciality_id default member speciality
 *
 * @property Speciality $speciality member speciality
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'required'],
            [['user_id', 'speciality_id'], 'integer'],
            [
                'user_id', 'exist',
                'targetClass' => self::di('User'),
                'targetAttribute' => self::userPKName(),
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
            'id' => Yii::t('team_general', 'ID'),
            'user_id' => Yii::t('team_general', 'User'),
            'speciality_id' => Yii::t('team_general', 'Speciality'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(self::di('User'), [$this->userPKName() => 'user_id']);
    }

}

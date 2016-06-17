<?php
/**
 * Team model in the module yii2-team
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
 * This is the model class for table "{{%team_team}}".
 *
 * @property integer $id team identifier
 * @property integer $creator_id team creator identifier
 * @property integer $owner_id team owner identifier
 * @property string $slug unique slug for generate personal team URL
 * @property string $emblem team emblem
 * @property string $name team name
 * @property string $description team description
 * @property string $created_at date of team creation
 * @property string $disbanded_at date of team disband
 *
 * @property ActiveRecord $owner team owner
 * @property ActiveRecord $creator team creator
 */
class Team extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_team}}';
    }

    /**
     * Search team by slug
     * @param string $slug team's slug
     * @return null|static
     */
    public static function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }

    /**
     * @inheritdoc
     * @return TeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'except' => 'search',],
            [
                ['creator_id', 'owner_id'], 'exist',
                'targetClass' => self::di('User'),
                'targetAttribute' => $this->userPKName(),
                'skipOnEmpty' => true,
                'except' => 'search',
            ],
            [['name', 'slug', 'emblem'], 'string', 'max' => 255],
            ['slug', 'unique'],
            [['created_at', 'disbanded_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['creator_id', 'owner_id', 'disbanded_at'], 'default', 'value' => null],
            ['description', 'string'],
            ['description', 'default', 'value' => ''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team_general', 'ID'),
            'creator_id' => Yii::t('team_general', 'Creator'),
            'owner_id' => Yii::t('team_general', 'Owner'),
            'slug' => Yii::t('team_general', 'Slug'),
            'emblem' => Yii::t('team_general', 'Emblem'),
            'name' => Yii::t('team_general', 'Name'),
            'description' => Yii::t('team_general', 'Description'),
            'created_at' => Yii::t('team_general', 'Created'),
            'disbanded_at' => Yii::t('team_general', 'Disbanded'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(self::di('User'), [$this->userPKName() => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(self::di('User'), [$this->userPKName() => 'creator_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => true,
            ],
            [
                'class' => yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        // cannot delete team
        return false;
    }

    /**
     * Disband team
     */
    public function disband()
    {
        if (!$this->getIsNewRecord()) {
            $this->disbanded_at = date('Y-m-d H:i:s');
            $this->update(false, ['disbanded_at']);
        }
    }

    /**
     * Check that the team disbanded
     * @return bool
     */
    public function isDisbanded()
    {
        return $this->disbanded_at !== null;
    }
}

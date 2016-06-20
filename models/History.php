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
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%team_history}}".
 *
 * @property integer $id history record identifier
 * @property integer $team_id team identifier
 * @property integer $member_id member identifier
 * @property integer $role_id role identifier
 * @property integer $speciality_id speciality id
 * @property integer $action history action
 * @property string $date date
 *
 * @property Role $role role
 * @property Speciality $speciality speciality
 * @property Team $team team
 * @property Member $member member
 */
class History extends ActiveRecord
{
    use CommonTrait;

    /** Add action */
    const ACTION_ADD = 1;
    /** Change action */
    const ACTION_CHANGE = 2;
    /** Delete action */
    const ACTION_DELETE = 3;

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
            [['team_id', 'member_id', 'action'], 'required'],
            [['team_id', 'member_id', 'role_id', 'speciality_id', 'action'], 'integer'],
            [
                'member_id', 'exist',
                'targetClass' => self::di('TeamMember'),
                'targetAttribute' => ['team_id', 'member_id'],
            ],
            [['role_id', 'speciality_id'], 'default', 'value' => null],
            [
                'role_id', 'exist',
                'targetClass' => self::di('Role'),
                'targetAttribute' => 'id',
                'skipOnEmpty' => true,
            ],
            [
                'speciality_id', 'exist',
                'targetClass' => self::di('Speciality'),
                'targetAttribute' => 'id',
                'skipOnEmpty' => true,
            ],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['action', 'in', 'range' => [self::ACTION_ADD, self::ACTION_CHANGE, self::ACTION_DELETE]],
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
            'member_id' => Yii::t('team_general', 'Member'),
            'role_id' => Yii::t('team_general', 'Role'),
            'speciality_id' => Yii::t('team_general', 'Speciality'),
            'action' => Yii::t('team_general', 'Action'),
            'date' => Yii::t('team_general', 'Date'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(self::di('Role'), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(self::di('Speciality'), ['id' => 'speciality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
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
        return $this->hasOne(self::di('Member'), ['id' => 'member_id']);
    }

    /**
     * History action
     * @param integer $action history action id: self::ACTION_ADD, self::ACTION_CHANGE, self::ACTION_DELETE
     * @param ActiveRecord $team team model
     * @param ActiveRecord $member member model
     * @param ActiveRecord|null $subject subject model Role or Speciality.
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    protected static function _action($action, ActiveRecord $team, ActiveRecord $member, ActiveRecord $subject = null)
    {
        $class = self::di('Team');
        if (!($team instanceof $class)) {
            throw new InvalidParamException('Not Team object to History action');
        }
        $class = self::di('Member');
        if (!($member instanceof $class)) {
            throw new InvalidParamException('Not Member object to History action');
        }
        /** @var self $record */
        $record = Yii::createObject([
            'class' => self::di('History'),
            'team_id' => $team->id,
            'member_id' => $member->id,
            'action' => $action,
        ]);
        if ($subject !== null) {
            $class = self::di('Role');
            $isRole = $subject instanceof $class;
            $class = self::di('Speciality');
            $isSpeciality = $subject instanceof $class;
            if (!$isRole && !$isSpeciality) {
                throw new InvalidParamException('Not Role or Speciality object to History action');
            }
            $record->setAttribute($isRole ? 'role_id' : 'speciality_id', $subject->id);
        }
        return $record->save();
    }

    /**
     * Join team action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $user user model
     * @return bool
     */
    public static function joinTeam($team, $user)
    {
        return self::_action(self::ACTION_ADD, $team, $user);
    }

    /**
     * Leave team action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $user user model
     * @return bool
     */
    public static function leaveTeam($team, $user)
    {
        return self::_action(self::ACTION_DELETE, $team, $user);
    }

    /**
     * Add role to member action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $member member model
     * @param ActiveRecord $role role model
     * @return bool
     */
    public static function addRole($team, $member, $role)
    {
        return self::_action(self::ACTION_ADD, $team, $member, $role);
    }

    /**
     * Delete role from member action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $member member model
     * @param ActiveRecord $role role model
     * @return bool
     */
    public static function deleteRole($team, $member, $role)
    {
        return self::_action(self::ACTION_DELETE, $team, $member, $role);
    }

    /**
     * Add speciality to member action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $member member model
     * @param ActiveRecord $speciality speciality model
     * @return bool
     */
    public static function addSpeciality($team, $member, $speciality)
    {
        return self::_action(self::ACTION_ADD, $team, $member, $speciality);
    }

    /**
     * Change speciality for member action
     * @param ActiveRecord $team team model
     * @param ActiveRecord $member member model
     * @param ActiveRecord $speciality speciality model
     * @return bool
     */
    public static function changeSpeciality($team, $member, $speciality)
    {
        return self::_action(self::ACTION_CHANGE, $team, $member, $speciality);
    }

}

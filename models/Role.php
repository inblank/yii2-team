<?php
/**
 * Member's team role model in the module yii2-team
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
 * This is the model class for table "{{%team_role}}".
 *
 * @property integer $id role identifier
 * @property string $name role name
 *
 * @property History[] $histories list of histories records with this role
 */
class Role extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team_general', 'ID'),
            'name' => Yii::t('team_general', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(
            'inblank\team\models\History',
            ['role_id' => 'id']
        );
    }
}

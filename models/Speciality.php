<?php
/**
 * Member's speciality model in the module yii2-team
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
 * This is the model class for table "{{%team_speciality}}".
 *
 * @property integer $id speciality identifier
 * @property string $name speciality name
 *
 * @property History[] $histories list of histories records with this speciality
 */
class Speciality extends ActiveRecord
{
    use CommonTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_speciality}}';
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
            $this->di('History'),
            ['speciality_id' => 'id']
        );
    }
}

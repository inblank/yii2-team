<?php
/**
 * Query to team model in the module yii2-team
 *
 * @link https://github.com/inblank/yii2-team
 * @copyright Copyright (c) 2016 Pavel Aleksandrov <inblank@yandex.ru>
 * @license http://opensource.org/licenses/MIT
 */

namespace inblank\team\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Team]].
 *
 * @see Team
 */
class TeamQuery extends ActiveQuery
{
    /**
     * Active teams filter
     * @return $this
     */
    public function active()
    {
        $this->andWhere('[[disbanded_at]] is null');
        return $this;
    }

    /**
     * Disbanded teams filter
     * @return $this
     */
    public function disbanded()
    {
        $this->andWhere('[[disbanded_at]] is not null');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Team[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Team|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

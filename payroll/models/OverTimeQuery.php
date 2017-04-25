<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[OverTime]].
 *
 * @see OverTime
 */
class OverTimeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OverTime[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OverTime|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[Payrollinsentive]].
 *
 * @see Payrollinsentive
 */
class PayrollinsentiveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Payrollinsentive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Payrollinsentive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

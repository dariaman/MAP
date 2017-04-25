<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[PayrollPotongan]].
 *
 * @see PayrollPotongan
 */
class PayrollPotonganQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PayrollPotongan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PayrollPotongan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

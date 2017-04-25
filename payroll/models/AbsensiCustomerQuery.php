<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[AbsensiCustomer]].
 *
 * @see AbsensiCustomer
 */
class AbsensiCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AbsensiCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AbsensiCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

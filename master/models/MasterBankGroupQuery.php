<?php

namespace app\master\models;

/**
 * This is the ActiveQuery class for [[MasterBankGroup]].
 *
 * @see MasterBankGroup
 */
class MasterBankGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MasterBankGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MasterBankGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

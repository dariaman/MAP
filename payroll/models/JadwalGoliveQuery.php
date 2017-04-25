<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[JadwalGolive]].
 *
 * @see JadwalGolive
 */
class JadwalGoliveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return JadwalGolive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JadwalGolive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

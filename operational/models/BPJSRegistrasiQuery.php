<?php

namespace app\operational\models;

/**
 * This is the ActiveQuery class for [[BPJSRegistrasi]].
 *
 * @see BPJSRegistrasi
 */
class BPJSRegistrasiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BPJSRegistrasi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BPJSRegistrasi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

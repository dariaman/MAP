<?php

namespace app\payroll\models;

/**
 * This is the ActiveQuery class for [[PPH21Product]].
 *
 * @see PPH21Product
 */
class PPH21ProductQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return PPH21Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PPH21Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

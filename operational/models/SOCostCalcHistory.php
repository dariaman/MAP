<?php

namespace app\operational\models;

use Yii;

class SOCostCalcHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOCostCalcHistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CostcalDID', 'CostcalIDH', 'SeqIDCostcal', 'TipeBiaya', 'BiayaID', 'Amount'], 'required'],
            [['CostcalDID', 'CostcalIDH', 'TipeBiaya', 'BiayaID', 'Remark'], 'string'],
            [['SeqIDCostcal', 'IsPercentage'], 'integer'],
            [['Amount'], 'number'],
            [['DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CostcalDID' => 'Costcal Did',
            'CostcalIDH' => 'Costcal Idh',
            'SeqIDCostcal' => 'Seq Idcostcal',
            'TipeBiaya' => 'Tipe Biaya',
            'BiayaID' => 'Biaya ID',
            'Amount' => 'Amount',
            'IsPercentage' => 'Is Percentage',
            'Remark' => 'Remark',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

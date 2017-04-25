<?php

namespace app\finance\models;

use Yii;

class BillingOutstanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BillingOutstanding';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BillingNo', 'TipeBilling', 'SODID', 'SeqProduct', 'CustomerID', 'AreaID', 'Periode', 'DPP', 'MgmFee', 'PPN', 'PPH23', 'TotalInvoice'], 'required'],
            [['BillingNo', 'TipeBilling', 'SODID', 'SeqProduct', 'CustomerID', 'AreaID', 'Periode'], 'string'],
            [['DPP', 'MgmFee', 'PPN', 'PPH23', 'TotalInvoice'], 'number'],
            [['IsBilling'], 'integer'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BillingNo' => 'Billing No',
            'TipeBilling' => 'Tipe Billing',
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'CustomerID' => 'Customer ID',
            'AreaID' => 'Area ID',
            'Periode' => 'Periode',
            'DPP' => 'Dpp',
            'MgmFee' => 'Mgm Fee',
            'PPN' => 'Ppn',
            'PPH23' => 'Pph23',
            'TotalInvoice' => 'Total Invoice',
            'IsBilling' => 'Is Billing',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];

    }
}

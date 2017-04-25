<?php

namespace app\finance\models;

use Yii;

class BillingD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BillingD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BillingNo', 'InvoiceNo', 'TipeBilling', 'SODID', 'SeqProduct', 'AreaID', 'Periode', 'DPP', 'MgmFee', 'PPN', 'PPH23', 'Total', 'UserCrt', 'DateCrt'], 'required'],
            [['BillingNo', 'InvoiceNo', 'TipeBilling', 'SODID', 'AreaID', 'Periode'], 'string'],
            [['SeqProduct'], 'integer'],
            [['DPP', 'MgmFee', 'PPN', 'PPH23', 'Total'], 'number'],
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
            'InvoiceNo' => 'Invoice No',
            'TipeBilling' => 'Tipe Billing',
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'AreaID' => 'Area ID',
            'Periode' => 'Periode',
            'DPP' => 'Dpp',
            'MgmFee' => 'Mgm Fee',
            'PPN' => 'Ppn',
            'PPH23' => 'Pph23',
            'Total' => 'Total',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

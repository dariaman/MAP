<?php

namespace app\finance\models;

use Yii;

class BillingH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $CusName;
    public static function tableName()
    {
        return 'BillingH';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['BillingIDH', 'InvoiceNo'], 'required'],
            [['BillingIDH', 'InvoiceNo', 'TipeBilling', 'SODID', 'AreaID', 'Periode'], 'string'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BillingIDH' => 'Billing Idh',
            'InvoiceNo' => 'Invoice No',
            'TipeBilling' => 'Tipe Billing',
            'SODID' => 'Sodid',
            'AreaID' => 'Area ID',
            'Periode' => 'Periode',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

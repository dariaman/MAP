<?php

namespace app\finance\models;

use Yii;

class FakturPajakD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FakturPajakD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TRNo', 'NoFaktur', 'UserCrt', 'DateCrt'], 'required'],
            [['TRNo', 'IsCancel'], 'integer'],
            [['InvoiceNo', 'KodeTransFaktur', 'NoFaktur', 'BillingCancel', 'CancelReason'], 'string'],
            [['InvoiceDate', 'CancelDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TRNo' => 'Trno',
            'InvoiceNo' => 'Invoice No',
            'InvoiceDate' => 'Invoice Date',
            'KodeTransFaktur' => 'Kode Trans Faktur',
            'NoFaktur' => 'No Faktur',
            'IsCancel' => 'Is Cancel',
            'BillingCancel' => 'Billing Cancel',
            'CancelDate' => 'Cancel Date',
            'CancelReason' => 'Cancel Reason',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

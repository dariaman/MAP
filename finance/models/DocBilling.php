<?php

namespace app\finance\models;

use Yii;

/**
 * This is the model class for table "DocBilling".
 *
 * @property string $InvoiceNo
 * @property string $SendDate
 * @property string $SendBy
 * @property string $ReceivedDate
 * @property string $ReceivedBy
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 *
 * @property BillingH $invoiceNo
 */
class DocBilling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DocBilling';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['InvoiceNo', 'SendDate', 'SendBy', 'UserCrt', 'DateCrt'], 'required'],
            [['InvoiceNo', 'SendBy', 'ReceivedBy'], 'string'],
            [['SendDate', 'ReceivedDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'InvoiceNo' => 'Invoice No',
            'SendDate' => 'Send Date',
            'SendBy' => 'Send By',
            'ReceivedDate' => 'Received Date',
            'ReceivedBy' => 'Received By',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceNo()
    {
        return $this->hasOne(BillingH::className(), ['InvoiceNo' => 'InvoiceNo']);
    }
}

<?php

namespace app\finance\models;

use Yii;

/**
 * This is the model class for table "Invoice".
 *
 * @property string $InvoiceNo
 * @property string $InvoiceDate
 * @property string $CustomerID
 * @property string $TotalDPP
 * @property string $TotalMFee
 * @property string $TotalPPN
 * @property string $TotalPPH23
 * @property string $TotalInvoice
 * @property string $KodeFaktur
 * @property string $NoFakturPajak
 * @property string $Status
 * @property string $CancelDate
 * @property string $CancelReason
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['InvoiceNo'], 'required'],
            [['InvoiceNo', 'CustomerID', 'KodeFaktur', 'NoFakturPajak', 'Status', 'CancelReason'], 'string'],
            [['InvoiceDate', 'CancelDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['TotalDPP', 'TotalMFee', 'TotalPPN', 'TotalPPH23', 'TotalInvoice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'InvoiceNo' => 'Invoice No',
            'InvoiceDate' => 'Invoice Date',
            'CustomerID' => 'Customer ID',
            'TotalDPP' => 'Total Dpp',
            'TotalMFee' => 'Total Mfee',
            'TotalPPN' => 'Total Ppn',
            'TotalPPH23' => 'Total Pph23',
            'TotalInvoice' => 'Total Invoice',
            'KodeFaktur' => 'Kode Faktur',
            'NoFakturPajak' => 'No Faktur Pajak',
            'Status' => 'Status',
            'CancelDate' => 'Cancel Date',
            'CancelReason' => 'Cancel Reason',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

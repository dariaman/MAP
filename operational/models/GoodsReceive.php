<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "GoodsReceive".
 *
 * @property string $GRID
 * @property string $ItemID
 * @property integer $Qty
 * @property string $HargaSatuan
 * @property string $NoPV
 * @property string $ReferenceNo
 * @property string $SupplierName
 * @property string $NoFakturPajak
 * @property string $ReceiveDate
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class GoodsReceive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GoodsReceive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'ItemID', 'Qty', 'HargaSatuan', 'NoPV', 'ReferenceNo', 'SupplierName', 'ReceiveDate'], 'required'],
            [['GRID', 'ItemID', 'NoPV', 'ReferenceNo', 'SupplierName', 'NoFakturPajak'], 'string'],
            [['Qty'], 'integer'],
            [['HargaSatuan'], 'number'],
            [['ReceiveDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => 'Grid',
            'ItemID' => 'Item ID',
            'Qty' => 'Qty',
            'HargaSatuan' => 'Harga Satuan',
            'NoPV' => 'No Pv',
            'ReferenceNo' => 'Reference No',
            'SupplierName' => 'Supplier Name',
            'NoFakturPajak' => 'No Faktur Pajak',
            'ReceiveDate' => 'Receive Date',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

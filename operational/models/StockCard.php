<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "StockCard".
 *
 * @property string $StockID
 * @property string $ItemID
 * @property integer $Qty
 * @property string $TanggalTransaksi
 * @property string $UserCrt
 * @property string $DateCrt
 */
class StockCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StockCard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StockID', 'ItemID', 'Qty', 'TanggalTransaksi'], 'required'],
            [['StockID', 'ItemID'], 'string'],
            [['Qty'], 'integer'],
            [['TanggalTransaksi', 'DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StockID' => 'Stock ID',
            'ItemID' => 'Item ID',
            'Qty' => 'Qty',
            'TanggalTransaksi' => 'Tanggal Transaksi',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

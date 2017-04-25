<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "CosCalc".
 *
 * @property string $OfferingDID
 * @property string $BiayaID
 * @property string $Amount
 * @property string $Remark
 * @property string $Time
 * @property integer $IsManagementFee
 * @property string $TipeTagihan
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class CosCalc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CosCalc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OfferingDID', 'BiayaID', 'Amount'], 'required'],
            [['OfferingDID', 'BiayaID'], 'string'],
            [['Amount'], 'number'],
            [['Time', 'DateCrt', 'DateUpdate', 'Remark', 'TipeTagihan', 'UserCrt', 'UserUpdate','Percentage'], 'safe'],
            [['IsManagementFee'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OfferingDID' => 'Offering Did',
            'BiayaID' => 'Biaya ID',
            'Amount' => 'Amount',
            'Remark' => 'Remark',
            'Time' => 'Time',
            'Percentage' => 'Percentage',
            'IsManagementFee' => 'Is Management Fee',
            'TipeTagihan' => 'Tipe Tagihan',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

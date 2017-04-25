<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "CostCalcOutstanding".
 *
 * @property string $OfferingDID
 * @property string $BiayaID
 * @property string $Amount
 * @property string $Percentage
 * @property string $Remark
 * @property string $Time
 * @property integer $IsManagementFee
 * @property string $TipeTagihan
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class CostCalcOutstanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CostCalcOutstanding';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OfferingDID', 'BiayaID', 'Amount'], 'required'],
            [['OfferingDID', 'BiayaID', 'Remark', 'TipeTagihan', 'UserCrt', 'UserUpdate'], 'string'],
            [['Amount', 'Percentage'], 'number'],
            [['Time', 'DateCrt', 'DateUpdate','UserCrt', 'DateCrt'], 'safe'],
            [['IsManagementFee'], 'integer'],
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
            'Percentage' => 'Percentage',
            'Remark' => 'Remark',
            'Time' => 'Time',
            'IsManagementFee' => 'Is Management Fee',
            'TipeTagihan' => 'Tipe Tagihan',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

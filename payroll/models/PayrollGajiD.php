<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "PayrollGajiD".
 *
 * @property string $PayrollGajiIDH
 * @property string $ItemID
 * @property string $Amount
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class PayrollGajiD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $BiayaName;
    public $Type;
    public $SumName;
    public static function tableName()
    {
        return 'PayrollGajiD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PayrollGajiIDH', 'ItemID', 'Amount'], 'required'],
            [['PayrollGajiIDH', 'ItemID'], 'string'],
            [['Amount'], 'number'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PayrollGajiIDH' => 'Payroll Gaji Idh',
            'ItemID' => 'Item ID',
            'Amount' => 'Amount',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

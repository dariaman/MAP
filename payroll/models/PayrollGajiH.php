<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "PayrollGajiH".
 *
 * @property string $PayrollGajiIDH
 * @property string $ProductID
 * @property string $bln
 * @property string $thn
 * @property string $CustomerID
 * @property string $AreaID
 * @property string $FixAmount
 * @property string $TunjanganAmount
 * @property string $PotonganAmount
 * @property string $PPH21
 * @property string $Total
 * @property string $Status
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class PayrollGajiH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $Name;
    public $CusName;
    public $AreaDesc;
    public $Stat;
    public $NIK;
    public $Position;
    public $Nama;
    public $NamaJob;
    public static function tableName()
    {
        return 'PayrollGajiH';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PayrollGajiIDH', 'ProductID', 'bln', 'thn', 'CustomerID', 'AreaID', 'FixAmount', 'TunjanganAmount', 'PotonganAmount', 'PPH21', 'Total', 'Status'], 'required'],
            [['PayrollGajiIDH', 'ProductID', 'bln', 'thn', 'CustomerID', 'AreaID', 'Status'], 'string'],
            [['FixAmount', 'TunjanganAmount', 'PotonganAmount', 'PPH21', 'Total'], 'number'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['bln', 'ProductID', 'thn'], 'unique', 'targetAttribute' => ['bln', 'ProductID', 'thn'], 'message' => 'The combination of Product ID, Bln and Thn has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PayrollGajiIDH' => 'Payroll Gaji Idh',
            'ProductID' => 'Product ID',
            'bln' => 'Bln',
            'thn' => 'Thn',
            'CustomerID' => 'Customer ID',
            'AreaID' => 'Area ID',
            'FixAmount' => 'Fix Amount',
            'TunjanganAmount' => 'Tunjangan Amount',
            'PotonganAmount' => 'Potongan Amount',
            'PPH21' => 'Pph21',
            'Total' => 'Total',
            'Status' => 'Status',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

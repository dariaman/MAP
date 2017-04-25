<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "Payrollinsentive".
 *
 * @property string $IDKey
 * @property string $ProductID
 * @property string $ItemID
 * @property string $Amount
 * @property integer $IsOT
 * @property integer $IsReguler
 * @property integer $IsPayroll
 * @property string $tgl
 * @property string $PeriodeDueDate
 * @property string $PeriodeBayar
 * @property string $Remark
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 */
class Payrollinsentive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Payrollinsentive';
    }
    public $prodi;
    public $namaprod;
    public $jobdesk;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDKey', 'ProductID', 'ItemID', 'Amount', 'PeriodeBayar'], 'required'],
            [['IDKey', 'ProductID', 'ItemID', 'PeriodeDueDate', 'PeriodeBayar', 'Remark'], 'string'],
            [['Amount'], 'number'],
            [['IsOT', 'IsPayroll', 'IsActive'], 'integer'],
            [['tgl', 'DateCrt','DateUpdate', 'UserCrt','UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDKey' => 'Idkey',
            'ProductID' => 'Product ID',
            'ItemID' => 'Item ID',
            'Amount' => 'Amount',
            'IsOT' => 'Is Ot',
            'IsPayroll' => 'Is Payroll',
            'tgl' => 'Tgl',
            'PeriodeDueDate' => 'Periode Due Date',
            'PeriodeBayar' => 'Periode Bayar',
            'Remark' => 'Remark',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

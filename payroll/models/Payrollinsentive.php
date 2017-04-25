<?php

namespace app\payroll\models;

use Yii;
use app\master\models\Masterproduct;
use app\master\models\MasterTunjangan;

class Payrollinsentive extends \yii\db\ActiveRecord
{
    public $Nama;
    public $jobdesk;

    public static function tableName()
    {
        return 'Payrollinsentive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'ItemID', 'Amount', 'PeriodePayroll'], 'required'],
            [['ProductID', 'ItemID', 'PeriodePayroll', 'Remark', 'UserCrt', 'UserUpdate'], 'string'],
            [['Amount'], 'number'],
            [['IsOT', 'IsActive', 'IsSystem'], 'integer'],
            [['tgl', 'DateCrt', 'DateUpdate'], 'safe'],
            [['ProductID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterProduct::className(), 'targetAttribute' => ['ProductID' => 'ProductID']],
            [['ItemID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterTunjangan::className(), 'targetAttribute' => ['ItemID' => 'IDTunjangan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ProductID' => 'Product ID',
            'ItemID' => 'Item ID',
            'Amount' => 'Amount',
            'IsOT' => 'Is Ot',
            'tgl' => 'Tgl',
            'PeriodePayroll' => 'Periode Payroll',
            'Remark' => 'Remark',
            'IsActive' => 'Is Active',
            'IsSystem' => 'Is System',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @inheritdoc
     * @return PayrollinsentiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayrollinsentiveQuery(get_called_class());
    }
}

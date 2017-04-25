<?php

namespace app\payroll\models;

use Yii;
use app\master\models\Masterproduct;
use app\master\models\MasterPotongan;

class PayrollPotongan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PayrollPotongan';
    }
    
    public $Nama;
    public $jobdesk;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'ItemID', 'Amount', 'tgl'], 'required'],
            [['ProductID', 'ItemID', 'PeriodePayroll', 'Remark', 'UserCrt', 'UserUpdate'], 'string'],
            [['Amount'], 'number'],
            [['IsOT', 'IsReguler', 'IsActive', 'IsSystem'], 'integer'],
            [['tgl', 'DateCrt', 'DateUpdate'], 'safe'],
            [['ProductID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterProduct::className(), 'targetAttribute' => ['ProductID' => 'ProductID']],
            [['ItemID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterPotongan::className(), 'targetAttribute' => ['ItemID' => 'IDPotongan']],
        ]; 
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'ProductID' => 'Product ID',
            'ItemID' => 'Item ID',
            'Amount' => 'Amount',
            'IsOT' => 'Is Ot',
            'IsReguler' => 'Is Reguler',
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

    public static function find(){
        return new PayrollPotonganQuery(get_called_class());
    }
}

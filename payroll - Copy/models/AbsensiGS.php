<?php

namespace app\payroll\models;

use Yii;

class AbsensiGS extends \yii\db\ActiveRecord
{
    
    public static function tableName(){
        return 'AbsensiGS';
    }
    
    public $StatusAbsenGS;
    public $StatusProductFix;
    public $StatusBackupProduct;
    public function rules(){
        return [
            [['ProductID', 'tgl'], 'required'],
            [['ProductID'], 'string'],
            [['tgl', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'ProductID' => 'Product ID',
            'tgl' => 'Tgl',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

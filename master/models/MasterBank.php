<?php

namespace app\master\models;

use Yii;

class MasterBank extends \yii\db\ActiveRecord
{
    
    public static function tableName()    {        
        return 'MasterBank';
    }
    
    public $BankGroupName;
    public function rules()    {
        return [
            [['BankID', 'BankName','BankGroupID',], 'required'],
            [['BankID', 'BankName', 'BankGroupID' ], 'string'],
            [['BankName'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            [['IsActive'], 'integer'],
            [['UserCrt','DateCrt'], 'safe']
        ];
    }
    
    public function attributeLabels()    {
        return [
            'BankID' => 'Bank ID',
            'BankName' => 'Bank Name',
            'BankGroupID' => 'Bank Group ID',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
     
}

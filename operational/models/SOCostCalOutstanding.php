<?php

namespace app\operational\models;

use Yii;


class SOCostCalOutstanding extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'SOCostCalOutstanding';
    }
    
    public function rules()
    {
        return [
            [['SODID', 'BiayaID', 'Amount'], 'required'],
            [['SODID', 'BiayaID', 'Remark', 'TipeTagihan'], 'string'],
            [['Amount'], 'number'],
            [['Time', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IsManagementFee'], 'integer']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'SODID' => 'Sodid',
            'BiayaID' => 'Biaya ID',
            'Amount' => 'Amount',
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

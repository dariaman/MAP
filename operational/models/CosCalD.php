<?php

namespace app\operational\models;

use Yii;

class CosCalD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $IsImplement;
    public $Description;
    public $Type;
    public static function tableName()
    {
        return 'CosCalD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CostcalDID', 'CostcalIDH', 'BiayaID', 'Amount'], 'required'],
            [['CostcalDID', 'CostcalIDH', 'BiayaID', 'Remark', 'Tipe'], 'string'],
            [['Amount'], 'number'],
            [['DateCrt', 'DateUpdate', 'Time', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IsManagementFee'], 'integer'],
            [['BiayaID', 'CostcalIDH'], 'unique', 'targetAttribute' => ['BiayaID', 'CostcalIDH'], 'message' => 'The combination of Costcal Idh and Biaya ID has already been taken.']
        ];
    }

    public function attributeLabels()
    {
        return [
            'CostcalDID' => 'Costcal Did',
            'CostcalIDH' => 'Costcal Idh',
            'BiayaID' => 'Biaya ID',
            'Amount' => 'Amount',
            'Remark' => 'Remark',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
            'Time' => 'Time',
            'IsManagementFee' => 'Is Management Fee',
            'Tipe' => 'Tipe',
        ];
    }
}

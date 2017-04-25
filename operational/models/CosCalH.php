<?php

namespace app\operational\models;

use Yii;

class CosCalH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CosCalH';
    }

    public $JobDescription;
    public $statusOffering;
    public $statusSO;
    
    public function rules()
    {
        return [
            [['CostcalIDH', 'CostcalDate', 'JobDescID'], 'required'],
            [['CostcalIDH', 'JobDescID'], 'string'],
            [['CostcalDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IsActive', 'IsImplement'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CostcalIDH' => 'Costcal Idh',
            'CostcalDate' => 'Costcal Date',
            'JobDescID' => 'Job Desc ID',
            'IsActive' => 'Is Active',
            'IsImplement' => 'Is Implement',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

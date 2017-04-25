<?php

namespace app\operational\models;

use Yii;


class OfferingH extends \yii\db\ActiveRecord
{
    
    public $JobDesc;
    public $AreaID;
    public $Class;
    public $StatusSO;
    public $CustomerName;
    public static function tableName()
    {
        return 'OfferingH';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OfferingIDH', 'OfferingDate', 'IDJobDesc', 'CustomerID', 'NoSurat'], 'required'],
            [['OfferingIDH', 'SOIDH', 'IDJobDesc', 'CustomerID', 'NoSurat', 'ApproveBy', 'Status'], 'string'],
            [['OfferingDate', 'ApproveDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IsActive', 'IsPrint', 'IsApprove'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OfferingIDH' => 'Offering Idh',
            'OfferingDate' => 'Offering Date',
            'SOIDH' => 'Soidh',
            'IDJobDesc' => 'Idjob Desc',
            'CustomerID' => 'Customer ID',
            'NoSurat' => 'No Surat',
            'IsActive' => 'Is Active',
            'IsPrint' => 'Is Print',
            'IsApprove' => 'Is Approve',
            'ApproveBy' => 'Approve By',
            'ApproveDate' => 'Approve Date',
            'Status' => 'Status',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

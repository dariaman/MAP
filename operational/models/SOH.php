<?php

namespace app\operational\models;

use Yii;

class SOH extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'SOH';
    }

    public $Transtype = 'SO000001';
    public $CustomerID;
    public $IDJobDesc;
    public $jobdesc;
    public $ofdate;
    public $null;

    public function rules() {
        return [
            [['SOIDH', 'SODate', 'OfferingIDH', 'IsDirect', 'TipeKontrak', 'TipeBayar', 'PONo', 'POdate'], 'required'],
            [['SOIDH', 'OfferingIDH', 'TipeKontrak', 'TipeBayar', 'PONo', 'Status','SubCustomerID'], 'string'],
            [['SODate', 'POdate', 'datecrt', 'usercrt'], 'safe'],
            [['IsDirect'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'SOIDH' => 'Soidh',
            'SODate' => 'Sodate',
            'IsDirect' => 'Is Direct',
            'OfferingIDH' => 'Offering Idh',
            'TipeKontrak' => 'Tipe Kontrak',
            'SubCustomerID' => 'Sub Customer ID',
            'TipeBayar' => 'Tipe Bayar',
            'PONo' => 'Pono',
            'POdate' => 'Podate',
            'Status' => 'Status',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
        ];
    }

}

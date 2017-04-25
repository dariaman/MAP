<?php

namespace app\operational\models;

use Yii;

class SOD extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'SOD';
    }

    public $areaname;
    public $class;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SODID', 'SOIDH', 'OfferingDID', 'Qty', 'PeriodFrom', 'PeriodTo', 'FixAmount', 'InstalmentDPP', 'MFee', 'MFeeOT'], 'required'],
            [['SODID', 'SOIDH', 'OfferingDID', 'PeriodUpdateCoscal', 'StatusGoLive', 'Status', 'StatusCoscal'], 'string'],
            [['Qty', 'IsRapelBill'], 'integer'],
            [['PeriodFrom', 'PeriodTo', 'StatusCoscalDate', 'DateCrt', 'UserCrt'], 'safe'],
            [['FixAmount', 'InstalmentDPP', 'MFee', 'MFeeOT'], 'number'],
            [['OfferingDID', 'SOIDH'], 'unique', 'targetAttribute' => ['OfferingDID', 'SOIDH'], 'message' => 'The combination of Soidh and Offering Did has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'SODID' => 'Sodid',
            'SOIDH' => 'Soidh',
            'OfferingDID' => 'Offering Did',
            'Qty' => 'Qty',
            'PeriodFrom' => 'Period From',
            'PeriodTo' => 'Period To',
            'PeriodUpdateCoscal' => 'Period Update Coscal',
            'IsRapelBill' => 'Is Rapel Bill',
            'StatusGoLive' => 'Status Go Live',
            'FixAmount' => 'Fix Amount',
            'InstalmentDPP' => 'Instalment Dpp',
            'MFee' => 'Mfee',
            'MFeeOT' => 'Mfee Ot',
            'Status' => 'Status',
            'StatusCoscal' => 'Status Coscal',
            'StatusCoscalDate' => 'Status Coscal Date',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }

}

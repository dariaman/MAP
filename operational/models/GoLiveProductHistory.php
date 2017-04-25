<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "GoLiveProductHistory".
 *
 * @property string $GoLiveID
 * @property string $SODID
 * @property string $SOIDH
 * @property integer $SeqProduct
 * @property string $ProductID
 * @property string $PeriodFrom
 * @property string $PeriodTo
 * @property string $AreaDetailDesc
 * @property string $Status
 * @property string $LicensePlate
 * @property integer $IsActive
 * @property integer $IsShift
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class GoLiveProductHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GoLiveProductHistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GoLiveID', 'SODID', 'SOIDH', 'SeqProduct', 'ProductID', 'PeriodFrom', 'PeriodTo'], 'required'],
            [['GoLiveID', 'SODID', 'SOIDH', 'ProductID', 'AreaDetailDesc', 'Status', 'LicensePlate'], 'string'],
            [['SeqProduct', 'IsActive', 'IsShift'], 'integer'],
            [['PeriodFrom', 'PeriodTo', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GoLiveID' => 'Go Live ID',
            'SODID' => 'Sodid',
            'SOIDH' => 'Soidh',
            'SeqProduct' => 'Seq Product',
            'ProductID' => 'Product ID',
            'PeriodFrom' => 'Period From',
            'PeriodTo' => 'Period To',
            'AreaDetailDesc' => 'Area Detail Desc',
            'Status' => 'Status',
            'LicensePlate' => 'License Plate',
            'IsActive' => 'Is Active',
            'IsShift' => 'Is Shift',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

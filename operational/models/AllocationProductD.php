<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "AllocationProductD".
 *
 * @property string $AllocationProductDID
 * @property string $AllocationProductIDH
 * @property string $SODID
 * @property string $ProductID
 * @property string $AreaDetailDesc
 * @property string $LicensePlate
 * @property string $TglTugas
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $NoPKWT
 * @property string $HariKerja
 * @property integer $IsShift
 */
class AllocationProductD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $cnt;
    public $OfferingDID;
     public $Nama;
    public static function tableName()
    {
        return 'AllocationProductD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AllocationProductDID', 'AllocationProductIDH', 'SODID', 'ProductID', 'TglTugas'], 'required'],
            [['AllocationProductDID', 'AllocationProductIDH', 'SODID', 'ProductID', 'AreaDetailDesc', 'PendingProduct', 'Status', 'LicensePlate', 'HariKerja', 'NoPKWT', 'UserCrt'], 'string'],
            [['TglTugas', 'PeriodTo', 'DateCrt'], 'safe'],
            [['IsActive', 'IsShift'], 'integer'],
            [['AllocationProductIDH', 'ProductID'], 'unique', 'targetAttribute' => ['AllocationProductIDH', 'ProductID'], 'message' => 'The combination of Allocation Product Idh and Product ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AllocationProductDID' => 'Allocation Product Did',
            'AllocationProductIDH' => 'Allocation Product Idh',
            'SODID' => 'Sodid',
            'ProductID' => 'Product ID',
            'AreaDetailDesc' => 'Area Detail Desc',
            'PendingProduct' => 'Pending Product',
            'Status' => 'Status',
            'LicensePlate' => 'License Plate',
            'TglTugas' => 'Tgl Tugas',
            'PeriodTo' => 'Period To',
            'IsActive' => 'Is Active',
            'IsShift' => 'Is Shift',
            'HariKerja' => 'Hari Kerja',
            'NoPKWT' => 'No Pkwt',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "AllocationProductDOutstanding".
 *
 * @property string $AllocationProductIDH
 * @property string $SODID
 * @property string $ProductID
 * @property string $ProductIDOld
 * @property string $AreaDetailDesc
 * @property string $LicensePlate
 * @property string $TglTugas
 * @property string $PeriodTo
 * @property integer $IsActive
 * @property integer $IsShift
 * @property string $HariKerja
 * @property string $NoPKWT
 * @property string $UserCrt
 * @property string $DateCrt
 */
class AllocationProductDOutstanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $cnt;
    public static function tableName()
    {
        return 'AllocationProductDOutstanding';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AllocationProductIDH', 'SODID', 'ProductID', 'ProductIDOld', 'TglTugas', 'IsActive'], 'required'],
            [['AllocationProductIDH', 'SODID', 'ProductID', 'ProductIDOld', 'AreaDetailDesc', 'LicensePlate', 'HariKerja', 'NoPKWT', 'UserCrt'], 'string'],
            [['TglTugas', 'PeriodTo', 'DateCrt'], 'safe'],
            [['IsActive', 'IsShift'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AllocationProductIDH' => 'Allocation Product Idh',
            'SODID' => 'Sodid',
            'ProductID' => 'Product ID',
            'ProductIDOld' => 'Product Idold',
            'AreaDetailDesc' => 'Area Detail Desc',
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

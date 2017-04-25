<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "ChangeAllocationProduct".
 *
 * @property string $ChangeAllocationProductID
 * @property string $AllocationProductID
 * @property string $SOID
 * @property string $RefID
 * @property string $JobDescID
 * @property string $AreaID
 * @property string $ProductID
 * @property string $ToProductID
 * @property string $ProductFreelance
 * @property string $Tipe
 * @property string $Remark
 * @property string $FromDate
 * @property string $ToDate
 * @property string $UserCrt
 * @property string $DateCrt
 */
class ChangeAllocationProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ChangeAllocationProduct';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ChangeAllocationProductID', 'AllocationProductID', 'SOID', 'RefID', 'JobDescID', 'AreaID', 'ProductID'], 'required'],
            [['ChangeAllocationProductID', 'AllocationProductID', 'SOID', 'RefID', 'JobDescID', 'AreaID', 'ProductID', 'ToProductID', 'ProductFreelance', 'Tipe', 'Remark', 'UserCrt'], 'string'],
            [['FromDate', 'ToDate', 'DateCrt'], 'safe'],
            [['Remark','ProductFreelance'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ChangeAllocationProductID' => 'Change Allocation Product ID',
            'AllocationProductID' => 'Allocation Product ID',
            'SOID' => 'Soid',
            'RefID' => 'Ref ID',
            'JobDescID' => 'Job Desc ID',
            'AreaID' => 'Area ID',
            'ProductID' => 'Product ID',
            'ToProductID' => 'To Product ID',
            'ProductFreelance' => 'Product Freelance',
            'Tipe' => 'Tipe',
            'Remark' => 'Remark',
            'FromDate' => 'From Date',
            'ToDate' => 'To Date',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

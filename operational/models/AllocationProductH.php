<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "AllocationProductH".
 *
 * @property string $AllocationProductIDH
 * @property string $SOIDH
 * @property string $Description
 * @property string $PicCustomer
 * @property string $UserCrt
 * @property string $DateCrt
 *
 * @property AllocationProductD[] $allocationProductDs
 * @property SOH $sOIDH
 */
class AllocationProductH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $Qty;
    public $SODID;
    public $CustomerName;
    public $JobName;
    public $IDJobDesc;
    public $StatusAPH;
    public static function tableName()
    {
        return 'AllocationProductH';
    }

    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            [['AllocationProductIDH', 'SOIDH','TanggalSurat','PicCustomer','Description'], 'required'],
            [['AllocationProductIDH', 'SOIDH', 'Description', 'PicCustomer', 'UserCrt'], 'string'],
            [['Description','PicCustomer'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            [['DateCrt','TanggalSurat'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AllocationProductIDH' => 'Allocation Product Idh',
            'SOIDH' => 'SO ID',
            'Description' => 'Deskripsi',
            'PicCustomer' => 'PIC Customer',
            'TanggalSurat' =>'Tanggal Surat',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationProductDs()
    {
        return $this->hasMany(AllocationProductD::className(), ['AllocationProductIDH' => 'AllocationProductIDH']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOIDH()
    {
        return $this->hasOne(SOH::className(), ['SOIDH' => 'SOIDH']);
    }
}

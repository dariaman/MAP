<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "calon_product".
 *
 * @property string $calonproductID
 * @property string $Nama
 * @property string $IDJobDesc
 * @property string $gender
 * @property string $KTP
 * @property string $KTPExpireddate
 * @property string $sim
 * @property string $simexpiredate
 * @property string $IDstatusnikah
 * @property string $address
 * @property string $refferensidesc
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property string $mobile1
 * @property string $mobile2
 * @property string $BankID
 * @property string $BankAccNumber
 * @property string $NPWP
 * @property integer $IsActive
 * @property string $status
 * @property string $usercrt
 * @property string $datecrt
 * @property string $userupdate
 * @property string $dateupdate
 */
class CalonProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calon_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calonproductID'], 'required'],
            [['calonproductID', 'Nama', 'IDJobDesc', 'gender', 'KTP', 'KTPExpireddate', 'sim', 'simexpiredate', 'IDstatusnikah', 'address', 'refferensidesc', 'city', 'zip', 'phone', 'mobile1', 'mobile2', 'BankID', 'BankAccNumber', 'NPWP', 'status'], 'string'],
            [['IsActive'], 'integer'],
            [['datecrt', 'dateupdate', 'usercrt', 'userupdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calonproductID' => 'Calonproduct ID',
            'Nama' => 'Nama',
            'IDJobDesc' => 'Idjob Desc',
            'gender' => 'Gender',
            'KTP' => 'Ktp',
            'KTPExpireddate' => 'Ktpexpireddate',
            'sim' => 'Sim',
            'simexpiredate' => 'Simexpiredate',
            'IDstatusnikah' => 'Idstatusnikah',
            'address' => 'Address',
            'refferensidesc' => 'Refferensidesc',
            'city' => 'City',
            'zip' => 'Zip',
            'phone' => 'Phone',
            'mobile1' => 'Mobile1',
            'mobile2' => 'Mobile2',
            'BankID' => 'Bank ID',
            'BankAccNumber' => 'Bank Acc Number',
            'NPWP' => 'Npwp',
            'IsActive' => 'Is Active',
            'status' => 'Status',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
            'userupdate' => 'Userupdate',
            'dateupdate' => 'Dateupdate',
        ];
    }
}

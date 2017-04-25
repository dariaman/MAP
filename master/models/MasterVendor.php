<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterVendor".
 *
 * @property string $VendorID
 * @property string $VendorName
 * @property string $Address
 * @property string $City
 * @property string $Zip
 * @property string $Phone
 * @property string $Fax
 * @property string $ContactName
 * @property string $ContactPhone
 * @property string $ContactEmail
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class MasterVendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterVendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID', 'ContactName', 'ContactPhone', 'ContactEmail','City', 'Zip', 'Address', 'VendorName','Phone','Fax'], 'required'],
            [['VendorID', 'VendorName', 'Address', 'Fax','City', 'Zip', 'ContactName', 'ContactPhone', 'ContactEmail'], 'string'],
            [['IsActive'], 'integer'],
            [['VendorName','Address','City','Zip','ContactName', 'ContactPhone',],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            ['ContactEmail', 'email'],
            [['Phone'], 'number'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'VendorID' => 'Vendor ID',
            'VendorName' => 'Vendor Name',
            'Address' => 'Address',
            'City' => 'City',
            'Zip' => 'Zip',
            'Phone' => 'Phone',
            'Fax' => 'Fax',
            'ContactName' => 'Contact Name',
            'ContactPhone' => 'Contact Phone',
            'ContactEmail' => 'Contact Email',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

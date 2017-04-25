<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterCalonProduct".
 *
 * @property string $CalonProductID
 * @property string $Nama
 * @property string $IDJobDesc
 * @property string $Gender
 * @property string $KTP
 * @property string $KTPExpireddate
 * @property string $SIM
 * @property string $SIMExpireDate
 * @property string $IDstatusnikah
 * @property string $Address
 * @property string $RefferensiDesc
 * @property string $City
 * @property string $Zip
 * @property string $Phone
 * @property string $Mobile1
 * @property string $Mobile2
 * @property string $BankID
 * @property string $BankAccNumber
 * @property string $NPWP
 * @property integer $IsActive
 * @property string $Status
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 *
 * @property MasterBank $bank
 * @property NilaiTes $nilaiTes
 */
class MasterCalonProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterCalonProduct';
    }

    /**
     * @inheritdoc
     */
    public $mjes;
    public $mdes;
    public $BankName;
    public function rules()
    {
        return [
            [['CalonProductID', 'Nama', 'IDJobDesc', 'Gender', 'KTP','IDstatusnikah','NoKK'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['CalonProductID', 'Nama', 'IDJobDesc', 'AreaID', 'Gender','KTPExpireddate', 'IDstatusnikah', 'Address', 'RefferensiDesc', 'City',  'BankID', 'Status','NoKK'], 'string'],
            [['KTPExpireddate', 'SIMExpireDate', 'DateCrt', 'DateUpdate','UserCrt', 'UserUpdate'], 'safe'],
            [['IsActive'], 'integer'],
            [['IDstatusnikah'], 'exist', 'skipOnError' => true, 'targetClass' => MasterStatusPernikahan::className(), 'targetAttribute' => ['IDstatusnikah' => 'IDStatusPernikahan']],
            [['IDstatusnikah'], 'exist', 'skipOnError' => true, 'targetClass' => MasterStatusPernikahan::className(), 'targetAttribute' => ['IDstatusnikah' => 'IDStatusPernikahan']],
            [['KTP', 'SIM','Zip', 'Phone', 'Mobile1', 'Mobile2','BankAccNumber', 'NPWP'], 'integer','message' => '{attribute} hanya boleh angka.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CalonProductID' => 'Calon Product ID',
            'Nama' => 'Nama Calon Product',
            'IDJobDesc' => 'Idjob Desc',
            'AreaID' => 'Area ID',
            'Gender' => 'Gender',
            'NoKK' => 'Nomor KK',
            'KTP' => 'Ktp',
            'KTPExpireddate' => 'Ktpexpireddate',
            'SIM' => 'Sim',
            'SIMExpireDate' => 'Simexpire Date',
            'IDstatusnikah' => 'Idstatusnikah',
            'Address' => 'Address',
            'RefferensiDesc' => 'Refferensi Desc',
            'City' => 'City',
            'Zip' => 'Zip',
            'Phone' => 'Phone',
            'Mobile1' => 'Mobile1',
            'Mobile2' => 'Mobile2',
            'BankID' => 'Bank ID',
            'BankAccNumber' => 'Bank Acc Number',
            'NPWP' => 'Npwp',
            'IsActive' => 'Is Active',
            'Status' => 'Status',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

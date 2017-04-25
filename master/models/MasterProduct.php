<?php

namespace app\master\models;

use Yii;
use app\master\models\MasterStatuspernikahan;

/**
 * This is the model class for table "MasterProduct".
 *
 * @property string $ProductID
 * @property string $NIK
 * @property string $Nama
 * @property string $IDJobDesc
 * @property string $Gender
 * @property string $KTP
 * @property string $KTPExpiredDate
 * @property string $SIM
 * @property string $SIMExpiredDate
 * @property string $IDStatusNikah
 * @property string $Address
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
 * @property string $ClassID
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 *
 * @property MasterBank $bank
 * @property MasterClass $class
 * @property MasterJobDesc $iDJobDesc
 * @property MasterStatusPernikahan $iDStatusNikah
 */
class MasterProduct extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $BankGroupName;
    public $BankGroupID;
    public $MJDesc;
    public $MSD;
    public $BankName;
    public $Description;
    public $Thn;
    public $Bln;
    public $IsCloseAbsen;
    public $CloseAbsenDate;
    public $jlh;
    public $JobDesk;
    public $idjob;
    public $AreaName;
    public $IDNikah;
    public $CusName;
    
    public static function tableName() {
        return 'MasterProduct';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ProductID', 'Nama', 'IDJobDesc', 'Gender', 'IDStatusNikah'], 'required','message' => '{attribute} tidak boleh kosong'],
            [['ProductID', 'IDCalonProduct', 'AreaID', 'Nama', 'IDJobDesc', 'Gender', 'NoKK', 'KTP', 'SIM', 'IDStatusNikah', 'Address', 'City', 'Zip', 'Phone', 'Mobile1', 'Mobile2', 'BankID', 'BankAccNumber', 'NPWP', 'Status', 'Class', 'UserCrt', 'UserUpdate'], 'string'],
            [['KTPExpiredDate', 'SIMExpiredDate', 'DateCrt', 'DateUpdate'], 'safe'],
            [['IsActive', 'IsBlacklist'], 'integer'],
            [['IDCalonProduct'], 'exist', 'skipOnError' => true, 'targetClass' => MasterCalonProduct::className(), 'targetAttribute' => ['IDCalonProduct' => 'CalonProductID']],
            [['IDStatusNikah'], 'exist', 'skipOnError' => true, 'targetClass' => MasterStatusPernikahan::className(), 'targetAttribute' => ['IDStatusNikah' => 'IDStatusPernikahan']],
            [['KTP','SIM','Zip', 'Phone', 'Mobile1', 'Mobile2','BankAccNumber', 'NPWP'], 'integer','message' => '{attribute} hanya boleh angka'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ProductID' => 'Product ID',
            'IDCalonProduct' => 'Idcalon Product',
            'AreaID' => 'Area ID',
            'Nama' => 'Nama',
            'IDJobDesc' => 'Idjob Desc',
            'Gender' => 'Gender',
            'NoKK' => 'Nomor KK',
            'KTP' => 'Ktp',
            'KTPExpiredDate' => 'Ktpexpired Date',
            'SIM' => 'Sim',
            'SIMExpiredDate' => 'Simexpired Date',
            'IDStatusNikah' => 'Idstatus Nikah',
            'Address' => 'Address',
            'City' => 'City',
            'Zip' => 'Zip',
            'Phone' => 'Phone',
            'Mobile1' => 'Mobile1',
            'Mobile2' => 'Mobile2',
            'BankID' => 'Bank ID',
            'BankAccNumber' => 'Bank Acc Number',
            'NPWP' => 'Npwp',
            'IsActive' => 'Is Active',
            'IsBlacklist' => 'Is Blacklist',
            'Status' => 'Status',
            'Class' => 'Class',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

}

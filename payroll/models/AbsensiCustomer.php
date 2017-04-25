<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "AbsensiCustomer".
 *
 * @property string $SODID
 * @property integer $SeqProduct
 * @property string $ProductID
 * @property string $periode
 * @property string $Tgl
 * @property string $Status
 * @property string $BackUpProductID
 * @property string $JamMasuk
 * @property string $JamKeluar
 * @property integer $InsRaya
 * @property integer $spd
 * @property integer $inap
 * @property integer $IsHadir
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class AbsensiCustomer extends \yii\db\ActiveRecord
{
    public $file;
    public $hari;
    public $tanggal;
    public $Nama;
    public $TglKeluar;
    public static function tableName()
    {
        return 'AbsensiCustomer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct', 'periode', 'Tgl'], 'required'],
            [['SODID', 'ProductID', 'periode', 'Status', 'BackUpProductID', 'UserCrt', 'UserUpdate'], 'string'],
            [['SeqProduct', 'InsRaya', 'spd', 'inap', 'IsHadir'], 'integer'],
            [['Tgl', 'JamMasuk', 'JamKeluar', 'DateCrt', 'DateUpdate'], 'safe'],
            [['ProductID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterProduct::className(), 'targetAttribute' => ['ProductID' => 'ProductID']],
            [['BackUpProductID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterProduct::className(), 'targetAttribute' => ['BackUpProductID' => 'ProductID']],
            // [['file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'ProductID' => 'Product ID',
            'periode' => 'Periode',
            'Tgl' => 'Tgl',
            'Status' => 'Status',
            'BackUpProductID' => 'Back Up Product ID',
            'JamMasuk' => 'Jam Masuk',
            'JamKeluar' => 'Jam Keluar',
            'InsRaya' => 'Ins Raya',
            'spd' => 'Spd',
            'inap' => 'Inap',
            'IsHadir' => 'Is Hadir',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @inheritdoc
     * @return AbsensiCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AbsensiCustomerQuery(get_called_class());
    }
}

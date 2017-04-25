<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "AbsensiCustomer".
 *
 * @property string $SODID
 * @property integer $SeqProduct
 * @property string $ProductID
 * @property string $Tgl
 * @property string $Status
 * @property string $BackUpProductID
 * @property string $JamMasuk
 * @property string $JamKeluar
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class AbsensiCustomer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $file;
    public $hari;
    public $tanggal;
    public $Nama;
    public $TglKeluar;

    public static function tableName() {
        return 'AbsensiCustomer';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SODID', 'SeqProduct', 'Tgl'], 'required'],
            [['SODID', 'ProductID', 'Status', 'BackUpProductID'], 'string'],
            [['SeqProduct'], 'integer'],
            [['Tgl', 'JamMasuk', 'JamKeluar', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'ProductID' => 'Product ID',
            'Tgl' => 'Tgl',
            'Status' => 'Status',
            'BackUpProductID' => 'Back Up Product ID',
            'JamMasuk' => 'Jam Masuk',
            'JamKeluar' => 'Jam Keluar',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

}

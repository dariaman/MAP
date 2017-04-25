<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "OverTime".
 *
 * @property string $SODID
 * @property integer $SeqProduct
 * @property string $tgl
 * @property string $StatusKerja
 * @property string $Periode
 * @property string $JamMasuk
 * @property string $JamKeluar
 * @property string $JadwalMasuk
 * @property string $JadwalKeluar
 * @property integer $OTPagiMenit
 * @property integer $OTMalamMenit
 * @property string $OTJamPagi
 * @property string $OTJamMalam
 * @property string $OTPointPagi
 * @property string $OTPointMalam
 * @property string $TotalPoint
 * @property string $TotalAmount
 * @property string $InsRayaAmount
 * @property string $spdAmount
 * @property string $inapAmount
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class OverTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OverTime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct', 'tgl', 'StatusKerja', 'Periode'], 'required'],
            [['SODID', 'StatusKerja', 'Periode', 'UserCrt', 'UserUpdate'], 'string'],
            [['SeqProduct', 'OTPagiMenit', 'OTMalamMenit'], 'integer'],
            [['tgl', 'JamMasuk', 'JamKeluar', 'JadwalMasuk', 'JadwalKeluar', 'DateCrt', 'DateUpdate'], 'safe'],
            [['OTJamPagi', 'OTJamMalam', 'OTPointPagi1', 'OTPointPagi2', 'OTPointPagi3', 'OTPointPagi4', 'OTPointPagi', 'OTPointMalam1', 'OTPointMalam2', 'OTPointMalam3', 'OTPointMalam4', 'OTPointMalam', 'TotalPoint', 'TotalAmount', 'InsRayaAmount', 'spdAmount', 'inapAmount'], 'number'],
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
            'tgl' => 'Tgl',
            'StatusKerja' => 'Status Kerja',
            'Periode' => 'Periode',
            'JamMasuk' => 'Jam Masuk',
            'JamKeluar' => 'Jam Keluar',
            'JadwalMasuk' => 'Jadwal Masuk',
            'JadwalKeluar' => 'Jadwal Keluar',
            'OTPagiMenit' => 'Otpagi Menit',
            'OTMalamMenit' => 'Otmalam Menit',
            'OTJamPagi' => 'Otjam Pagi',
            'OTJamMalam' => 'Otjam Malam',
            'OTPointPagi1' => 'Otpoint Pagi1',
            'OTPointPagi2' => 'Otpoint Pagi2',
            'OTPointPagi3' => 'Otpoint Pagi3',
            'OTPointPagi4' => 'Otpoint Pagi4',
            'OTPointPagi' => 'Otpoint Pagi',
            'OTPointMalam1' => 'Otpoint Malam1',
            'OTPointMalam2' => 'Otpoint Malam2',
            'OTPointMalam3' => 'Otpoint Malam3',
            'OTPointMalam4' => 'Otpoint Malam4',
            'OTPointMalam' => 'Otpoint Malam',
            'TotalPoint' => 'Total Point',
            'TotalAmount' => 'Total Amount',
            'InsRayaAmount' => 'Ins Raya Amount',
            'spdAmount' => 'Spd Amount',
            'inapAmount' => 'Inap Amount',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ]; 
    }

    /**
     * @inheritdoc
     * @return OverTimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OverTimeQuery(get_called_class());
    }
}

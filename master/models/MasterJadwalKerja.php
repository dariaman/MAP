<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterJadwalKerja".
 *
 * @property string $SODID
 * @property integer $SeqProduct
 * @property string $Tgl
 * @property string $JadwalMasuk
 * @property string $JadwalKeluar
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class MasterJadwalKerja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterJadwalKerja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct', 'Tgl', 'JadwalMasuk', 'JadwalKeluar'], 'required'],
            [['SODID'], 'string'],
            [['SeqProduct'], 'integer'],
            [['Tgl', 'JadwalMasuk', 'JadwalKeluar', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
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
            'Tgl' => 'Tgl',
            'JadwalMasuk' => 'Jadwal Masuk',
            'JadwalKeluar' => 'Jadwal Keluar',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

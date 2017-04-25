<?php

namespace app\eprocess\models;

use Yii;

class JadwalAbsensiStatusD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
//    public $AreaDesc;
    public static function tableName()
    {
        return 'JadwalAbsensiStatusD';
    }

    /**
     * @inheritdoc
     */
    public function rules()    {
        return [
            [['IDJadwalAbsensiStatusH', 'ProductID', 'SODID'], 'required'],
            [['IDJadwalAbsensiStatusH', 'ProductID', 'SODID'], 'string'],
            [['IsCloseJadwal', 'IsCloseAbsen', 'IsCloseOT', 'IsActive'], 'integer'],
            [['CloseJadwalDate', 'CloseAbsenDate', 'CloseOTDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()    {
        return [
            'IDJadwalAbsensiStatusH' => 'Idjadwal Absensi Status H',
            'ProductID' => 'Product ID',
            'SODID' => 'Sodid',
            'IsCloseJadwal' => 'Is Close Jadwal',
            'CloseJadwalDate' => 'Close Jadwal Date',
            'IsCloseAbsen' => 'Is Close Absen',
            'CloseAbsenDate' => 'Close Absen Date',
            'IsCloseOT' => 'Is Close Ot',
            'CloseOTDate' => 'Close Otdate',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

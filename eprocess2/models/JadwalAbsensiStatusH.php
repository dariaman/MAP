<?php

namespace app\eprocess\models;

use Yii;
use app\master\models\MasterCustomer;
use app\master\models\MasterArea;

class JadwalAbsensiStatusH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $ProductID;
    public $Nama;
    public $AreaDescription;
    public $AreaDetailDesc;
    public $JobDescription;
    public $LicensePlate;
    public $TglTugas;
    public $NoPKWT;
    
    public static function tableName()
    {
        return 'JadwalAbsensiStatusH';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDJadwalAbsensiStatusH', 'CustomerID', 'AreaID', 'Thn', 'Bln'], 'required'],
            [['IDJadwalAbsensiStatusH', 'CustomerID', 'AreaID', 'Thn', 'Bln'], 'string'],
            [['IsClose', 'IsActive'], 'integer'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IDJadwalAbsensiStatusH'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
         return [
            'IDJadwalAbsensiStatusH' => 'Idjadwal Absensi Status H',
            'CustomerID' => 'Customer ID',
            'AreaID' => 'Area ID',
            'Thn' => 'Thn',
            'Bln' => 'Bln',
            'IsClose' => 'Is Close',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

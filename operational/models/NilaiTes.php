<?php

namespace app\operational\models;

use Yii;
use app\master\models\MasterCalonProduct;
use app\master\models\JenisTes;

/**
 * This is the model class for table "NilaiTes".
 *
 * @property string $CalonProductID
 * @property string $TglTes
 * @property string $IDJenisTes
 * @property string $Nilai
 * @property string $UserCrt
 * @property string $DateCrt
 *
 * @property MasterCalonProduct $calonProduct
 */
class NilaiTes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $Description;
    public $Nama;
    public $JumlahNilai;
    public static function tableName()
    {
        return 'NilaiTes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CalonProductID', 'TglTes',  'Nilai'], 'required'],
            [['CalonProductID', 'IDJenisTes', 'Nilai'], 'string'],
            [['Nilai'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            [['TglTes', 'DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CalonProductID' => 'Calon Product ID',
            'TglTes' => 'Tgl Tes',
            'IDJenisTes' => 'Idjenis Tes',
            'Nilai' => 'Nilai',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     */
  
}

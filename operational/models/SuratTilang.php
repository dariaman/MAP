<?php

namespace app\operational\models;

use Yii;
use app\master\models\MasterProduct;

/**
 * This is the model class for table "SuratTilang".
 *
 * @property string $IDSuratTilang
 * @property string $ProductID
 * @property string $TglTilang
 * @property string $Description
 * @property string $UserUpdate
 * @property string $DateUpdate
 * @property string $UserCrt
 * @property string $DateCrt
 */
class SuratTilang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SuratTilang';
    }

    /**
     * @inheritdoc
     */
    public $mpnama;
    public function rules()
    {
        return [
            [['IDSuratTilang', 'ProductID', 'TglTilang'], 'required'],
            [['IDSuratTilang', 'ProductID', 'Description'], 'string'],
            [['Description'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            [['TglTilang', 'DateUpdate', 'DateCrt', 'UserUpdate', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDSuratTilang' => 'Idsurat Tilang',
            'ProductID' => 'Product ID',
            'TglTilang' => 'Tgl Tilang',
            'Description' => 'Description',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
      public function getProducts()
    {
        return $this->hasOne(MasterProduct::className(), ['ProductID' => 'ProductID']);
    }
}

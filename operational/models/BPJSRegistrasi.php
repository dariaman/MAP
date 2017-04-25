<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "BPJSRegistrasi".
 *
 * @property string $ProductID
 * @property integer $JKK
 * @property integer $JKM
 * @property integer $JHT
 * @property integer $JP
 * @property integer $BPJS
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class BPJSRegistrasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BPJSRegistrasi';
    }

    /**
     * @inheritdoc
     */
    public $Nama;
    public function rules()
    {
        return [
            [['ProductID'], 'required'],
            [['ProductID', 'UserCrt', 'UserUpdate'], 'string'],
            [['JKK', 'JKM', 'JHT', 'JP', 'BPJS'], 'integer'],
            [['DateCrt', 'DateUpdate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ProductID' => 'Product ID',
            'JKK' => 'Jkk',
            'JKM' => 'Jkm',
            'JHT' => 'Jht',
            'JP' => 'Jp',
            'BPJS' => 'Bpjs',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @inheritdoc
     * @return BPJSRegistrasiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BPJSRegistrasiQuery(get_called_class());
    }
}

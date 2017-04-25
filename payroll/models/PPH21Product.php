<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "PPH21Product".
 *
 * @property string $ProductID
 * @property string $Periode
 * @property string $Gapok
 * @property string $Tunjangan
 * @property string $Potongan
 * @property string $BiayaJabatan
 * @property string $PTKP
 * @property string $PKP
 * @property string $PPH21Amount
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class PPH21Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PPH21Product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'Periode'], 'required'],
            [['ProductID', 'Periode', 'UserCrt', 'UserUpdate'], 'string'],
            [['Gapok', 'Tunjangan', 'Potongan', 'BiayaJabatan', 'PTKP', 'PKP', 'PPH21Amount'], 'number'],
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
            'Periode' => 'Periode',
            'Gapok' => 'Gapok',
            'Tunjangan' => 'Tunjangan',
            'Potongan' => 'Potongan',
            'BiayaJabatan' => 'Biaya Jabatan',
            'PTKP' => 'Ptkp',
            'PKP' => 'Pkp',
            'PPH21Amount' => 'Pph21 Amount',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @inheritdoc
     * @return PPH21ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PPH21ProductQuery(get_called_class());
    }
}

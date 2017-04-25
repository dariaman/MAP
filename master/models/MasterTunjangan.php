<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterTunjangan".
 *
 * @property string $IDTunjangan
 * @property string $Description
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 */
class MasterTunjangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterTunjangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDTunjangan', 'Description'], 'string'],
            [['Description'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['IsActive'], 'integer'],
            [['DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDTunjangan' => 'Idtunjangan',
            'Description' => 'Description',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

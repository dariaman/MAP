<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterPotongan".
 *
 * @property string $IDPotongan
 * @property string $Description
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 */
class MasterPotongan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterPotongan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDPotongan', 'Description'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['IDPotongan', 'Description'], 'string'],
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
            'IDPotongan' => 'Idpotongan',
            'Description' => 'Description',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

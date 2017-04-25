<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "HariLibur".
 *
 * @property string $Tgl
 * @property string $Ket
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class HariLibur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'HariLibur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tgl'], 'required'],
            [['Tgl', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['Ket'], 'string'],
            [['IsActive'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Tgl' => 'Tgl',
            'Ket' => 'Ket',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

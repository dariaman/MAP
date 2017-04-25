<?php

namespace app\general\models;

use Yii;

/**
 * This is the model class for table "ListFormulaPoint".
 *
 * @property string $JenisFormulaPoint
 * @property string $Description
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class ListFormulaPoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ListFormulaPoint';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JenisFormulaPoint'], 'required'],
            [['JenisFormulaPoint', 'Description'], 'string'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'JenisFormulaPoint' => 'Jenis Formula Point',
            'Description' => 'Description',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

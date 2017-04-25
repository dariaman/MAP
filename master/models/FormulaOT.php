<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "FormulaOT".
 *
 * @property integer $IDFormula
 * @property string $FormulaFunction
 * @property string $Keterangan
 * @property string $UserCrt
 * @property string $DateCrt
 */
class FormulaOT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FormulaOT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FormulaFunction', 'Keterangan'], 'required'],
            [['FormulaFunction', 'Keterangan'], 'string'],
            [['DateCrt', 'UserCrt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDFormula' => 'Idformula',
            'FormulaFunction' => 'Formula Function',
            'Keterangan' => 'Keterangan',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

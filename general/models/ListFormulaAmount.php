<?php

namespace app\general\models;

use Yii;

/**
 * This is the model class for table "ListFormulaAmount".
 *
 * @property string $JenisFormulaAmount
 * @property string $Description
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class ListFormulaAmount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ListFormulaAmount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JenisFormulaAmount'], 'required'],
            [['JenisFormulaAmount', 'Description'], 'string'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'JenisFormulaAmount' => 'Jenis Formula Amount',
            'Description' => 'Description',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

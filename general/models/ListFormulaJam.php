<?php

namespace app\general\models;

use Yii;

/**
 * This is the model class for table "ListFormulaJam".
 *
 * @property string $JenisFormulaJam
 * @property string $Description
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class ListFormulaJam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ListFormulaJam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JenisFormulaJam'], 'required'],
            [['JenisFormulaJam', 'Description'], 'string'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'JenisFormulaJam' => 'Jenis Formula Jam',
            'Description' => 'Description',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

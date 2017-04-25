<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "JenisTes".
 *
 * @property string $IDJenisTes
 * @property string $Description
 *
 * @property NilaiTes[] $nilaiTes
 */
class JenisTes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JenisTes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDJenisTes'], 'required'],
            [['IDJenisTes', 'Description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDJenisTes' => 'Idjenis Tes',
            'Description' => 'Description',
        ];
    }
}

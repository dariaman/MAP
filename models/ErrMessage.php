<?php

namespace app\models;


class ErrMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ErrMessage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ErrorMessage'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ErrorMessage' => 'Error Message',
        ];
    }
}

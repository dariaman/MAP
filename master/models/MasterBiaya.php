<?php

namespace app\master\models;

use Yii;

class MasterBiaya extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'MasterBiaya';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SeqNo', 'BiayaID', 'Description', 'TipeBiaya'], 'required'],
            [['SeqNo', 'IsActive'], 'integer'],
            [['BiayaID', 'Description', 'TipeBiaya'], 'string'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['SeqNo'], 'unique'],
            [['Description'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SeqNo' => 'Seq No',
            'BiayaID' => 'Biaya ID',
            'Description' => 'Description',
            'TipeBiaya' => 'Tipe Biaya',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

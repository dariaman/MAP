<?php

namespace app\master\models;

use Yii;

class MasterJobDesc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterJobDesc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDJobDesc', 'Description'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['IDJobDesc', 'Description', 'Code'], 'string'],
            [['Description', 'Code'], 'trim'],
            [['IsActive'], 'integer'],
            [['DateCrt','UserCrt'], 'safe'],
            [['Description'],'match','pattern'=> '/^[A-Za-z0-9 ]+$/u','message'=> 'Tidak boleh menggunakan tanda baca'],
            [['Code'],'match','pattern'=> '/^[A-Za-z]+$/u','message'=> 'Harus menggunakan huruf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IDJobDesc' => 'Idjob Desc',
            'Description' => 'Description',
            'Code' => 'Code',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

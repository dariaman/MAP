<?php

namespace app\finance\models;

use Yii;

class FakturPajakH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FakturPajakH';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EntityID', 'TahunPajak', 'TrDate', 'NoAwal', 'NoAkhir', 'StartPeriod', 'EndPeriod'], 'required'],
            [['EntityID', 'TahunPajak', 'NoAwal', 'NoAkhir'], 'string'],
            [['TrDate', 'StartPeriod', 'EndPeriod', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['IsActive'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TRNo' => 'Trno',
            'EntityID' => 'Entity ID',
            'TahunPajak' => 'Tahun Pajak',
            'TrDate' => 'Tr Date',
            'NoAwal' => 'No Awal',
            'NoAkhir' => 'No Akhir',
            'StartPeriod' => 'Start Period',
            'EndPeriod' => 'End Period',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

<?php

namespace app\operational\models;

use Yii;

class OfferingD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OfferingD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OfferingDID', 'OfferingIDH', 'AreaID', 'Class'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['OfferingDID', 'OfferingIDH', 'AreaID', 'Class'], 'string'],
            [['TotalA', 'TotalB', 'TotalDppHpp', 'TotalMfee', 'TotalDPP', 'PPN', 'TotalHargaDriver','PPNSS','TotalHargaDriverSS'], 'number'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OfferingDID' => 'Offering Did',
            'OfferingIDH' => 'Offering Idh',
            'AreaID' => 'Area ID',
            'Class' => 'Class',
            'TotalA' => 'Total A', 
            'TotalB' => 'Total B', 
            'TotalDppHpp' => 'Total Dpp Hpp', 
            'TotalMfee' => 'Total Mfee', 
            'TotalDPP' => 'Total Dpp', 
            'PPN' => 'Ppn', 
            'PPNSS' => 'Ppn SS', 
            'TotalHargaDriver' => 'Total Harga Driver', 
            'TotalHargaDriverSS' => 'Total Harga Driver SS', 
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];

    }
}

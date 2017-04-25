<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "master_area".
 *
 * @property string $ID
 * @property string $Description
 * @property integer $IsActive
 * @property string $usercrt
 * @property string $datecrt
 *
 * @property MasterGajipokok[] $masterGajipokoks
 * @property OfferingHdr[] $offeringHdrs
 */
class MasterArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterArea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AreaID', 'Description'], 'required','message' => '{attribute} tidak boleh kosong'],
            [['AreaID', 'Description', ], 'string'],
            [['IsActive'], 'integer'],
            [['DateCrt','UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AreaID' => 'AreaID',
            'Description' => 'Area Name',
            'IsActive' => 'Is Active',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
        ];
    }
}

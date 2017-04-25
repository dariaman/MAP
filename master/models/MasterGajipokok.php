<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterGajiPokok".
 *
 * @property string $GapokID
 * @property integer $SeqID
 * @property string $IDJobDesc
 * @property string $AreaID
 * @property string $UMP
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $StartMonth
 * @property string $StartYear
 *
 * @property MasterArea $area
 * @property MasterJobDesc $iDJobDesc
 * @property OfferingD[] $offeringDs
 * @property OfferingD[] $offeringDs0
 */
class MasterGajiPokok extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterGajiPokok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GapokID', 'SeqID', 'IDJobDesc', 'AreaID', 'UMP'], 'required' ,'message' => '{attribute} tidak boleh kosong.'],
            [['GapokID', 'IDJobDesc', 'AreaID'], 'string'],
            [['SeqID'], 'integer'],
            [['UMP','GSFee'], 'number'],
            [['UserCrt','DateCrt',], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GapokID' => 'Gapok ID',
            'SeqID' => 'Seq ID',
            'IDJobDesc' => 'Idjob Desc',
            'AreaID' => 'Area ID',
            'UMP' => 'UMP',
            'GSFee' => 'GSFee',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'StartMonth' => 'Start Month',
            'StartYear' => 'Start Year',
        ];
    }
}

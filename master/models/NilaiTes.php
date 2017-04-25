<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "NilaiTes".
 *
 * @property string $CalonProductID
 * @property string $TglTes
 * @property string $IDJenisTes
 * @property integer $Nilai
 * @property string $UserCrt
 * @property string $DateCrt
 */
class NilaiTes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NilaiTes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CalonProductID', 'TglTes', 'IDJenisTes', 'Nilai'], 'required'],
            [['CalonProductID', 'IDJenisTes'], 'string'],
            [['TglTes', 'DateCrt', 'UserCrt'], 'safe'],
            [['Nilai'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CalonProductID' => 'Calon Product ID',
            'TglTes' => 'Tgl Tes',
            'IDJenisTes' => 'Idjenis Tes',
            'Nilai' => 'Nilai',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

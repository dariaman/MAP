<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "master_absentype".
 *
 * @property integer $ID
 * @property integer $startAbsen
 * @property integer $endAbsen
 * @property integer $IsActive
 * @property string $usercrt
 * @property string $datecrt
 */
class MasterAbsentype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterAbsenType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StartAbsen', 'EndAbsen'], 'required','message' => '{attribute} tidak boleh kosong.'],
            [['StartAbsen', 'EndAbsen'], 'integer'],
            [[], 'string'],
            [['UserCrt','DateCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'StartAbsen' => 'Absen Start',
            'EndAbsen' => 'Absen End',
            'IsActive' => 'Is Active',
            'UserCrt' => 'Usercrt',
            'DateCrt' => 'Datecrt',
        ];
    }
}

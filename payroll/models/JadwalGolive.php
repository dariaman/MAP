<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "JadwalGolive".
 *
 * @property string $SODID
 * @property integer $SeqProduct
 * @property integer $JlhHariKerja
 * @property string $Monday1
 * @property string $Monday2
 * @property string $Tuesday1
 * @property string $Tuesday2
 * @property string $Wednesday1
 * @property string $Wednesday2
 * @property string $Thursday1
 * @property string $Thursday2
 * @property string $Friday1
 * @property string $Friday2
 * @property string $Saturday1
 * @property string $Saturday2
 * @property string $Sunday1
 * @property string $Sunday2
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 *
 * @property GoLiveProduct $seqProduct
 * @property GoLiveProduct $sOD
 */
class JadwalGolive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JadwalGolive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct'], 'required'],
            [['SODID', 'UserCrt', 'UserUpdate'], 'string'],
            [['SeqProduct', 'JlhHariKerja'], 'integer'],
            [['Monday1', 'Monday2', 'Tuesday1', 'Tuesday2', 'Wednesday1', 'Wednesday2', 'Thursday1', 'Thursday2', 'Friday1', 'Friday2', 'Saturday1', 'Saturday2', 'Sunday1', 'Sunday2', 'DateCrt', 'DateUpdate'], 'safe'],
            [['SeqProduct'], 'exist', 'skipOnError' => true, 'targetClass' => GoLiveProduct::className(), 'targetAttribute' => ['SeqProduct' => 'SeqProduct']],
            [['SODID'], 'exist', 'skipOnError' => true, 'targetClass' => GoLiveProduct::className(), 'targetAttribute' => ['SODID' => 'SODID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'JlhHariKerja' => 'Jlh Hari Kerja',
            'Monday1' => 'Monday1',
            'Monday2' => 'Monday2',
            'Tuesday1' => 'Tuesday1',
            'Tuesday2' => 'Tuesday2',
            'Wednesday1' => 'Wednesday1',
            'Wednesday2' => 'Wednesday2',
            'Thursday1' => 'Thursday1',
            'Thursday2' => 'Thursday2',
            'Friday1' => 'Friday1',
            'Friday2' => 'Friday2',
            'Saturday1' => 'Saturday1',
            'Saturday2' => 'Saturday2',
            'Sunday1' => 'Sunday1',
            'Sunday2' => 'Sunday2',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeqProduct()
    {
        return $this->hasOne(GoLiveProduct::className(), ['SeqProduct' => 'SeqProduct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOD()
    {
        return $this->hasOne(GoLiveProduct::className(), ['SODID' => 'SODID']);
    }

    /**
     * @inheritdoc
     * @return JadwalGoliveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JadwalGoliveQuery(get_called_class());
    }
}

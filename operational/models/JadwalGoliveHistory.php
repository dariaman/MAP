<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "JadwalGoliveHistory".
 *
 * @property string $SODID
 * @property integer $SeqProduct
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
 */
class JadwalGoliveHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JadwalGoliveHistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct'], 'required'],
            [['SODID', 'UserCrt', 'UserUpdate'], 'string'],
            [['SeqProduct'], 'integer'],
            [['Monday1', 'Monday2', 'Tuesday1', 'Tuesday2', 'Wednesday1', 'Wednesday2', 'Thursday1', 'Thursday2', 'Friday1', 'Friday2', 'Saturday1', 'Saturday2', 'Sunday1', 'Sunday2', 'DateCrt', 'DateUpdate'], 'safe']
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
}

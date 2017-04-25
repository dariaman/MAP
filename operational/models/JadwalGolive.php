<?php

namespace app\operational\models;

use Yii;

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
            [['SODID'], 'required'],
            [['SODID','SeqProduct', 'Monday1', 'Monday2', 'Tuesday1', 'Tuesday2', 'Wednesday1', 'Wednesday2', 'Thursday1', 'Thursday2', 'Friday1', 'Friday2', 'Saturday1', 'Saturday2', 'Sunday1', 'Sunday2'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SODID' => 'SODID ID',
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
        ];
    }
}

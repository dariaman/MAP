<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "SOCostCalc".
 *
 * @property string $SODID
 * @property string $BiayaID
 * @property string $Amount
 * @property string $Remark
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class SOCostCalc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOCostCalc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'BiayaID', 'Amount'], 'required'],
            [['SODID', 'BiayaID', 'Remark'], 'string'],
            [['Amount'], 'number'],
            [['DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SODID' => 'Sodid',
            'BiayaID' => 'Biaya ID',
            'Amount' => 'Amount',
            'Remark' => 'Remark',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

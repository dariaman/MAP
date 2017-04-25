<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "SuratPeringatan".
 *
 * @property string $SpNo
 * @property string $SpDate
 * @property string $ProductID
 * @property string $Remark
 * @property string $ApproveBy
 * @property string $ApproveDate
 * @property string $UserCrt
 * @property string $DateCrt
 */
class SuratPeringatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SuratPeringatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SpNo', 'ProductID', 'ApproveDate'], 'required'],
            [['SpNo', 'ProductID', 'Remark', 'ApproveBy'], 'string'],
            [['SpDate', 'ApproveDate', 'DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SpNo' => 'Sp No',
            'SpDate' => 'Sp Date',
            'ProductID' => 'Product ID',
            'Remark' => 'Remark',
            'ApproveBy' => 'Approve By',
            'ApproveDate' => 'Approve Date',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

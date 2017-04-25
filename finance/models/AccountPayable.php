<?php

namespace app\finance\models;

use Yii;

/**
 * This is the model class for table "AccountPayable".
 *
 * @property string $APNo
 * @property string $APDate
 * @property string $TotalAmount
 * @property string $PPN
 * @property string $PaidNo
 * @property string $PaidDate
 * @property string $PaidRemark
 * @property string $UserCrt
 * @property string $DateCrt
 */
class AccountPayable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AccountPayable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['APNo', 'APDate', 'TotalAmount', 'PPN', 'PaidNo'], 'required'],
            [['APNo', 'TotalAmount', 'PaidNo', 'PaidRemark'], 'string'],
            [['APDate', 'PaidDate', 'DateCrt', 'UserCrt'], 'safe'],
            [['PPN'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'APNo' => 'Apno',
            'APDate' => 'Apdate',
            'TotalAmount' => 'Total Amount',
            'PPN' => 'Ppn',
            'PaidNo' => 'Paid No',
            'PaidDate' => 'Paid Date',
            'PaidRemark' => 'Paid Remark',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

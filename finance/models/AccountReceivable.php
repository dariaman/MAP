<?php

namespace app\finance\models;

use Yii;

/**
 * This is the model class for table "AccountReceivable".
 *
 * @property string $ARNo
 * @property string $InvoiceNo
 * @property string $RefNo
 * @property string $PaymentDate
 * @property string $UserCrt
 * @property string $DateCrt
 */
class AccountReceivable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AccountReceivable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ARNo'], 'required'],
            [['ARNo', 'InvoiceNo', 'RefNo'], 'string'],
            [['PaymentDate', 'DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ARNo' => 'Arno',
            'InvoiceNo' => 'Invoice No',
            'RefNo' => 'Ref No',
            'PaymentDate' => 'Payment Date',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

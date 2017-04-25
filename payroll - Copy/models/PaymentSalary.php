<?php

namespace app\payroll\models;

use Yii;

/**
 * This is the model class for table "PaymentSalary".
 *
 * @property string $APNO
 * @property string $APDate
 * @property string $PayrollGajiIDH
 * @property string $AmountPayment
 * @property string $BiayaAdmin
 * @property string $IDBankMAP
 * @property string $BankGroupProduct
 * @property string $RekBankProduct
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class PaymentSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PaymentSalary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['APNO', 'APDate', 'PayrollGajiIDH', 'AmountPayment', 'BiayaAdmin', 'IDBankMAP', 'BankGroupProduct', 'RekBankProduct'], 'required'],
            [['APNO', 'PayrollGajiIDH', 'IDBankMAP', 'BankGroupProduct', 'RekBankProduct'], 'string'],
            [['APDate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe'],
            [['AmountPayment', 'BiayaAdmin'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'APNO' => 'Apno',
            'APDate' => 'Apdate',
            'PayrollGajiIDH' => 'Payroll Gaji Idh',
            'AmountPayment' => 'Amount Payment',
            'BiayaAdmin' => 'Biaya Admin',
            'IDBankMAP' => 'Idbank Map',
            'BankGroupProduct' => 'Bank Group Product',
            'RekBankProduct' => 'Rek Bank Product',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterBankGroup".
 *
 * @property string $BankGroupID
 * @property string $BankGroupName
 * @property string $BiayaAdm
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class MasterBankGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterBankGroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BankGroupID', 'BankGroupName', 'BiayaAdm'], 'required'],
            [['BankGroupID', 'BankGroupName', 'UserCrt', 'UserUpdate'], 'string'],
            [['BiayaAdm'], 'number'],
            [['IsActive'], 'integer'],
            [['DateCrt', 'DateUpdate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BankGroupID' => 'Bank Group ID',
            'BankGroupName' => 'Bank Group Name',
            'BiayaAdm' => 'Biaya Adm',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @inheritdoc
     * @return MasterBankGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterBankGroupQuery(get_called_class());
    }
}

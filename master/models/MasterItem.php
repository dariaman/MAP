<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "MasterItem".
 *
 * @property string $ItemID
 * @property string $ItemDescription
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 */
class MasterItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterItem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID','ItemDescription'], 'required'],
            [['ItemID', 'ItemDescription', 'UserCrt'], 'string'],
            [['ItemDescription'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> '  only [a-zA-Z0-9_].'],
            [['IsActive'], 'integer'],
            [['DateCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemDescription' => 'Item Description',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
        ];
    }
}

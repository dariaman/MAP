<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "master_statuspernikahan".
 *
 * @property integer $ID
 * @property string $Description
 * @property integer $IsActive
 * @property string $usercrt
 * @property string $datecrt
 */
class MasterStatuspernikahan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MasterStatusPernikahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description'], 'string'],
            [['IsActive'], 'integer'],
            [['DateCrt', 'UserCrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Description' => 'Description',
            'IsActive' => 'Is Active',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
        ];
    }
}

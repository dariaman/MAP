<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "DeliveryOrder".
 *
 * @property string $DONo
 * @property integer $Qty
 * @property string $SODID
 * @property string $GRID
 * @property string $DODate
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class DeliveryOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DeliveryOrder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DONo', 'Qty', 'SODID', 'GRID', 'DODate'], 'required'],
            [['DONo', 'SODID', 'GRID'], 'string'],
            [['Qty'], 'integer'],
            [['DODate', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DONo' => 'Dono',
            'Qty' => 'Qty',
            'SODID' => 'Sodid',
            'GRID' => 'Grid',
            'DODate' => 'Dodate',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }
}

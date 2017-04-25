<?php

namespace app\master\models;

use Yii;

/**
 * This is the model class for table "Book".
 *
 * @property string $name
 * @property integer $buy_amount
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Book';
    }
    
    public $status;
    public $color;
    public function rules()
    {
        return [
            [['name', 'buy_amount'], 'required'],
            [['name', 'buy_amount'], 'safe'],
            [['buy_amount'], 'number', 'min'=>0, 'max'=>5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'buy_amount' => 'Buy Amount',
        ];
    }
}

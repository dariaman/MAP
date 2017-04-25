<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Loguser".
 *
 * @property integer $id
 * @property string $host
 * @property string $browser
 * @property string $logged_in_ip
 * @property string $logged_in_at
 */
class Loguser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Loguser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['host', 'browser', 'logged_in_ip'], 'string'],
            [['logged_in_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host' => 'Host',
            'browser' => 'Browser',
            'logged_in_ip' => 'Logged In Ip',
            'logged_in_at' => 'Logged In At',
        ];
    }
}

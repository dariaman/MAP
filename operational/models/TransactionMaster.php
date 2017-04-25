<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "TransactionMaster".
 *
 * @property string $TransID
 * @property string $Transtype
 * @property string $PIC
 * @property string $NextPIC
 * @property string $Status
 * @property string $Reason
 * @property string $usercrt
 * @property string $datecrt
 * @property string $LastUpdateBy
 * @property string $LastUpdateOn
 * @property string $ApproveBy
 * @property string $ApproveDate
 */
class TransactionMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $CustomerName;
    public $Description;
    
    public static function tableName()
    {
        return 'TransactionMaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TransID', 'Transtype', 'PIC', 'NextPIC', 'Status'], 'required'],
            [['TransID', 'Transtype', 'PIC', 'NextPIC', 'Status', 'Reason'], 'string'],
            [['datecrt', 'LastUpdateOn', 'ApproveDate', 'usercrt', 'LastUpdateBy', 'ApproveBy'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TransID' => 'Trans ID',
            'Transtype' => 'Transtype',
            'PIC' => 'Pic',
            'NextPIC' => 'Next Pic',
            'Status' => 'Status',
            'Reason' => 'Reason',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
            'LastUpdateBy' => 'Last Update By',
            'LastUpdateOn' => 'Last Update On',
            'ApproveBy' => 'Approve By',
            'ApproveDate' => 'Approve Date',
        ];
    }
}

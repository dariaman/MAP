<?php

namespace app\operational\models;

use Yii;

/**
 * This is the model class for table "BackupProduct".
 *
 * @property string $ProductIDGS
 * @property string $SODID
 * @property integer $SeqProduct
 * @property string $ProductIDFix
 * @property string $TglTugas
 * @property string $PeriodTo
 * @property string $StatusAbsen
 * @property string $Reason
 * @property integer $IsExpired
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 */
class BackupProduct extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $ProductNameGs;
    public $ProductNameFix;
    public $CustomerID;
//    public $adhi25;
    public $NamaGs;
    public $NamaFix;

    public static function tableName() {
        return 'BackupProduct';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['BackupID', 'ProductIDGS', 'SODID', 'SeqProduct', 'TglTugas', 'PeriodTo', 'StatusAbsen', 'Reason' ], 'required'],
            [['BackupID', 'ProductIDGS', 'SODID', 'ProductIDFix', 'StatusAbsen', 'Reason'], 'string'],
            [['SeqProduct', 'IsExpired'], 'integer'],
            [['TglTugas', 'PeriodTo', 'DateCrt', 'DateUpdate', 'UserCrt', 'UserUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'BackupID' => 'Backup ID',
            'ProductIDGS' => 'Product Idgs',
            'SODID' => 'Sodid',
            'SeqProduct' => 'Seq Product',
            'ProductIDFix' => 'Product Idfix',
            'TglTugas' => 'Tgl Tugas',
            'PeriodTo' => 'Period To',
            'StatusAbsen' => 'Status Absen',
            'Reason' => 'Reason',
            'IsExpired' => 'Is Expired',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

}

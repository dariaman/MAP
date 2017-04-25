<?php

namespace app\operational\models;

use Yii;
use app\operational\models\MasterProduct;

/**
 * This is the model class for table "ProductPKWT".
 *
 * @property string $ProductID
 * @property string $PeriodFrom
 * @property string $PeriodTo
 * @property string $GajiPokok
 * @property string $Status
 * @property integer $IsActive
 * @property string $UserCrt
 * @property string $DateCrt
 * @property string $UserUpdate
 * @property string $DateUpdate
 *
 * @property MasterProduct $product
 */
class ProductPKWT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProductPKWT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'PeriodFrom', 'PeriodTo', 'GajiPokok'], 'required'],
            [['ProductID', 'Status', 'UserCrt', 'UserUpdate'], 'string'],
            [['PeriodFrom', 'PeriodTo', 'DateCrt', 'DateUpdate'], 'safe'],
            [['GajiPokok'], 'number'],
            [['IsActive'], 'integer'],
            // [['ProductID'], 'exist', 'skipOnError' => true, 'targetClass' => MasterProduct::className(), 'targetAttribute' => ['ProductID' => 'ProductID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ProductID' => 'Product ID',
            'PeriodFrom' => 'Period From',
            'PeriodTo' => 'Period To',
            'GajiPokok' => 'Gaji Pokok',
            'Status' => 'Status',
            'IsActive' => 'Is Active',
            'UserCrt' => 'User Crt',
            'DateCrt' => 'Date Crt',
            'UserUpdate' => 'User Update',
            'DateUpdate' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(MasterProduct::className(), ['ProductID' => 'ProductID']);
    }
}

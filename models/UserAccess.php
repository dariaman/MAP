<?php

namespace app\models;


/**
 * This is the model class for table "UserAccess".
 *
 * @property string $GroupID
 * @property integer $MenuID
 * @property integer $isAktif
 * @property string $usercrt
 * @property string $datecrt
 *
 * @property MasterUserGroup $group
 * @property MsMenu $menu
 */
class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserAccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GroupID', 'MenuID', 'usercrt', 'datecrt'], 'required'],
            [['GroupID'], 'string'],
            [['MenuID', 'isAktif'], 'integer'],
            [['usercrt', 'datecrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GroupID' => 'Group ID',
            'MenuID' => 'Menu ID',
            'isAktif' => 'Is Aktif',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(MasterUserGroup::className(), ['GroupID' => 'GroupID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(MsMenu::className(), ['MenuID' => 'MenuID']);
    }
}

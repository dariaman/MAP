<?php

namespace app\models;


class MsMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MsMenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MenuID', 'MenuName', 'LinkAddress', 'ParentID'], 'required'],
            [['MenuID', 'MenuName', 'LinkAddress'], 'string'],
            [['ParentID', 'IsAktif'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MenuID' => 'Menu ID',
            'MenuName' => 'Menu Name',
            'LinkAddress' => 'Link Address',
            'ParentID' => 'Parent ID',
            'IsAktif' => 'Is Aktif',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccesses()
    {
        return $this->hasMany(UserAccess::className(), ['MenuID' => 'MenuID']);
    }
}

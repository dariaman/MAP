<?php

namespace app\models;


/**
 * This is the model class for table "master_userGroup".
 *
 * @property string $GroupID
 * @property string $GroupName
 * @property integer $isAktif
 * @property string $usercrt
 * @property string $datecrt
 *
 * @property UserAccess[] $userAccesses
 * @property UserLogin[] $userLogins
 */
class MasterUserGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_userGroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GroupID', 'GroupName', 'datecrt'], 'required'],
            [['GroupID', 'GroupName', 'usercrt'], 'string'],
            [['isAktif'], 'integer'],
            [['datecrt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GroupID' => 'Group ID',
            'GroupName' => 'Group Name',
            'isAktif' => 'Is Aktif',
            'usercrt' => 'Usercrt',
            'datecrt' => 'Datecrt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccesses()
    {
        return $this->hasMany(UserAccess::className(), ['GroupID' => 'GroupID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLogins()
    {
        return $this->hasMany(UserLogin::className(), ['UserGroupID' => 'GroupID']);
    }
}

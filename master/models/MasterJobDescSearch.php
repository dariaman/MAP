<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterJobDesc;


class MasterJobDescSearch extends MasterJobDesc
{
    
    public function rules()
    {
        return [
            [['IDJobDesc', 'Description'], 'required'],
            [['IDJobDesc', 'Description', 'Code', 'UserCrt'], 'string'],
            [['IsActive'], 'integer'],
            [['DateCrt'], 'safe'],
        ];        
    }

    public function scenarios(){
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MasterJobDesc::find()->select('IDJobDesc,Description,Code,IsActive')
                ->orderBy(['Description'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> ['defaultPageSize' => 100],
            'sort' => false,
        ]);
        return $dataProvider;
    }
}

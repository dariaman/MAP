<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterBiaya;

class MasterBiayaSearch extends MasterBiaya
{

    public function rules()
    {
        return [
            [['BiayaID', 'Description', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
        ];
    }
    
    public function scenarios(){
        return Model::scenarios();
    }

    public function SearchBiaya($params){
        $query = MasterBiaya::find()->orderBy(['SeqNo'=>SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $cariData = $params;

        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
            if(isset($params['typeSearch']) && isset($params['textsearch'])) {
                $cariData = ['MasterBiayaSearch'=> [
                    'r'  => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
                ]];
            }
        }
        
        $this->load($cariData);        
        $query->andFilterWhere([
            'BiayaID' => $this->BiayaID,
            'Description' => $this->Description,
        ]);
        
        return $dataProvider;
    }
}

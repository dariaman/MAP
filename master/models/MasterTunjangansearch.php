<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterTunjangan;

/**
 * MasterTunjanganSearch represents the model behind the search form about `app\master\models\MasterTunjangan`.
 */
class MasterTunjanganSearch extends MasterTunjangan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDTunjangan', 'Description', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios(){
        return Model::scenarios();
    }
    
    public function search($params){
        $query = MasterTunjangan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        
        $CariData=$params;
        
        if(isset($params['typeSearch'])&& isset($params['textsearch']))  {
           $CariData = ['MasterTunjanganSearch'=> [
                 'r'=>$params['r'],
                  $params['typeSearch'] => $params['textsearch'],
           ]];
        }
 
        $this->load($CariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'IDTunjangan' => $this->IDTunjangan,
            'Description' => $this->Description,
        ]);

        return $dataProvider;
    }
}

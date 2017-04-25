<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterPotongan;

/**
 * MasterPotongansearch represents the model behind the search form about `app\master\models\MasterPotongan`.
 */
class MasterPotongansearch extends MasterPotongan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDPotongan', 'Description', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = MasterPotongan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

       $CariData=$params;
        
        if(isset($params['typeSearch'])&& isset($params['textsearch'])){
           $CariData = ['MasterPotongansearch'=> [
                 'r'=>$params['r'],
                  $params['typeSearch'] => $params['textsearch'],
           ]];
        }
 
        $this->load($CariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'IDPotongan' => $this->IDPotongan,
            'Description' => $this->Description,
        ]);

        return $dataProvider;
    }
}

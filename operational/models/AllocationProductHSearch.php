<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\AllocationProductH;

/**
 * AllocationProductHSearch represents the model behind the search form about `app\operational\models\AllocationProductH`.
 */
class AllocationProductHSearch extends AllocationProductH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AllocationProductIDH', 'SOIDH', 'Description', 'PicCustomer', 'UserCrt', 'DateCrt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AllocationProductH::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;

        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            
            if($params['typeSearch'] == '1')
            {
                $cariData = ['AllocationProductHSearch'=> [
                        'r'  => $params['r'],
                        'AllocationProductIDH'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '2')
            {
                $cariData = ['AllocationProductHSearch'=> [
                        'r'  => $params['r'],
                        'SOIDH'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '3')
            {
                $cariData = ['AllocationProductHSearch'=> [
                        'r'  => $params['r'],
                        'PicCustomer'  => $params['textsearch'],
                    ]];
            }
        }
        
        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'AllocationProductIDH' => $this->AllocationProductIDH,
            'SOIDH' => $this->SOIDH,
            'PicCustomer' => $this->PicCustomer
        ]);

        return $dataProvider;
    }
}

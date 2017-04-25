<?php

namespace app\general\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\general\models\ListFormulaAmount;

/**
 * ListFormulaAmountSearch represents the model behind the search form about `app\general\models\ListFormulaAmount`.
 */
class ListFormulaAmountSearch extends ListFormulaAmount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JenisFormulaAmount', 'Description', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
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
        $query = ListFormulaAmount::find()
                ->select('JenisFormulaAmount,Description')
                ->orderBy(['JenisFormulaAmount'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false
        ]);
           
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
             $cariData = ['ListFormulaAmountSearch'=> [
                 'r'  => $params['r'],
                 $params['typeSearch'] => $params['textsearch'],
             ]];
         }
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'JenisFormulaAmount' => $this->JenisFormulaAmount,
            'Description' => $this->Description,
        ]);

        return $dataProvider;
//        
//        $query = ListFormulaAmount::find();
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        $query->andFilterWhere([
//            'DateCrt' => $this->DateCrt,
//            'DateUpdate' => $this->DateUpdate,
//        ]);
//
//        $query->andFilterWhere(['like', 'JenisFormulaAmount', $this->JenisFormulaAmount])
//            ->andFilterWhere(['like', 'Description', $this->Description])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
//            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);
//
//        return $dataProvider;
    }
}

<?php

namespace app\general\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\general\models\ListFormulaJam;

/**
 * ListFormulaJamSearch represents the model behind the search form about `app\general\models\ListFormulaJam`.
 */
class ListFormulaJamSearch extends ListFormulaJam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JenisFormulaJam', 'Description', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
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
         $query = ListFormulaJam::find()
                ->select('JenisFormulaJam,Description')
                ->orderBy(['JenisFormulaJam'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false
        ]);
           
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
             $cariData = ['ListFormulaJamSearch'=> [
                 'r'  => $params['r'],
                 $params['typeSearch'] => $params['textsearch'],
             ]];
         }
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'JenisFormulaJam' => $this->JenisFormulaJam,
            'Description' => $this->Description,
        ]);

        return $dataProvider;
//        
//        
//        $query = ListFormulaJam::find();
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
//        $query->andFilterWhere(['like', 'JenisFormulaJam', $this->JenisFormulaJam])
//            ->andFilterWhere(['like', 'Description', $this->Description])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
//            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);
//
//        return $dataProvider;
    }
}

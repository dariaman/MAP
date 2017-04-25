<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PayrollGajiH;

/**
 * PayrollGajiHSearch represents the model behind the search form about `app\payroll\models\PayrollGajiH`.
 */
class PayrollGajiHSearch extends PayrollGajiH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PayrollGajiIDH', 'ProductID', 'bln', 'thn', 'CustomerID', 'AreaID', 'Status', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['FixAmount', 'TunjanganAmount', 'PotonganAmount', 'PPH21', 'Total'], 'number'],
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
        $query = PayrollGajiH::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'FixAmount' => $this->FixAmount,
            'TunjanganAmount' => $this->TunjanganAmount,
            'PotonganAmount' => $this->PotonganAmount,
            'PPH21' => $this->PPH21,
            'Total' => $this->Total,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'PayrollGajiIDH', $this->PayrollGajiIDH])
            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
            ->andFilterWhere(['like', 'bln', $this->bln])
            ->andFilterWhere(['like', 'thn', $this->thn])
            ->andFilterWhere(['like', 'CustomerID', $this->CustomerID])
            ->andFilterWhere(['like', 'AreaID', $this->AreaID])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

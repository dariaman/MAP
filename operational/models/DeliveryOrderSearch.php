<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\DeliveryOrder;

/**
 * DeliveryOrderSearch represents the model behind the search form about `app\operational\models\DeliveryOrder`.
 */
class DeliveryOrderSearch extends DeliveryOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DONo', 'SODID', 'GRID', 'DODate', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Qty'], 'integer'],
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
        $query = DeliveryOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Qty' => $this->Qty,
            'DODate' => $this->DODate,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'DONo', $this->DONo])
            ->andFilterWhere(['like', 'SODID', $this->SODID])
            ->andFilterWhere(['like', 'GRID', $this->GRID])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

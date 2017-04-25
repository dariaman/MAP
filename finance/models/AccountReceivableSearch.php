<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\AccountReceivable;

/**
 * AccountReceivableSearch represents the model behind the search form about `app\finance\models\AccountReceivable`.
 */
class AccountReceivableSearch extends AccountReceivable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ARNo', 'InvoiceNo', 'RefNo', 'PaymentDate', 'UserCrt', 'DateCrt'], 'safe'],
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
        $query = AccountReceivable::find();

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
            'PaymentDate' => $this->PaymentDate,
            'DateCrt' => $this->DateCrt,
        ]);

        $query->andFilterWhere(['like', 'ARNo', $this->ARNo])
            ->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
            ->andFilterWhere(['like', 'RefNo', $this->RefNo])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}

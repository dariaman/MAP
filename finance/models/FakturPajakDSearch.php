<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\FakturPajakD;

/**
 * FakturPajakDSearch represents the model behind the search form about `app\finance\models\FakturPajakD`.
 */
class FakturPajakDSearch extends FakturPajakD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NoFakturPajak', 'KodeFaktur', 'InvoiceNo', 'InvoiceDate', 'InvoiceCancel', 'CancelDate', 'CancelReason', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['TRNo', 'IsCancel'], 'integer'],
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
        $query = FakturPajakD::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'TRNo' => $this->TRNo,
            'InvoiceDate' => $this->InvoiceDate,
            'IsCancel' => $this->IsCancel,
            'CancelDate' => $this->CancelDate,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'NoFakturPajak', $this->NoFakturPajak])
            ->andFilterWhere(['like', 'KodeFaktur', $this->KodeFaktur])
            ->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
            ->andFilterWhere(['like', 'InvoiceCancel', $this->InvoiceCancel])
            ->andFilterWhere(['like', 'CancelReason', $this->CancelReason])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\GoodsReceive;

/**
 * GoodsReceiveSearch represents the model behind the search form about `app\operational\models\GoodsReceive`.
 */
class GoodsReceiveSearch extends GoodsReceive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'ItemID', 'NoPV', 'ReferenceNo', 'SupplierName', 'NoFakturPajak', 'ReceiveDate', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Qty'], 'integer'],
            [['HargaSatuan'], 'number'],
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
        $query = GoodsReceive::find();

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
            'HargaSatuan' => $this->HargaSatuan,
            'ReceiveDate' => $this->ReceiveDate,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'GRID', $this->GRID])
            ->andFilterWhere(['like', 'ItemID', $this->ItemID])
            ->andFilterWhere(['like', 'NoPV', $this->NoPV])
            ->andFilterWhere(['like', 'ReferenceNo', $this->ReferenceNo])
            ->andFilterWhere(['like', 'SupplierName', $this->SupplierName])
            ->andFilterWhere(['like', 'NoFakturPajak', $this->NoFakturPajak])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

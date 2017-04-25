<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\StockCard;

/**
 * StockCardSearch represents the model behind the search form about `app\operational\models\StockCard`.
 */
class StockCardSearch extends StockCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StockID', 'ItemID', 'TanggalTransaksi', 'UserCrt', 'DateCrt'], 'safe'],
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
        $sql = 'select s.itemid as ItemID,s.qty as Qty,s.tanggaltransaksi as TanggalTransaksi 
        from stockcard s
        inner join(
                select itemid, max(stockid) stockid
                from stockcard
                group by itemid
        )a on a.stockid=s.stockid';
        $query = StockCard::findBySql($sql);

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
            'TanggalTransaksi' => $this->TanggalTransaksi,
            'DateCrt' => $this->DateCrt,
        ]);

        return $dataProvider;
    }
}

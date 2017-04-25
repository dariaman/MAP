<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\BPJSRegistrasi;

/**
 * BPJSRegistrasiSearch represents the model behind the search form about `app\operational\models\BPJSRegistrasi`.
 */
class BPJSRegistrasiSearch extends BPJSRegistrasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'Nama'], 'safe'],
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
        $query = new \yii\db\Query;
        $query->select('mp.ProductID, 
                        mp.Nama,
                        br.JKK,
                        br.JKM,
                        br.JHT,
                        br.JP,
                        br.BPJS')
                ->from('dbo.MasterProduct mp')
                ->leftJoin('dbo.BPJSRegistrasi br', 'mp.ProductID = br.ProductID');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'mp.ProductID' => $this->ProductID,
        ]);

        $query->andFilterWhere(['like', 'mp.ProductID', $this->ProductID])
                ->andFilterWhere(['like', 'mp.Nama', $this->Nama]);

        return $dataProvider;
    }
}

<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\FakturPajakH;

/**
 * FakturPajakHSearch represents the model behind the search form about `app\finance\models\FakturPajakH`.
 */
class FakturPajakHSearch extends FakturPajakH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EntityID', 'TahunPajak', 'TrDate', 'NoAwal', 'NoAkhir', 'StartPeriod', 'EndPeriod', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsActive'], 'integer'],
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
        $query = FakturPajakH::find();

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
            'TrDate' => $this->TrDate,
            'StartPeriod' => $this->StartPeriod,
            'EndPeriod' => $this->EndPeriod,
            'IsActive' => $this->IsActive,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'EntityID', $this->EntityID])
            ->andFilterWhere(['like', 'TahunPajak', $this->TahunPajak])
            ->andFilterWhere(['like', 'NoAwal', $this->NoAwal])
            ->andFilterWhere(['like', 'NoAkhir', $this->NoAkhir])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

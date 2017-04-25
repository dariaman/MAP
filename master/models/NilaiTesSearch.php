<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\NilaiTes;

/**
 * NilaiTesSearch represents the model behind the search form about `app\master\models\NilaiTes`.
 */
class NilaiTesSearch extends NilaiTes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CalonProductID', 'TglTes', 'IDJenisTes', 'UserCrt', 'DateCrt'], 'safe'],
            [['Nilai'], 'integer'],
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
        $query = NilaiTes::find();

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
            'TglTes' => $this->TglTes,
            'Nilai' => $this->Nilai,
            'DateCrt' => $this->DateCrt,
        ]);

        $query->andFilterWhere(['like', 'CalonProductID', $this->CalonProductID])
            ->andFilterWhere(['like', 'IDJenisTes', $this->IDJenisTes])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}

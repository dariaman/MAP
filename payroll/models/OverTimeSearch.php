<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\OverTime;

/**
 * OverTimeSearch represents the model behind the search form about `app\payroll\models\OverTime`.
 */
class OverTimeSearch extends OverTime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'tgl', 'Periode','StatusKerja'], 'safe'],
            [['SeqProduct'], 'integer'],
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
        $query = OverTime::find()->OrderBy(['SODID'=>SORT_ASC,'SeqProduct'=>SORT_ASC,'Tgl'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => ['pagesize' => 10]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'SODID' => $this->SODID,
            'SeqProduct' => $this->SeqProduct,
            'tgl' => $this->tgl,
            'StatusKerja' => $this->StatusKerja,
            'Periode' => $this->Periode,
        ]);

        return $dataProvider;
    }
}

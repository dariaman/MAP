<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PPH21Product;

/**
 * PPH21ProductSearch represents the model behind the search form about `app\payroll\models\PPH21Product`.
 */
class PPH21ProductSearch extends PPH21Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductID', 'Periode', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Gapok', 'Tunjangan', 'Potongan', 'BiayaJabatan', 'PTKP', 'PKPTahun', 'PPH21Amount'], 'number'],
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
        $query = PPH21Product::find();

        // add conditions that should always apply here

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

        // grid filtering conditions
        $query->andFilterWhere([
            'Gapok' => $this->Gapok,
            'Tunjangan' => $this->Tunjangan,
            'Potongan' => $this->Potongan,
            'BiayaJabatan' => $this->BiayaJabatan,
            'PTKP' => $this->PTKP,
            'PKPTahun' => $this->PKPTahun,
            'PPH21Amount' => $this->PPH21Amount,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'ProductID', $this->ProductID])
            ->andFilterWhere(['like', 'Periode', $this->Periode])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

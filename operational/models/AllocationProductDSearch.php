<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\AllocationProductD;

/**
 * AllocationProductDSearch represents the model behind the search form about `app\operational\models\AllocationProductD`.
 */
class AllocationProductDSearch extends AllocationProductD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AllocationProductDID', 'AllocationProductIDH', 'SODID', 'ProductID', 'AreaDetailDesc', 'LicensePlate', 'TglTugas', 'HariKerja', 'NoPKWT', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive', 'IsShift'], 'integer'],
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
        $query = AllocationProductD::find();

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
            'TglTugas' => $this->TglTugas,
            'IsActive' => $this->IsActive,
            'IsShift' => $this->IsShift,
            'DateCrt' => $this->DateCrt,
        ]);

        $query->andFilterWhere(['like', 'AllocationProductDID', $this->AllocationProductDID])
            ->andFilterWhere(['like', 'AllocationProductIDH', $this->AllocationProductIDH])
            ->andFilterWhere(['like', 'SODID', $this->SODID])
            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
            ->andFilterWhere(['like', 'AreaDetailDesc', $this->AreaDetailDesc])
            ->andFilterWhere(['like', 'LicensePlate', $this->LicensePlate])
            ->andFilterWhere(['like', 'HariKerja', $this->HariKerja])
            ->andFilterWhere(['like', 'NoPKWT', $this->NoPKWT])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}

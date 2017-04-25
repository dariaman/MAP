<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\SOD;

/**
 * SODSearch represents the model behind the search form about `app\operational\models\SOD`.
 */
class SODSearch extends SOD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['SODID', 'SOIDH', 'OfferingDID', 'PeriodFrom', 'PeriodTo', 'PeriodUpdateCoscal', 'Status', 'StatusCoscal', 'StatusCoscalDate', 'UserCrt', 'DateCrt'], 'safe'],
            [['Qty', 'IsRapelBill'], 'integer'],
            [['FixAmount', 'InstalmentDPP', 'MFee', 'MFeeOT'], 'number'],
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
        $query = SOD::find();

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
            'PeriodFrom' => $this->PeriodFrom,
            'PeriodTo' => $this->PeriodTo,
            'StatusDate' => $this->StatusDate,
            'DateCrt' => $this->DateCrt,
        ]);

        return $dataProvider;
    }
}
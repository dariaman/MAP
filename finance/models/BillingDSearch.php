<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\BillingD;

/**
 * BillingDSearch represents the model behind the search form about `app\payroll\models\BillingD`.
 */
class BillingDSearch extends BillingD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BillingNo', 'InvoiceNo', 'TipeBilling', 'SODID', 'AreaID', 'Periode', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['SeqProduct'], 'integer'],
            [['DPP', 'MgmFee', 'PPN', 'PPH23', 'Total'], 'number'],
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
    
    public function search($params)
    {
        $query = BillingD::find();

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
            'DPP' => $this->DPP,
            'MgmFee' => $this->MgmFee,
            'PPN' => $this->PPN,
            'PPH23' => $this->PPH23,
            'Total' => $this->Total,
            'Datecrt' => $this->Datecrt,
        ]);

        return $dataProvider;
    }
}

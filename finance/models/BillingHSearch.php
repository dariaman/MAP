<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\BillingH;

/**
 * BillingHSearch represents the model behind the search form about `app\payroll\models\BillingH`.
 */
class BillingHSearch extends BillingH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BillingIDH', 'InvoiceNo', 'TipeBilling', 'SODID', 'AreaID', 'Periode', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
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
        $query = new \yii\db\Query();
        
        $query->select ('mc.CustomerName as CusName,bh.InvoiceNo,bh.InvoiceDate,bh.TotalDPP,bh.TotalMFee,bh.TotalPPH23,bh.TotalPPN,bh.TotalInvoice,bh.NoFakturPajak,db.SendBy,db.SendDate,db.ReceivedBy,db.ReceivedDate,bh.CancelDate,bh.CancelReason')
                ->from('BillingH bh')
                ->leftJoin(['mc' => \app\master\models\MasterCustomer::tableName()],'mc.CustomerID = bh.CustomerID')
                ->leftJoin(['db' => \app\finance\models\DocBilling::tableName()],'db.InvoiceNo = bh.InvoiceNo')
                ;
        
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

        $query->andFilterWhere(['like', 'BillingIDH', $this->BillingIDH])
               ->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
               ->andFilterWhere(['like', 'TipeBilling', $this->TipeBilling])
               ->andFilterWhere(['like', 'SODID', $this->SODID])
               ->andFilterWhere(['like', 'AreaID', $this->AreaID])
               ->andFilterWhere(['like', 'Periode', $this->Periode])
               ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
               ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);
		
        return $dataProvider;
    }
    
    public function searchInv($params)
    {
        $query = new \yii\db\Query();
        
        $query->select ('mc.CustomerName as CusName,*')
                ->from('BillingH bh')
                ->leftJoin(['mc' => \app\master\models\MasterCustomer::tableName()],'mc.CustomerID = bh.CustomerID')
                ->where(['bh.Status' => 'N'])
                ;
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) { return $dataProvider; }

        $query->andFilterWhere(['like', 'BillingIDH', $this->BillingIDH])
               ->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
               ->andFilterWhere(['like', 'TipeBilling', $this->TipeBilling])
               ->andFilterWhere(['like', 'SODID', $this->SODID])
               ->andFilterWhere(['like', 'AreaID', $this->AreaID])
               ->andFilterWhere(['like', 'Periode', $this->Periode])
               ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
               ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);
		
        return $dataProvider;
    }
}

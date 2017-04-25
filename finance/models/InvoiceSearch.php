<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form about `app\finance\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['InvoiceNo', 'InvoiceDate', 'CustomerID', 'KodeFaktur', 'NoFakturPajak', 'Status', 'CancelDate', 'CancelReason', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['TotalDPP', 'TotalMFee', 'TotalPPN', 'TotalPPH23', 'TotalInvoice'], 'number'],
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
  /**  public function search($params)
    {
        $query = Invoice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'InvoiceDate' => $this->InvoiceDate,
            'TotalDPP' => $this->TotalDPP,
            'TotalMFee' => $this->TotalMFee,
            'TotalPPN' => $this->TotalPPN,
            'TotalPPH23' => $this->TotalPPH23,
            'TotalInvoice' => $this->TotalInvoice,
            'CancelDate' => $this->CancelDate,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
            ->andFilterWhere(['like', 'CustomerID', $this->CustomerID])
            ->andFilterWhere(['like', 'KodeFaktur', $this->KodeFaktur])
            ->andFilterWhere(['like', 'NoFakturPajak', $this->NoFakturPajak])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'CancelReason', $this->CancelReason])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    } **/
    
    public function search($params)
    {
        $query = new \yii\db\Query();
        
        $query->select ('mc.CustomerName as CusName,inv.InvoiceNo,inv.InvoiceDate,inv.TotalDPP,inv.TotalMFee,inv.TotalPPH23,inv.TotalPPN,inv.TotalInvoice,inv.NoFakturPajak,db.SendBy,db.SendDate,db.ReceivedBy,db.ReceivedDate,inv.CancelDate,inv.CancelReason')
                ->from('Invoice inv')
                ->leftJoin(['mc' => \app\master\models\MasterCustomer::tableName()],'mc.CustomerID = inv.CustomerID')
                ->leftJoin(['db' => \app\finance\models\DocBilling::tableName()],'db.InvoiceNo = inv.InvoiceNo')
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

        $query->andFilterWhere([
            'InvoiceDate' => $this->InvoiceDate,
            'TotalDPP' => $this->TotalDPP,
            'TotalMFee' => $this->TotalMFee,
            'TotalPPN' => $this->TotalPPN,
            'TotalPPH23' => $this->TotalPPH23,
            'TotalInvoice' => $this->TotalInvoice,
            'CancelDate' => $this->CancelDate,
            'DateCrt' => $this->DateCrt,
        ]);

        return $dataProvider;
    }
    
    public function searchInv($params)
    {
        $query = new \yii\db\Query();
        
        $query->select ('mc.CustomerName as CusName,*')
                ->from('Invoice inv')
                ->leftJoin(['mc' => \app\master\models\MasterCustomer::tableName()],'mc.CustomerID = inv.CustomerID')
                ->where(['inv.Status' => 'N'])
                ;
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) { return $dataProvider; }

        $query->andFilterWhere([
            'InvoiceDate' => $this->InvoiceDate,
            'TotalDPP' => $this->TotalDPP,
            'TotalMFee' => $this->TotalMFee,
            'TotalPPN' => $this->TotalPPN,
            'TotalPPH23' => $this->TotalPPH23,
            'TotalInvoice' => $this->TotalInvoice,
            'CancelDate' => $this->CancelDate,
            'DateCrt' => $this->DateCrt,
        ]);

        return $dataProvider;
    }
}

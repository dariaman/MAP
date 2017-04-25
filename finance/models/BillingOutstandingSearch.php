<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\BillingOutstanding;

/**
 * BillingOutstandingSearch represents the model behind the search form about `app\payroll\models\BillingOutstanding`.
 */
class BillingOutstandingSearch extends BillingOutstanding
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BillingNo', 'TipeBilling', 'SODID', 'SeqProduct', 'CustomerID', 'AreaID', 'Periode', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['DPP', 'MgmFee', 'PPN', 'PPH23', 'TotalInvoice'], 'number'],
            [['IsBilling'], 'integer'],
        ];
    }
    
    public function scenarios()    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = new \yii\db\Query();
        
        $query->select('bo.CustomerID, mc.CustomerName')
                ->from('BillingOutstanding bo')
                ->distinct(true)
                ->leftJoin('MasterCustomer mc','mc.CustomerID = bo.CustomerID')
                ->where(['bo.IsBilling' => 0])
                ->orderBy('mc.CustomerName');

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'bo.CustomerID' => $this->DPP,
//            'mc.CustomerName' => $this->MgmFee,
//            'PPN' => $this->PPN,
//            'PPH23' => $this->PPH23,
//            'TotalInvoice' => $this->TotalInvoice,
//            'IsBilling' => $this->IsBilling,
//            'DateCrt' => $this->DateCrt,
//        ]);

        return $dataProvider;
    }
    
}

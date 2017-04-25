<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\TransactionMaster;

/**
 * TransactionMasterSearch represents the model behind the search form about `app\operational\models\TransactionMaster`.
 */
class TransactionMasterSearch extends TransactionMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TransID', 'Transtype', 'PIC', 'NextPIC', 'Status', 'Reason', 'usercrt', 'datecrt', 'LastUpdateBy', 'LastUpdateOn', 'ApproveBy', 'ApproveDate'], 'safe'],
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
//        $ID = Yii::$app->user->identity->username;
//        
//        if($ID == 'APMK07001')
//        {
            $query = TransactionMaster::find()
                    ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                    ->from("TransactionMaster tr")
                    ->leftJoin('OfferingH oh','oh.OfferingIDH = tr.TransID')
                    ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                    ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                    ->where(['tr.Transtype' => 'OF000001']);
//        } else {
//            $query = TransactionMaster::find()
//                    ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
//                    ->from("TransactionMaster tr")
//                    ->leftJoin('OfferingH oh','oh.OfferingIDH = tr.TransID')
//                    ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
//                    ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
//                    ->where(['tr.Transtype' => 'OF000001'])
//        }
        

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
            'datecrt' => $this->datecrt,
            'LastUpdateOn' => $this->LastUpdateOn,
            'ApproveDate' => $this->ApproveDate,
        ]);

        $query->andFilterWhere(['like', 'TransID', $this->TransID])
            ->andFilterWhere(['like', 'Transtype', $this->Transtype])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'NextPIC', $this->NextPIC])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'Reason', $this->Reason])
            ->andFilterWhere(['like', 'usercrt', $this->usercrt])
            ->andFilterWhere(['like', 'LastUpdateBy', $this->LastUpdateBy])
            ->andFilterWhere(['like', 'ApproveBy', $this->ApproveBy]);

        return $dataProvider;
    }
    
    public function searchOf($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('OfferingH oh','oh.OfferingIDH = tr.TransID')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->where(['tr.Transtype' => 'OF000001']);
        
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
        return $dataProvider;
    }
    
    public function searchSo($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('SOH sh','sh.SOIDH = tr.TransID')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                    ->where(['tr.Transtype' => 'SO000001']);
        
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
        return $dataProvider;
    }
    
    public function searchSo2($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('SOD sd','sd.SODID = tr.TransID')
                ->leftJoin('SOH sh','sh.SOIDH = sd.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->where(['tr.Transtype' => 'SO000002']);
        
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
        return $dataProvider;
    }
    
    public function searchPr($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('GoLiveProduct gp','gp.GoLiveID = tr.TransID')
                ->leftJoin('SOD sd','sd.SODID = gp.SODID')
                ->leftJoin('SOH sh','sh.SOIDH = sd.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->where(['tr.Transtype' => 'ET000001']);
        
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
        return $dataProvider;
    }
    
    public function searchSl($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('SOD sd','sd.SODID = RIGHT(tr.TransID, 13)')
                ->leftJoin('SOH sh','sh.SOIDH = sd.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->where(['tr.Transtype' => 'SO000003']);
        
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
        return $dataProvider;
    }
    
    public function searchEc($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('SOH sh','sh.SOIDH = tr.TransID')
                ->leftJoin('SOD sd','sd.SOIDH = sh.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->where(['tr.Transtype' => 'SO000004']);
        
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
        return $dataProvider;
    }
    
    public function searchEcsod($params)
    {
        $ID = Yii::$app->user->identity->username;
        
        $query = TransactionMaster::find()
                ->select("tr.TransID,tr.Transtype,tr.PIC,tr.Status,tr.Reason,mc.CustomerName,mj.Description")
                ->from("TransactionMaster tr")
                ->leftJoin('SOD sd','sd.SODID = tr.TransID')
                ->leftJoin('SOH sh','sh.SOIDH = sd.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                    ->where(['tr.Transtype' => 'SO000005']);
        
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
        return $dataProvider;
    }
}

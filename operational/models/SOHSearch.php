<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\SOH;
use app\operational\models\CosCalD;

/**
 * SOHSearch represents the model behind the search form about `app\operational\models\SOH`.
 */
class SOHSearch extends SOH {

    public $SODID;
    public $CustomerID;
    public $IDJobDesc;
//    public $CustomerID;

    public function rules() {
        return [
            [['SOIDH', 'SODate', 'OfferingIDH','TipeKontrak', 'TipeBayar', 'PONo', 'POdate', 'Status', 'usercrt', 'datecrt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {

        $query = (new \yii\db\Query)
                ->select('sh.SOIDH,
		sh.SODate,
		sh.OfferingIDH,
		oh.IDJobDesc,
		mj.Description,
		oh.CustomerID,
		mc.CustomerName,
		sh.PONo,
		sh.POdate,
		sh.TipeKontrak,
		sh.TipeBayar,
		sh.Status,
                sh.SubCustomerID')
                ->from(['sh' => SOH::tableName()])
                ->leftJoin('OfferingH oh', 'oh.OfferingIDH=sh.OfferingIDH')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc=oh.IDJobDesc')
                ->leftJoin('MasterCustomer mc', 'mc.CustomerID=oh.CustomerID')
                ->orderBy(['sh.datecrt' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);       
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                
                if($params['typeSearch'] == 'oh.IDJobDesc')
                {
                    $query->andFilterWhere(['or',
                        ['like','mj.Description',$params['textsearch']]
                    ]);
                } else if($params['typeSearch'] == 'oh.CustomerID') {
                    $query->andFilterWhere(['or',
                        ['like','mc.CustomerName',$params['textsearch']]
                    ]);
                } else {
                    $query->andFilterWhere([
                        $params['typeSearch'] => $params['textsearch']
                    ]);
                }
            }
        }        
        return $dataProvider;

    }

    public function Searchofd($params) {

        $query = OfferingD::find();
//        $query->joinWith(['area','iDJobDesc']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);


        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'OfferingIDH' => $this->OfferingIDH
//               
        ]);
        return $dataProvider;
    }

    public function Searchccd($params) {

        $query = CosCalD::find();
//        $query->joinWith(['area','iDJobDesc']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);


        if (!$this->validate()) {

            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'CostcalIDH' => $this->CostcalIDH
//               
        ]);
        return $dataProvider;
    }

    public function Searchsod($params) {
        $query = SOD::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] == '1') {
                $cariData = ['SOHSearch' => [
                        'r' => $params['r'],
                        'SODID' => $params['textsearch'],
                ]];
            } else if ($params['typeSearch'] == '2') {
                $cariData = ['SOHSearch' => [
                        'r' => $params['r'],
                        'SOIDH' => $params['textsearch'],
                ]];
            } else if ($params['typeSearch'] == '3') {
                $cariData = ['SOHSearch' => [
                        'r' => $params['r'],
                        'CostcalIDH' => $params['textsearch'],
                ]];
            } else if ($params['typeSearch'] == '4') {
                $cariData = ['SOHSearch' => [
                        'r' => $params['r'],
                        'AreaID' => $params['textsearch'],
                ]];
            }
        }

        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'SODID' => $this->SODID,
            'SOIDH' => $this->SOIDH,
        ]);

        return $dataProvider;
    }

}

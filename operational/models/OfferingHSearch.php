<?php

namespace app\operational\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\OfferingH;

/**
 * OfferingHSearch represents the model behind the search form about `app\operational\models\OfferingH`.
 */
class OfferingHSearch extends OfferingH {

    public function rules() {
        return [
            [['OfferingIDH', 'CustomerID','OfferingDate', 'IDJobDesc', 'NoSurat', 'ApproveBy', 'ApproveDate', 'Status', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsActive', 'IsPrint'], 'integer'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = new \yii\db\Query;
        $query->select('oh.OfferingIDH,
                oh.OfferingDate,
                oh.NoSurat,
                oh.SOIDH,
                oh.IDJobDesc,
                mj.Description JobDesc,
                oh.CustomerID,
                mc.CustomerName,
                oh.Status,
                oh.ApproveBy,
                oh.ApproveDate,
                oh.IsActive,
                oh.IsPrint')
                ->from('OfferingH oh')
                ->leftJoin('MasterJobDesc mj', 'oh.IDJobDesc=mj.IDJobDesc')
                ->leftJoin('MasterCustomer mc', 'oh.CustomerID=mc.CustomerID')
                ->orderBy('oh.Status desc,oh.DateCrt desc');

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['OfferingHSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'oh.OfferingIDH' => $this->OfferingIDH,
            'oh.NoSurat' => $this->NoSurat,
            'oh.Status' => $this->Status,
        ]);
        
        $query->andFilterWhere(['or',
            ['like','mc.CustomerName',$this->CustomerID],
            ['like','mj.Description',$this->IDJobDesc]
        ]);
        return $dataProvider;
    }

    public function searchsooffering($params) {
        $query = new \yii\db\Query;
        $query->select('oh.OfferingIDH,
                oh.OfferingDate,
                oh.NoSurat,
                oh.IDJobDesc,
                mj.Description,
                oh.Status,
                oh.CustomerID,
                mc.CustomerName,
                oh.IsActive,
                oh.IsPrint')
                ->from('OfferingH oh')
                ->leftJoin('MasterJobDesc mj', 'oh.IDJobDesc=mj.IDJobDesc')
                ->leftJoin('MasterCustomer mc', 'oh.CustomerID=mc.CustomerID')
                ->where(['oh.Status' => 'A', 'oh.SOIDH' => null]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                $query->andFilterWhere([
                    $params['typeSearch'] => $params['textsearch']
                ]);
            }
        }
        return $dataProvider;
    }

}

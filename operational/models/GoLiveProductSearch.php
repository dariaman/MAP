<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\GoLiveProduct;
use yii\db\Query;

class GoLiveProductSearch extends GoLiveProduct {
    /**
     * @inheritdoc
     */
    public $AreaDetailDesc;
    public $Tgl;
    public $SODID;
    public $SOIDH;
    public $CustomerName;
    public $ProductID;
    public $Nama;
    public $Description;
    public $CustomerID;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['GoLiveID', 'SODID', 'SOIDH', 'SeqProduct', 'ProductID', 'PeriodFrom', 'PeriodTo'], 'required'],
            [['GoLiveID', 'SODID', 'SOIDH', 'ProductID', 'AreaDetailDesc', 'Status', 'LicensePlate', 'UserCrt', 'UserUpdate'], 'string'],
            [['SeqProduct', 'IsActive', 'IsShift'], 'integer'],
            [['PeriodFrom', 'PeriodTo', 'DateCrt', 'DateUpdate'], 'safe'],
            [['GoLiveID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return Model::scenarios();
    }
    
    public function searchLookupProductfix1($params) {
        $query = (new \yii\db\Query)
                ->select('gl.SODID , gl.SeqProduct , gl.ProductID , mp.Nama , oh.CustomerID , mc.CustomerName,mp.IDJobDesc as IDJobDesc')
                ->from(['gl' => \app\operational\models\GoLiveProduct::tableName()])
                ->Join('LEFT JOIN', 'MasterProduct mp', 'gl.ProductID = mp.ProductID')
                ->Join('LEFT JOIN', 'SOD sod', 'gl.SODID = sod.SODID')
                ->Join('LEFT JOIN', 'SOH soh', 'sod.SOIDH = soh.SOIDH')
                ->Join('LEFT JOIN', 'OfferingH oh', 'soh.SOIDH = oh.SOIDH')
                ->Join('LEFT JOIN', 'MasterCustomer mc', 'oh.CustomerID = mc.CustomerID')
                ->where(['soh.Status' => 'A', 'sod.Status' => 'A', 'sod.StatusGoLive' => 'A'])
                ->andWhere('gl.ProductID is not null')
                ->orderBy(['gl.SODID' => SORT_ASC]);
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
    
    public function searchLookupProductfix($params) {
        $query = (new \yii\db\Query)
                ->select('gl.SODID , gl.SeqProduct , gl.ProductID , mp.Nama , oh.CustomerID , mc.CustomerName')
                ->from('GoLiveProduct gl')
                ->Join('LEFT JOIN', 'MasterProduct mp', 'gl.ProductID = mp.ProductID')
                ->Join('LEFT JOIN', 'SOD sod', 'gl.SODID = sod.SODID')
                ->Join('LEFT JOIN', 'SOH soh', 'sod.SOIDH = soh.SOIDH')
                ->Join('LEFT JOIN', 'OfferingH oh', 'soh.SOIDH = oh.SOIDH')
                ->Join('LEFT JOIN', 'MasterCustomer mc', 'oh.CustomerID = mc.CustomerID')
                ->where(['soh.Status' => 'A', 'sod.Status' => 'A', 'sod.StatusGoLive' => 'A']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['BackupProductSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);


        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ProductIDGS' => $this->ProductIDGS,
            'CustomerID' => $this->CustomerID,
            'SODID' => $this->SODID
        ]);

        return $dataProvider;
    }

}

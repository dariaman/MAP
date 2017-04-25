<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterCustomer;

class MasterCustomerSearch extends MasterCustomer {

    public function rules() {
        return [
            [['CustomerID', 'NPWP', 'CustomerName', 'Address', 'City', 'ContactName', 'ContactEmail', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IDAbsenType', 'IsActive', 'Zip', 'Phone', 'Fax', 'ContactPhone'], 'integer'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = MasterCustomer::find()
                ->select(['mc.CustomerID', 'mc.CustomerName', 'mc.IsCompany', 'mc.Inisial', 'mc.Address', 'mc.City', 'mc.Zip', 'mc.Phone', 'mc.Fax', 'mc.ContactName',
                    'mc.ContactPhone', 'mc.ContactEmail', 'ma.StartAbsen', 'ma.EndAbsen', 'mc.IDFormulaOT', 'mc.NPWP', 'mc.IsActive'])
                ->from('MasterCustomer mc')
                ->leftjoin('MasterAbsenType ma', 'mc.IDAbsentype=ma.ID')
                ->orderBy(['mc.CustomerName' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                if($params['typeSearch'] == 'mc.CustomerName')
                {
                    $query->andFilterWhere(['like',$params['typeSearch'] , $params['textsearch']]);
                } else 
                {
                    $query->andFilterWhere([$params['typeSearch'] => $params['textsearch']]);
                }
            }
        }
        return $dataProvider;
    }

    public function searchLookupCustomer($params) {
        $query = MasterCustomer::find()
                ->select(['CustomerID', 'CustomerName', 'City', 'ContactName', 'NPWP'])
                ->from('MasterCustomer mc')
                ->orderBy(['CustomerName' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['MasterCustomerSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([            
            'CustomerID' => $this->CustomerID,
            'NPWP' => $this->NPWP,
        ]);
        
        $query->andFilterWhere(['or',
            ['like','CustomerName',$this->CustomerName]
        ]);
        return $dataProvider;
    }

}

<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PaymentSalary;
use app\payroll\models\PayrollGajiH;

/**
 * PaymentSalarySearch represents the model behind the search form about `app\payroll\models\PaymentSalary`.
 */
class PaymentSalarySearch extends PaymentSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['APNO', 'APDate', 'PayrollGajiIDH', 'IDBankMAP', 'BankGroupProduct', 'RekBankProduct', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['AmountPayment', 'BiayaAdmin'], 'number'],
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
        $bulan = ($params['bulan']) ?? date('m') ;
        $tahun = ($params['tahun']) ?? date('Y') ;
        
        $query = PayrollGajiH::find()
                ->select(['ph.PayroolIDH','ph.ProductID', 'mp.Nama', 'mj.Description AS NamaJob', 'ph.FixAmount', 'ph.PotonganAmount', 'ph.PPH21', 'ph.Total'])
                ->from('PayrollGajiH ph')
                ->leftJoin('MasterProduct mp', 'mp.ProductID = ph.ProductID')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->where(['>=','CONVERT(VARCHAR(6),ph.Periode,112)', $tahun.$bulan])
                ->andWhere(['<=','CONVERT(VARCHAR(6),ph.Periode,112)', $tahun.$bulan]);
        
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => false,
        ]);
        
        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                
                if($params['typeSearch'] == 'mp.Nama')
                {
                    $query->andFilterWhere(['or',
                        ['like','mp.Nama',$params['textsearch']]
                    ]);
                } else if($params['typeSearch'] == 'mj.Description')
                {
                    $query->andFilterWhere(['or',
                        ['like','mj.Description',$params['textsearch']]
                    ]); 
                }
                else {
                    $query->andFilterWhere([
                        $params['typeSearch'] => $params['textsearch']
                    ]);
                }
        }
       }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ProductID' => $this->ProductID,
        ]);

        return $dataProvider;
    }
    
    public function searchGaji($params)
    {
        $bulan = isset($params['bulan']) ? $params['bulan'] : date('m') ;
        $tahun = isset($params['tahun']) ? $params['tahun'] : date('Y') ;
        
        $query = PayrollGajiH::find()
                ->select(['ph.ProductID', 'mp.Nama', 'mj.Description AS NamaJob', 'ph.FixAmount', 'ph.PotonganAmount', 'ph.PPH21', 'ph.Total'])
                ->from('PayrollGajiH ph')
                ->leftJoin('MasterProduct mp', 'mp.ProductID = ph.ProductID')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->where(['>=','CONVERT(VARCHAR(6),ph.Periode,112)', $tahun.$bulan])
                ->andWhere(['<=','CONVERT(VARCHAR(6),ph.Periode,112)', $tahun.$bulan])
                ->andWhere(['<','ph.PPH21', 0])
                ;
        
       $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            if (isset($params['typeSearch']) && isset($params['textsearch'])) {
                if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                    $query->andFilterWhere([$params['typeSearch'] => $params['textsearch']]);
                }
            }
            return $dataProvider;
        }
}

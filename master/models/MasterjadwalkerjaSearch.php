<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterJadwalKerja;

/**
 * MasterJadwalKerjaSearch represents the model behind the search form about `app\master\models\MasterJadwalKerja`.
 */
class MasterJadwalKerjaSearch extends MasterJadwalKerja
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CustomerID','ProductID', 'Tgl', 'Status', 'JadwalMasuk', 'JadwalKeluar', 'UserCrt', 'DateCrt'], 'safe'],
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
        $query = MasterJadwalKerja::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'DateCrt' => $this->DateCrt,
        ]);


        return $dataProvider;
    }
    
    public function searchJadwalH($params)
    {
        $query = \app\eprocess\models\JadwalAbsensiStatusH::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $cariData = $params;
        
       
        if(isset($params['typeSearch']) && isset($params['textsearch']) && isset($params['tahun']) && isset($params['bulan']))
        {
//             print_r($params);
//        die();
            if($params['typeSearch'] == 1)
            {
                $cariData = ['MasterJadwalKerjaSearch'=> [
                        'r'  => $params['r'],
                        'CustomerID'  => $params['textsearch']

                ]];
            } else if($params['typeSearch'] == 2)
            {
                $cariData = ['MasterJadwalKerjaSearch'=> [
                        'r'  => $params['r'],
                        'CustomerID'  => $params['textsearch']
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
            'CustomerID' => $this->CustomerID
        ]);


        return $dataProvider;
    }
    
    public function searchProd($params)
    {
        $query = \app\eprocess\models\JadwalAbsensiStatusD::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $cariData = $params;
        
        
        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            
            if($params['typeSearch'] == 1)
            {
                $cariData = ['MasterJadwalKerjaSearch'=> [
                        'r'  => $params['r'],
                        'ProductID'  => $params['textsearch']
                ]];
            } else if($params['typeSearch'] == 2)
            {
                $cariData = ['MasterJadwalKerjaSearch'=> [
                        'r'  => $params['r'],
                        'product.Nama'  => $params['textsearch']
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
            'ProductID' => $this->CustomerID,
        ]);


        return $dataProvider;
    }
    
}

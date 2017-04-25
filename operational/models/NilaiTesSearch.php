<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\NilaiTes;
use app\master\models\Mastercalonproduct;

/**
 * NilaiTesSearch represents the model behind the search form about `app\operational\models\NilaiTes`.
 */
class NilaiTesSearch extends NilaiTes
{
    /**
     * @inheritdoc
     */
    public $Nama;
    public $SIM;
    public $KTP;
    public $IDJobDesc;
    public $calonproductID;
    public function rules()
    {
        
        return [
            [['CalonProductID','calonproductID','TglTes', 'IDJenisTes', 'Nilai', 'UserCrt', 'DateCrt','Nama','SIM','KTP','IDJobDesc'], 'safe'],
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
        $query = NilaiTes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
          $dataProvider->pagination->pageSize=4;
//         

        $cariData = $params;
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'CalonProductID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
//               print_r($params);
//            die();
                $query->joinWith(['calonProduct']);
                         $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'Nama'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '3')
            {
                        $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'IDJenisTes'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '4')
            {
                        $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'Nilai'  => $params['textsearch'],
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
            'CalonProductID' => $this->CalonProductID,
            'MasterCalonProduct.Nama' => $this->Nama,
             'IDJenisTes' => $this->IDJenisTes,
            'Nilai' => $this->Nilai,
        ]);

//        $query->andFilterWhere(['like', 'CalonProductID', $this->CalonProductID])
//            ->andFilterWhere(['like', 'IDJenisTes', $this->IDJenisTes])
//            ->andFilterWhere(['like', 'Nilai', $this->Nilai])
//            ->andFilterWhere(['like', 'usercrt', $this->usercrt]);

        return $dataProvider;
    }
    
      public function SearchcalonProduct($params)
    {
        $query = mastercalonproduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       

        $cariData = $params;
        
      if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            
            if($params['typeSearch'] == '1')
            {
             
                $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'calonproductID'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '2')
            {
                $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'Nama'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '3')
            {
                $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'IDJobDesc'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '4')
            {
                $cariData = ['NilaiTesSearch'=> [
                        'r'  => $params['r'],
                        'KTP'  => $params['textsearch'],
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
            'calonproductID' => $this->calonproductID,
            'Nama' => $this->Nama,
            'IDJobDesc' => $this->IDJobDesc,
            'KTP' => $this->KTP,
            'SIM' => $this->SIM,
           
        ]);

//        $query->andFilterWhere(['like', 'CalonProductID', $this->CalonProductID])
//            ->andFilterWhere(['like', 'IDJenisTes', $this->IDJenisTes])
//            ->andFilterWhere(['like', 'Nilai', $this->Nilai])
//            ->andFilterWhere(['like', 'usercrt', $this->usercrt]);

        return $dataProvider;
    }
}

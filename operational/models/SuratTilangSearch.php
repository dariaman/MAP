<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\SuratTilang;


/**
 * SuratTilangSearch represents the model behind the search form about `app\operational\models\SuratTilang`.
 */
class SuratTilangSearch extends SuratTilang
{
    /**
     * @inheritdoc
     */
    public $ProductID;
    public $NIK;
    public $IDJobDesc;
    public $Nama;
    
    public function rules()
    {
        return [
            [['IDSuratTilang','NIK','ProductID','Nama','IDJobDesc', 'Description', 'TglTilang', 'UserCrt', 'DateCrt'], 'safe'],
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
        $query = SuratTilang::find()
                ->select('*,mp.Nama as mpnama')
                ->from('SuratTilang st')
                ->leftJoin('MasterProduct mp','mp.ProductID = st.ProductID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'IDSuratTilang'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
               print_r($params);
            die();
                         $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'ProductID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '3')
            {
                        $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'Description'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '4')
            {
                        $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'TglTilang'  => $params['textsearch'],
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
            'IDSuratTilang' => $this->IDSuratTilang,
            'ProductID' => $this->ProductID,
            'Description' => $this->Description,
            'TglTilang' => $this->TglTilang,
        ]);

//        $query->andFilterWhere(['like', 'ID', $this->ID])
//            ->andFilterWhere(['like', 'IDpegawai', $this->IDpegawai])
//            ->andFilterWhere(['like', 'Description', $this->Description])
//            ->andFilterWhere(['like', 'usercrt', $this->usercrt]);

        return $dataProvider;
    }
      public function Searchpgw($params)
    {
         
        $query = \app\master\models\MasterProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => false,
        ]);
      
         $cariData = $params;
//           print_r($params);
//           die();
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                    print_r($params);
                    die();
                        $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'ProductID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
//               print_r($params);
//            die();
                         $cariData = ['SuratTilangSearch'=> [
                        'r'  => $params['r'],
                        'NIK'  => $params['textsearch'],
                    ]];
            }
         
        
        
        }
//        print_r($cariData);
//        die();
        
        
        
        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ProductID' => $this->ProductID,
            'NIK' => $this->NIK,
          
        ]);

//        $query->andFilterWhere(['like', 'ID', $this->ID])
//            ->andFilterWhere(['like', 'OFFID', $this->OFFID])
//            ->andFilterWhere(['like', 'NO_PO', $this->NO_PO])
//            ->andFilterWhere(['like', 'Customer_ID', $this->Customer_ID])
//            ->andFilterWhere(['like', 'usertcrt', $this->usertcrt]);

        return $dataProvider;
    
    }
}


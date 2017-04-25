<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\SuratPeringatan;
use app\master\models\MasterProduct;

/**
 * SuratPeringatanSearch represents the model behind the search form about `app\payroll\models\SuratPeringatan`.
 */
class SuratPeringatanSearch extends SuratPeringatan
{
    /**
     * @inheritdoc
     */
    public $ProductID;
    public $Nama;
    public function rules()
    {
        return [
            [['SpNo','Nama', 'SpDate', 'ProductID', 'Remark', 'ApproveBy', 'ApproveDate', 'UserCrt', 'DateCrt'], 'safe'],
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
        $query = SuratPeringatan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
           'pagination'=> ['defaultPageSize' => 5]
        ]);

       $cariData = $params;
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['SuratPeringatanSearch'=> [
                        'r'  => $params['r'],
                        'SpNo'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
        
                         $cariData = ['SuratPeringatanSearch'=> [
                        'r'  => $params['r'],
                        'SpDate'  => $params['textsearch'],
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
            'SpNo' => $this->SpNo,
            'SpDate' => $this->SpDate,
           
        ]);

//        $query->andFilterWhere(['like', 'SpNo', $this->SpNo])
//            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
//            ->andFilterWhere(['like', 'Remark', $this->Remark])
//            ->andFilterWhere(['like', 'ApproveBy', $this->ApproveBy])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
       public function Searchproduct($params)
    {
        $query = MasterProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

            $cariData = $params;
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['SuratPeringatanSearch'=> [
                        'r'  => $params['r'],
                        'ProductID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
//               print_r($params);
//            die();
          
                         $cariData = ['SuratPeringatanSearch'=> [
                        'r'  => $params['r'],
                        'Nama'  => $params['textsearch'],
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
         
            'ProductID' => $this->ProductID,
            'Nama' => $this->Nama,
        ]);

//        $query->andFilterWhere(['like', 'SpNo', $this->SpNo])
//            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
//            ->andFilterWhere(['like', 'Remark', $this->Remark])
//            ->andFilterWhere(['like', 'ApproveBy', $this->ApproveBy])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}

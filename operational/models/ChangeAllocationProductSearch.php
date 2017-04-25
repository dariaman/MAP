<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\ChangeAllocationProduct;
use app\operational\models\AllocationProductD;

/**
 * ChangeAllocationProductSearch represents the model behind the search form about `app\operational\models\ChangeAllocationProduct`.
 */
class ChangeAllocationProductSearch extends ChangeAllocationProduct
{
    /**
     * @inheritdoc
     */
    public $AllocationProductDID;
    public $SODID;
    public function rules()
    {
        return [
            [['ChangeAllocationProductID','AllocationProductDID','SODID', 'AllocationProductID', 'SOID', 'RefID', 'JobDescID', 'AreaID', 'ProductID', 'ToProductID', 'ProductFreelance', 'Tipe', 'Remark', 'FromDate', 'ToDate', 'UserCrt', 'DateCrt'], 'safe'],
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
        $query = ChangeAllocationProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
             'pagination'=> ['defaultPageSize' => 5]            
        ]);

          $cariData = $params;
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['ChangeAllocationProductSearch'=> [
                        'r'  => $params['r'],
                        'ChangeAllocationProductID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
//               print_r($params);
//            die();
          
                         $cariData = ['ChangeAllocationProductSearch'=> [
                        'r'  => $params['r'],
                        'AllocationProductID'  => $params['textsearch'],
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
            'ChangeAllocationProductID' => $this->ChangeAllocationProductID,
            'AllocationProductID' => $this->AllocationProductID,
       
        ]);

//        $query->andFilterWhere(['like', 'ChangeAllocationProductID', $this->ChangeAllocationProductID])
//            ->andFilterWhere(['like', 'AllocationProductID', $this->AllocationProductID])
//            ->andFilterWhere(['like', 'SOID', $this->SOID])
//            ->andFilterWhere(['like', 'RefID', $this->RefID])
//            ->andFilterWhere(['like', 'JobDescID', $this->JobDescID])
//            ->andFilterWhere(['like', 'AreaID', $this->AreaID])
//            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
//            ->andFilterWhere(['like', 'ToProductID', $this->ToProductID])
//            ->andFilterWhere(['like', 'ProductFreelance', $this->ProductFreelance])
//            ->andFilterWhere(['like', 'Tipe', $this->Tipe])
//            ->andFilterWhere(['like', 'Remark', $this->Remark])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
    
     public function Searchallocation($params)
    {
        $query = AllocationProductD::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

      $cariData = $params;
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
               if($params['typeSearch'] == '1')
            {
                        $cariData = ['ChangeAllocationProductSearch'=> [
                        'r'  => $params['r'],
                        'AllocationProductDID'  => $params['textsearch'],
                    ]];
            }
            else if($params['typeSearch'] == '2')
            {
//               print_r($params);
//            die();
          
                         $cariData = ['ChangeAllocationProductSearch'=> [
                        'r'  => $params['r'],
                        'SODID'  => $params['textsearch'],
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
            'AllocationProductDID'=> $this->AllocationProductDID,
            'SODID' => $this->SODID,
           
        ]);

//        $query->andFilterWhere(['like', 'ChangeAllocationProductID', $this->ChangeAllocationProductID])
//            ->andFilterWhere(['like', 'AllocationProductID', $this->AllocationProductID])
//            ->andFilterWhere(['like', 'SOID', $this->SOID])
//            ->andFilterWhere(['like', 'RefID', $this->RefID])
//            ->andFilterWhere(['like', 'JobDescID', $this->JobDescID])
//            ->andFilterWhere(['like', 'AreaID', $this->AreaID])
//            ->andFilterWhere(['like', 'ProductID', $this->ProductID])
//            ->andFilterWhere(['like', 'ToProductID', $this->ToProductID])
//            ->andFilterWhere(['like', 'ProductFreelance', $this->ProductFreelance])
//            ->andFilterWhere(['like', 'Tipe', $this->Tipe])
//            ->andFilterWhere(['like', 'Remark', $this->Remark])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
    
      
}

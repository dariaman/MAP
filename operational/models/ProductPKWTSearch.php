<?php

namespace app\operational\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\ProductPKWT;
use app\master\models\MasterProduct;

/**
 * ProductPKWTSearch represents the model behind the search form about `app\operational\models\ProductPKWT`.
 */
class ProductPKWTSearch extends ProductPKWT
{
    /**
     * @inheritdoc
     */
    
    public $Nama;
    public function rules()
    {
        return [
            [['ProductID', 'PeriodFrom', 'PeriodTo', 'Status', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['GajiPokok'], 'number'],
            [['IsActive'], 'integer'],
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

    public function search($params){
         $query = (new \yii\db\Query)
                ->select('pw.ProductID,mp.Nama,pw.PeriodFrom,pw.PeriodTo,pw.GajiPokok,pw.Status')
                ->from(['pw' => ProductPKWT::tableName()])
                ->leftJoin('MasterProduct mp', 'mp.ProductID = pw.ProductID');
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
          $cariData = $params;

       if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                
                if($params['typeSearch'] == 'ProductID'){
                    $this->ProductID = $params['textsearch'];
                } else if($params['typeSearch'] == 'Nama'){
                    $this->Nama = $params['textsearch'];
                }
//            $cariData = ['ProductPKWTSearch'=> [
//                'r'  => $params['r'],
//                $params['typeSearch'] => $params['textsearch'],
//            ]];
        }
       }
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['pw.ProductID' => $this->ProductID])
                ->andFilterWhere(['or',['like','mp.Nama',$this->Nama]]);
        
        return $dataProvider;
    }
}


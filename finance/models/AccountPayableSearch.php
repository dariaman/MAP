<?php

namespace app\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\finance\models\AccountPayable;

/**
 * AccountPayableSearch represents the model behind the search form about `app\finance\models\AccountPayable`.
 */
class AccountPayableSearch extends AccountPayable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['APNo', 'APDate', 'TotalAmount', 'PaidNo', 'PaidDate', 'PaidRemark', 'UserCrt', 'DateCrt'], 'safe'],
            [['PPN'], 'number'],
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
    
//      public function Searchpayment($params)
//    {
//        $query = \app\finance\models\PaymentRequestSalary::find();
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        $query->andFilterWhere([
////            'APDate' => $this->APDate,
////            'PPN' => $this->PPN,
////            'PaidDate' => $this->PaidDate,
////            'DateCrt' => $this->DateCrt,
//        ]);
//
////        $query->andFilterWhere(['like', 'APNo', $this->APNo])
////            ->andFilterWhere(['like', 'TotalAmount', $this->TotalAmount])
////            ->andFilterWhere(['like', 'PaidNo', $this->PaidNo])
////            ->andFilterWhere(['like', 'PaidRemark', $this->PaidRemark])
////            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);
//
//        return $dataProvider;
//    }
    public function search($params)
    {
        $query = AccountPayable::find();

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> ['defaultPageSize' => 5]
        ]);
           $cariData = $params;

        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            if($params['typeSearch'] == '1')
            {
                $cariData = ['AccountPayableSearch'=> [
                        'r'  => $params['r'],
                        'APNo'  => $params['textsearch'],
                    ]];
            }else if($params['typeSearch'] == '2')
            {
                $cariData = ['AccountPayableSearch'=> [
                        'r'  => $params['r'],
                        'PaidNo'  => $params['textsearch'],
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
            'APNo' => $this->APNo,
            'PaidNo' => $this->PaidNo,
          
        ]);

//        $query->andFilterWhere(['like', 'APNo', $this->APNo])
//            ->andFilterWhere(['like', 'TotalAmount', $this->TotalAmount])
//            ->andFilterWhere(['like', 'PaidNo', $this->PaidNo])
//            ->andFilterWhere(['like', 'PaidRemark', $this->PaidRemark])
//            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt]);

        return $dataProvider;
    }
}

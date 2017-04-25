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
        //$query = PaymentSalary::find();
        $query = PayrollGajiH::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'APDate' => $this->APDate,
            'AmountPayment' => $this->AmountPayment,
            'BiayaAdmin' => $this->BiayaAdmin,
            'DateCrt' => $this->DateCrt,
            'DateUpdate' => $this->DateUpdate,
        ]);

        $query->andFilterWhere(['like', 'APNO', $this->APNO])
            ->andFilterWhere(['like', 'PayrollGajiIDH', $this->PayrollGajiIDH])
            ->andFilterWhere(['like', 'IDBankMAP', $this->IDBankMAP])
            ->andFilterWhere(['like', 'BankGroupProduct', $this->BankGroupProduct])
            ->andFilterWhere(['like', 'RekBankProduct', $this->RekBankProduct])
            ->andFilterWhere(['like', 'UserCrt', $this->UserCrt])
            ->andFilterWhere(['like', 'UserUpdate', $this->UserUpdate]);

        return $dataProvider;
    }
}

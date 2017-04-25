<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterBankGroup;

/**
 * MasterBankGroupSearch represents the model behind the search form about `app\master\models\MasterBankgroup`.
 */
class MasterBankGroupSearch extends MasterBankGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BankGroupID', 'BankGroupName', 'UserCrt', 'DateCrt'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MasterBankGroup::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
          $cariData = $params;

       if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            $cariData = ['MasterBankGroupSearch'=> [
                'r'  => $params['r'],
                $params['typeSearch'] => $params['textsearch'],
            ]];
        }
        
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
             'BankGroupID' => $this->BankGroupID,
             'BankGroupName'=>$this->BankGroupName, 
        ]);
        
        return $dataProvider;
    }
}

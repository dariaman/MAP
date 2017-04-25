<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterBank;

/**
 * MasterBankSearch represents the model behind the search form about `app\master\models\MasterBank`.
 */
class MasterBankSearch extends MasterBank
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BankID', 'BankName', 'BankGroupID', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsActive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = MasterBank::find()->select('mb.BankID,mb.BankName,mbg.BankGroupName,mb.IsActive') 
                                ->from('MasterBank mb')
                                ->leftJoin('MasterBankGroup mbg','mb.BankGroupID=mbg.BankGroupID');
                                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $cariData = $params;

        if(isset($params['typeSearch']) && isset($params['textsearch']))        {
            $cariData = ['MasterBankSearch'=> [
                'r'  => $params['r'],
                $params['typeSearch'] => $params['textsearch'],
            ]];
        }
    
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
             'mb.BankID' => $this->BankID,
             'mb.BankName'=>$this->BankName, 
        ]);

        return $dataProvider;
    }
}

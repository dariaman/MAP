<?php

namespace app\operational\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\operational\models\CosCalD;

/**
 * CosCalDSearch represents the model behind the search form about `app\operational\models\CosCalD`.
 */
class CosCalDSearch extends CosCalD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CostcalDID', 'CostcalIDH', 'BiayaID', 'Remark', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Amount'], 'number'],
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
        $sql = new \yii\db\Query;
        $sql->select('cd.CostcalDID,'
                . ' cd.TipeBiaya,'
                . 'cd.BiayaID,'
                . 'mb.Description,'
                . 'cd.Amount,'
                . 'cd.Remark ')
            ->from('CosCalD cd ')
            ->leftJoin('MasterBiaya mb ','mb.BiayaID=cd.BiayaID')
            ->where('cd.CostcalIDH=');

        $dataProvider = new ActiveDataProvider([
            'query' => $sql
        ]);
        
//        $query = CosCalD::find();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $sql->andFilterWhere([
//            'cd.Amount' => $this->Amount,
//            'DateCrt' => $this->DateCrt,
//        ]);
        
        return $dataProvider;
    }
}

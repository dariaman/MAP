<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\HariLibur;

/**
 * HariLiburSearch represents the model behind the search form about `app\payroll\models\HariLibur`.
 */
class HariLiburSearch extends HariLibur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tgl', 'Ket', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
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
        $query = HariLibur::find();

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $cariData = $params;

        if(isset($params['typeSearch']) && isset($params['textsearch'])){
            if($params['typeSearch'] == '1'){
                $cariData = ['HariLiburSearch'=> [
                    'r'  => $params['r'],
                    'Tgl'  => $params['textsearch'],
                ]];
            }else if($params['typeSearch'] == '2') {
                $cariData = ['HariLiburSearch'=> [
                    'r'  => $params['r'],
                    'Ket'  => $params['textsearch'],
                ]];
            }
        }
        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Tgl' => $this->Tgl,
            'Ket' => $this->Ket,
        ]);

        return $dataProvider;
    }
}

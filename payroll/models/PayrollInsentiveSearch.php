<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PayrollInsentive;
use app\master\models\MasterProduct;
use app\operational\models\GoLiveProductHistory;

/**
 * PayrollInsentiveSearch represents the model behind the search form about `app\payroll\models\PayrollInsentive`.
 */
class PayrollInsentiveSearch extends PayrollInsentive {

    public function rules() {
        return [
            [['ProductID', 'ItemID', 'tgl', 'PeriodePayroll', 'Remark', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Amount'], 'number'],
            [['IsOT', 'IsActive', 'IsSystem'], 'integer'],
        ]; 
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function Searchpro($params) {
        $query = (new \yii\db\Query)
                ->select([ 'gp.ProductID','mp.Nama','mj.Description as JobDesk'])
                ->from(['gp' => GoLiveProductHistory::tableName()])
                ->Join('INNER JOIN', 'MasterProduct mp', 'mp.ProductID = gp.ProductID')
                ->Join('INNER JOIN', 'MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->where(['mp.IsActive' => '1'])
                ->orderBy(['mp.Nama' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                $query->andFilterWhere([
                    $params['typeSearch'] => $params['textsearch']
                ]);
            }
        }
        return $dataProvider;
    }

    public function Search($params) {
        $query = (new \yii\db\Query)
                ->select(['pt.ProductID','pt.ItemID','pt.tgl','pt.Amount','pt.PeriodePayroll','mt.Description','mp.Nama','pt.Remark','pt.IsActive'])
                ->from(['pt' => PayrollInsentive::tableName()])
                ->Join('INNER JOIN', 'MasterTunjangan mt', 'pt.ItemID=mt.IDTunjangan')
                ->Join('INNER JOIN', 'MasterProduct mp', 'mp.ProductID = pt.ProductID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['PayrollInsentiveSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }


        $this->load($cariData);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ProductID' => $this->ProductID,
        ]);


        return $dataProvider;
    }

}

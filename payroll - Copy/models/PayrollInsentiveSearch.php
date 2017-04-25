<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PayrollInsentive;
use app\master\models\MasterProduct;

/**
 * PayrollInsentiveSearch represents the model behind the search form about `app\payroll\models\PayrollInsentive`.
 */
class PayrollInsentiveSearch extends PayrollInsentive {

    /**
     * @inheritdoc
     */
    public $NIK;
    public $Nama;
    public $IDJobDesc;

    public function rules() {
        return [
            [['IDKey', 'ProductID', 'ItemID', 'Amount', 'PeriodeBayar'], 'required'],
            [['IDKey', 'ProductID', 'ItemID', 'PeriodeDueDate', 'PeriodeBayar', 'Remark', 'UserCrt', 'UserUpdate'], 'string'],
            [['Amount'], 'number'],
            [['IsOT', 'IsPayroll', 'IsActive'], 'integer'],
            [['tgl', 'DateCrt', 'DateUpdate'], 'safe']
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
                ->select(['mp.ProductID', 'mp.IDCalonProduct', 'mp.AreaID', 'mp.Nama', 'mj.Description as JobDesk', 'mp.IDJobDesc', 'mp.Gender', 'mp.KTP', 'mp.KTPExpiredDate', 'mp.SIM', 'mp.SIMExpiredDate', 'mp.IDStatusNikah', 'mp.Address', 'mp.City', 'mp.Zip', 'mp.Phone', 'mp.Mobile1', 'mp.Mobile2', 'mp.BankID', 'mp.BankAccNumber', 'mp.NPWP', 'mp.IsActive', 'mp.IsBlacklist', 'mp.Status', 'mp.Class'])
                ->from(['mp' => MasterProduct::tableName()])
                ->Join('LEFT JOIN', 'MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->where(['mp.IsActive' => '1'])
                ->orderBy(['mp.Nama' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
        $query = PayrollInsentive::find()->select('*')
                ->from('PayrollInsentive pi')
                ->join('Join', 'MasterTunjangan mt', 'pi.ItemID=mt.IDTunjangan');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'mt.Description' => $this->IDTunjangan,
        ]);


        return $dataProvider;
    }

}

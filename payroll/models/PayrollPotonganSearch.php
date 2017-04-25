<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\payroll\models\PayrollPotongan;

/**
 * PayrollPotonganSearch represents the model behind the search form about `app\payroll\models\PayrollPotongan`.
 */
class PayrollPotonganSearch extends PayrollPotongan
{
    /**
     * @inheritdoc
     */
    public $NIK;
    public $Nama;
    public function rules()
    {
        return [
            [['ProductID', 'ItemID', 'tgl', 'PeriodePayroll', 'Remark', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['Amount'], 'number'],
            [['IsOT', 'IsReguler', 'IsActive', 'IsSystem'], 'integer'],
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
     public function Searchpro($params)
    {
       $query = \app\master\models\MasterProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;
        
          if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            $cariData = ['PayrollPotonganSearch'=> [
                'r'  => $params['r'],
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
            'Nama' => $this->Nama,
            
        ]);
          return $dataProvider;
    }
    public function SearchPotongan($params) {
        $query = (new \yii\db\Query)
                ->select(['mp.ProductID', 'mp.Nama', 'mj.Description as JobDesk'])
                ->from('MasterProduct mp')
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
    
    public function search($params){
        $query = (new \yii\db\Query)
                ->select(['pt.ProductID','pt.ItemID','pt.tgl','pt.Amount','pt.PeriodePayroll','mt.Description','mp.Nama','pt.IsReguler','pt.Remark','pt.IsActive'])
                ->from(['pt' => PayrollPotongan::tableName()])
                ->Join('INNER JOIN', 'MasterPotongan mt', 'pt.ItemID=mt.IDPotongan')
                ->Join('INNER JOIN', 'MasterProduct mp', 'mp.ProductID = pt.ProductID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])){
            $cariData = ['PayrollPotonganSearch'=> [
                'r'  => $params['r'],
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
            'mp.Description' => $this->ItemID,
            
        ]);
        
        return $dataProvider;
    }
}

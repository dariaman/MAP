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
            [['IDKey', 'ProductID', 'ItemID', 'Amount'], 'required'],
            [['IDKey', 'ProductID', 'ItemID', 'PeriodeDueDate', 'PeriodeBayar', 'Remark', 'UserCrt','UserUpdate'], 'string'],
            [['Amount'], 'number'],
            [['IsOT', 'IsReguler', 'IsPayroll', 'IsActive'], 'integer'],
            [['tgl', 'DateCrt','DateUpdate'], 'safe']
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
    
    public function search($params)
    {
        $query = PayrollPotongan::find()->select('*')
                                        ->from('PayrollPotongan pp')
                                        ->join('Join','MasterPotongan mp','pp.ItemID = mp.IDPotongan');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'mp.Description' => $this->ItemID,
            
        ]);
        
        return $dataProvider;
    }
}

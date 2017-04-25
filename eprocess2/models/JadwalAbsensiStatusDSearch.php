<?php

namespace app\eprocess\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\eprocess\models\JadwalAbsensiStatusD;
//use app\operational\models\SOH;
/**
 * JadwalAbsensiStatusDSearch represents the model behind the search form about `app\eprocess\models\JadwalAbsensiStatusD`.
 */
class JadwalAbsensiStatusDSearch extends JadwalAbsensiStatusD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDJadwalAbsensiStatusH', 'ProductID', 'SODID', 'CloseJadwalDate', 'CloseAbsenDate', 'CloseOTDate', 'UserCrt', 'DateCrt'], 'safe'],
            [['IsCloseJadwal', 'IsCloseAbsen', 'IsCloseOT', 'IsActive'], 'integer'],
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
        $query = JadwalAbsensiStatusD::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'IsCloseJadwal' => $this->IsCloseJadwal,
            'CloseJadwalDate' => $this->CloseJadwalDate,
            'IsCloseAbsen' => $this->IsCloseAbsen,
            'CloseAbsenDate' => $this->CloseAbsenDate,
            'IsCloseOT' => $this->IsCloseOT,
            'CloseOTDate' => $this->CloseOTDate,
            'IsActive' => $this->IsActive,
            'DateCrt' => $this->DateCrt,
        ]);
        
        return $dataProvider;
    }
    
    public function searchProd($params)
    {

        $cariData = $params;
        $val = '';
        $sql = new \yii\db\Query();
        
        if(isset($params['typeSearch']) && isset($params['textsearch']))
        {
            
                $index = $params['typeSearch'];
                $val = $params['textsearch'];
           
        }
        
        if($val == '')
        {
            $sql->select('AD.ProductID,mp.Nama')
                ->distinct(true)
                ->from('MasterProduct mp')
                ->leftJoin('AllocationProductD AD','AD.ProductID = mp.ProductID')
                ->leftJoin('SOD','SOD.SODID = AD.SODID')       
                ->leftJoin('SOH','SOH.SOIDH = SOD.SOIDH')
                ->leftJoin('JadwalAbsensiStatusH jas','jas.CustomerID = SOH.CustomerID')
                ->where(['jas.CustomerID'=>$_GET['cusID'],'jas.AreaID'=>$_GET['areaID']])
                ->orderBy('AD.ProductID');
        } else {
            $sql->select('AD.ProductID,mp.Nama')
                ->distinct(true)
                ->from('MasterProduct mp')
                ->leftJoin('AllocationProductD AD','AD.ProductID = mp.ProductID')
                ->leftJoin('SOD','SOD.SODID = AD.SODID')       
                ->leftJoin('SOH','SOH.SOIDH = SOD.SOIDH')
                ->leftJoin('JadwalAbsensiStatusH jas','jas.CustomerID = SOH.CustomerID')
                ->where(['jas.CustomerID'=>$_GET['cusID'],'jas.AreaID'=>$_GET['areaID']])
                ->andWhere(['jas.Thn'=>$_GET['tahun'],'jas.Bln'=>$_GET['bulan']])
                ->andWhere([$index => $val])
                ->orderBy('AD.ProductID');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $sql,
            'sort' => false
        ]);
        
        $this->load($cariData);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $sql->andFilterWhere([
            'AD.ProductID' => $this->ProductID,
            'mp.Nama' => $this->ProductID,
        ]);

        return $dataProvider;
    }
}

<?php

namespace app\payroll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\eprocess\models\JadwalAbsensiStatusH;
use app\operational\models\SOH;
use yii\db\Expression;
/**
 * AbsensiCustomerSearch represents the model behind the search form about `app\payroll\models\AbsensiCustomer`.
 */
class AbsensiCustomerSearch extends AbsensiCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SODID', 'SeqProduct','ProductID', 'Tgl','Status', 'BackUpProductID', 'JamMasuk', 'JamKeluar', 'UserCrt', 'DateCrt'], 'safe'],
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

    public function search($params)
    {
        $bulan = isset($params['bulan']) ? $params['bulan'] : date('m') ;
        $tahun = isset($params['tahun']) ? $params['tahun'] : date('Y') ;

        $query= new \yii\db\Query();
        $subquery = (new \yii\db\Query)->select('oh.CustomerID,od.AreaID')
                ->distinct(true)
                ->from('SOD sd')
                ->leftJoin('OfferingD od','od.OfferingDID = sd.OfferingDID')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
                ->where(['>=','CONVERT(VARCHAR(6),sd.PeriodTo,112)', $tahun.$bulan])
                ->andWhere(['<=','CONVERT(VARCHAR(6),sd.PeriodFrom,112)', $tahun.$bulan]);
        
        $query->select("cs.CustomerID,mc.CustomerName, cs.AreaID ,ma.Description as AreaName")
                ->from(['cs'=>$subquery])
                ->leftJoin('MasterCustomer mc','mc.CustomerID = cs.CustomerID')
                ->leftJoin('MasterArea ma','ma.AreaID = cs.AreaID')
                ->orderBy([
                       'mc.CustomerName'=>SORT_ASC,
                       'ma.Description' => SORT_ASC,
                    ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $cariData = $params;
                
        if(isset($params['typeSearch']) && isset($params['textsearch'])){
            if($params['typeSearch'] == 1){
                $query->andFilterWhere(['like', 'mc.CustomerName', $params['textsearch']]);
            }  else if($params['typeSearch'] == 2) {
                $query->andFilterWhere(['like', 'ma.Description', $params['textsearch']]);
            } 
        }
        
        $this->load($cariData);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
    
    public function searchProd($params)   {
        $sql = new \yii\db\Query();
        $IsCloseAbsen = new Expression('0 as IsCloseAbsen');
        $CloseAbsenDate = new Expression('GETDATE() as CloseAbsenDate');
        $periode='201609';
        $sql->select(['sd.SODID','gp.SeqProduct','gp.ProductID','mp.Nama',$IsCloseAbsen,$CloseAbsenDate])
                ->from(['SOD sd'])
                ->innerjoin('OfferingD od','od.OfferingDID = sd.OfferingDID AND od.AreaID=\'' . $params['area'] . '\'')
                ->innerjoin('OfferingH oh','oh.OfferingIDH = od.OfferingIDH AND oh.CustomerID=\''.$params['idCus'].'\'')
                ->leftJoin('GoLiveProduct gp','gp.SODID = sd.SODID')
                ->leftJoin('MasterProduct mp','mp.ProductID = gp.ProductID')
                ->where(['<=','CONVERT(VARCHAR(6),sd.PeriodFrom,112)' , $periode])
                ->andWhere(['>=','CONVERT(VARCHAR(6),sd.PeriodTo,112)',$periode]);
                
        $dataProvider = new ActiveDataProvider(['query' => $sql]);
        
        $cariData = $params;
        
        if(isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['AbsensiCustomerSearch'=> 
                            ['r'  => $params['r'],
                            $params['typeSearch'] => $params['textsearch'],
                            'idJadwal'=>$params['idJadwal']
            ]];
        }
                
        $this->load($cariData);
        
        if (!$this->validate()) { return $dataProvider; }
        
        $sql->andFilterWhere([
            'jd.ProductID' => $this->ProductID,
            'mp.Nama' => $this->ProductID,
        ]);

        return $dataProvider;
    }
}

<?php

namespace app\eprocess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\eprocess\models\JadwalAbsensiStatusH;

class JadwalAbsensiStatusHSearch extends JadwalAbsensiStatusH
{
    /**
     * @inheritdoc
     */
    public $ProductID;
    public function rules()
    {
        return [
            [['IDJadwalAbsensiStatusH', 'CustomerID', 'AreaID', 'Thn', 'Bln', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsClose', 'IsActive'], 'integer'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()    {
        return Model::scenarios();
    }
    
    public function search($params)    {
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
               $index = 'CustomerID';
               $val = $params['textsearch'];
            }  else if($params['typeSearch'] == 2) {
               $index = 'AreaID';
               $val = $params['textsearch'];
            } else  {
                $val = '';
                $index = '';
            }
                        
            if($val != '') {
                $cariData = ['JadwalAbsensiStatusHSearch' => [
                        'r'  => $params['r'],
                        $index => $val
                    ]
                ];
            }
        }
        
        $this->load($cariData);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'mc.CustomerName', $this->CustomerID])
            ->andFilterWhere(['like', 'ma.Description', $this->AreaID]);

        return $dataProvider;
    }
    
    public function searchProd($params)    {
        $cariData = $params;
        $idJadwal = Yii::$app->request->get('idJadwal','xx');
        
        $sql = new yii\db\Query();
        $sql->select('jd.IDJadwalAbsensiStatusH,jd.ProductID,mp.Nama,jd.IsCloseJadwal,jd.CloseJadwalDate')
                ->from('JadwalAbsensiStatusD jd')
                ->leftJoin('JadwalAbsensiStatusH jh','jh.IDJadwalAbsensiStatusH=jd.IDJadwalAbsensiStatusH')
                ->leftJoin('MasterProduct mp','mp.ProductID=jd.ProductID')
                ->where(['jh.IDJadwalAbsensiStatusH'=>$idJadwal]);
        
        $dataProvider = new ActiveDataProvider(['query' => $sql]);
        
        $this->load($cariData);
        
        if (!$this->validate()) { return $dataProvider; }
        
        $sql->andFilterWhere([
            'AD.ProductID' => $this->ProductID,
            'mp.Nama' => $this->ProductID,
        ]);

        return $dataProvider;
    }
    
}

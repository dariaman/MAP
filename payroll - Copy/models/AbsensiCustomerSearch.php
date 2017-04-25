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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = JadwalAbsensiStatusH::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) { return $dataProvider; }

        $query->andFilterWhere([
            'DateCrt' => $this->DateCrt,
        ]);
        
        return $dataProvider;
    }
    
    public function searchProd($params)   {
        // echo var_dump($params['area']);
        // echo var_dump($params['idCus']);
        // echo var_dump($params);
        $sql = new \yii\db\Query();
        $IsCloseAbsen = new Expression('0 as IsCloseAbsen');
        $CloseAbsenDate = new Expression('GETDATE() as CloseAbsenDate');
        // $areaID='00000001';
        $periode='201609';
        $sql->select(['sd.SODID','gp.SeqProduct','gp.ProductID','mp.Nama',$IsCloseAbsen,$CloseAbsenDate])
                ->from(['SOD sd'])
                ->innerjoin('OfferingD od','od.OfferingDID = sd.OfferingDID AND od.AreaID=\'' . $params['area'] . '\'')
                ->innerjoin('OfferingH oh','oh.OfferingIDH = od.OfferingIDH AND oh.CustomerID=\'' . $params['idCus'] . '\'')
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

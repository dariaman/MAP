<?php

namespace app\master\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\MasterCalonProduct;
use yii\db\Query;

/**
 * MasterCalonProductSearch represents the model behind the search form about `app\master\models\MasterCalonProduct`.
 */
class MasterCalonProductSearch extends MasterCalonProduct {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['CalonProductID', 'Nama', 'IDJobDesc', 'AreaID', 'Gender', 'KTP', 'KTPExpireddate', 'SIM', 'SIMExpireDate', 'IDstatusnikah', 'Address', 'RefferensiDesc', 'City', 'Zip', 'Phone', 'Mobile1', 'Mobile2', 'BankID', 'BankAccNumber', 'NPWP', 'Status', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsActive'], 'integer'],
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
    public function search($params) {
//        $model = new MasterCalonProduct();
        $subQuery = (new Query)->select('CalonProductID,Nilai=SUM(Nilai)/4')->from('NilaiTes')->groupBy('CalonProductID');
        $query = (new Query)->select('mc.CalonProductID,nt.Nilai, mc.Nama,mc.IDJobDesc,
                                        msp.Description AS mdes,msp.IDStatusPernikahan as IDNikah, mjd.Description AS mjes,mc.Gender,
                                        mc.KTP,mc.KTPExpireddate,mc.SIM,mc.SIMExpireDate,mc.Address,
                                        mc.RefferensiDesc,mc.City,mc.NPWP,mc.BankAccNumber,mbg.BankGroupName as BankName,mc.AreaID,ma.Description as AreaName,mc.NoKK,mc.IsActive')
                ->from(['mc' => MasterCalonProduct::tableName()])
                ->join('LEFT JOIN', 'MasterJobDesc mjd', 'mc.IDJobDesc=mjd.IDJobDesc')
                ->join('LEFT JOIN', 'MasterBankGroup mbg', 'mbg.BankGroupID = mc.BankID')
                ->join('LEFT JOIN', 'MasterStatusPernikahan msp', 'mc.IDstatusnikah=msp.IDStatusPernikahan')
                ->leftJoin('MasterArea ma','ma.AreaID = mc.AreaID')
                ->join('LEFT JOIN', ['nt' => $subQuery], 'nt.CalonProductID=mc.CalonProductID')
                ->where("mc.IsActive  = 1")
                ->orderBy('mc.DateCrt');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
//        $cariData = $params;
        
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                
                if($params['typeSearch'] == 'mjd.Description')
                {
                    $query->andFilterWhere(['or',['like',$params['typeSearch'],$params['textsearch']]]);
                } else if($params['typeSearch'] == 'mc.Nama'){
                    $query->andFilterWhere(['or',['like',$params['typeSearch'],$params['textsearch']]]);
                } else {
                    $query->andFilterWhere([$params['typeSearch'] => $params['textsearch']]);
                }
                
            }
        }

//        $this->load($cariData);
//
//        if (!$this->validate()) {
//            return $dataProvider;
//        }
//
//        $query->andFilterWhere([
//            'mc.CalonProductID' => $this->CalonProductID,
//            'Nama' => $this->Nama,
//            'mc.IDJobDesc' => $this->IDJobDesc,
//            'mjes' => $this->mjes,
//            'KTP' => $this->KTP,
//            'SIM' => $this->SIM,
//            'NPWP' => $this->NPWP
//        ]);
        return $dataProvider;
    }

}

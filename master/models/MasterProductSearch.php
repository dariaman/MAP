<?php

namespace app\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\master\models\Masterproduct;

/**
 * MasterProductSearch represents the model behind the search form about `app\master\models\Masterproduct`.
 */
class MasterProductSearch extends Masterproduct {

    public function rules() {
        return [
            [['ProductID', 'IDCalonProduct', 'AreaID', 'Nama', 'IDJobDesc', 'Gender', 'KTP', 'KTPExpiredDate', 'SIM', 'SIMExpiredDate', 'IDStatusNikah', 'Address', 'City', 'Zip', 'Phone', 'Mobile1', 'Mobile2', 'BankID', 'BankAccNumber', 'NPWP', 'Status', 'Class', 'UserCrt', 'DateCrt', 'UserUpdate', 'DateUpdate'], 'safe'],
            [['IsActive', 'IsBlacklist'], 'integer'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = MasterProduct::find()
                ->select(['mp.ProductID','ma.Description as AreaName', 'mp.Nama', 'mj.Description as MJDesc', 'mp.Gender', 'mp.KTP', 'mp.KTPExpiredDate', 'mp.SIM', 'mp.SIMExpiredDate', 'ms.Description as MSD','ms.IDStatusPernikahan as IDNikah', 'mp.Address', 'mp.City', 'mp.Zip', 'mp.Phone', 'mp.Mobile1', 'mp.Mobile2', 'mbg.BankGroupName as BankName', 'mp.BankAccNumber', 'mp.NPWP', 'mp.Status', 'mp.IsActive', 'mp.Class','mp.NoKK'])
                ->from('MasterProduct mp')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->leftJoin('MasterArea ma', 'ma.AreaID = mp.AreaID')
                ->leftJoin('MasterStatusPernikahan ms', 'ms.IDStatusPernikahan = mp.IDStatusNikah')
                ->leftJoin('MasterBankGroup mbg', 'mbg.BankGroupID = mp.BankID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false,
        ]);
        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                if($params['typeSearch'] == 'mp.Nama')
                {
                    $query->andFilterWhere(['like',$params['typeSearch'],$params['textsearch']]);
                } else {
                    $query->andFilterWhere([$params['typeSearch'] => $params['textsearch']]);
                }
            }
        }
        return $dataProvider;
    }

    public function searchAllocProd($params, $idjob) {
        $query = (new \yii\db\Query)->select('mj.Description as MJDesc,msp.Description as MSD,mp.ProductID, mp.Nama,'
                        . 'mp.Gender, mp.KTP, mp.KTPExpiredDate,mp.SIM, mp.SimExpiredDate,mp.Address,mp.City')
                ->from('MasterProduct mp')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->leftJoin('MasterStatusPernikahan msp', 'msp.IDStatusPernikahan = mp.IDStatusNikah')
                ->leftJoin('MasterBank mb', 'mb.BankID = mp.BankID')
                ->where(['mp.IDJobDesc' => $idjob, 'mp.Status' => 'GS', 'mp.IsActive' => 1])
        ;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['MasterProductSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Nama' => $this->Nama,
        ]);



        return $dataProvider;
    }

    public function searchAbsenGS($params, $thn, $bln) {

        if ($bln <= 1) {
            $startabsen = $thn . '-' . ($bln) . '-' . '16';
        } else {
            $startabsen = $thn . '-' . ($bln - 1) . '-' . '16';
        }

        $endabsen = $thn . '-' . $bln . '-' . '15';

        $query = MasterProduct::find()
                ->select([
                    'mp.ProductID', 'mp.Nama', 'mj.Description as MJDesc', 'mp.Gender',
                    'isnull(asg.Thn,\'' . $thn . '\') Thn',
                    'isnull(asg.Bln,\'' . $bln . '\') Bln',
                    'asg.IsCloseAbsen',
                    'asg.CloseAbsenDate',
                    'a.jlh'
                ])
                ->from('MasterProduct mp')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->leftJoin('AbsensiStatusGS asg', "mp.ProductID = asg.ProductID AND asg.Thn='$thn' AND asg.Bln='$bln'")
                ->leftJoin('MasterBank mb', 'mb.BankID = mp.BankID')
                ->leftJoin(" ( select ProductID, count('') jlh from AbsensiGS 
                            where tgl>='$startabsen' AND tgl<='$endabsen'
                            group by ProductID
                        )a ", 'a.ProductID=mp.ProductID')
                ->where("mp.IsActive  = 1");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $cariData = $params;

        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
            $cariData = ['MasterProductSearch' => [
                    'r' => $params['r'],
                    $params['typeSearch'] => $params['textsearch'],
            ]];
        }

        $this->load($cariData);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Nama' => $this->Nama,
        ]);
        return $dataProvider;
    }

    public function searchLookupProductgs($params, $idjob) {

        if ($idjob == 'kosong') {
            $query = (new \yii\db\Query)
                    ->select('mp.ProductID, mp.Nama, mj.Description, mp.Gender, mp.KTP, mp.IDStatusNikah,mp.City , mp.Address')
                    ->from('MasterProduct mp')
                    ->Join('LEFT JOIN', 'MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                    ->where(['mp.Status' => 'GS', 'mp.IsActive' => 1])
                    ->orderBy(['mp.Nama' => SORT_ASC]);
        } else {
            $query = (new \yii\db\Query)
                    ->select('mp.ProductID, mp.Nama, mj.Description, mp.Gender, mp.KTP, mp.IDStatusNikah,mp.City , mp.Address')
                    ->from('MasterProduct mp')
                    ->Join('LEFT JOIN', 'MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                    ->where(['mp.IDJobDesc' => $idjob, 'mp.Status' => 'GS', 'mp.IsActive' => 1])
                    ->orderBy(['mp.Nama' => SORT_ASC]);
        }
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

//    public function searchLookupProductgs1($params, $idjob) {
//
//        $query = (new \yii\db\Query)
//                ->select('mp.ProductID, mp.Nama, mj.Description, mp.Gender, mp.KTP, mp.IDStatusNikah,mp.City , mp.Address')
//                ->from('MasterProduct mp')
//                ->Join('LEFT JOIN', 'MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
//                ->where(['mp.IDJobDesc' => $idjob, 'mp.Status' => 'GS', 'mp.IsActive' => 1])
//                ->orderBy(['mp.Nama' => SORT_ASC]);
//
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query
//        ]);
//        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
//            if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
//                $query->andFilterWhere([
//                    $params['typeSearch'] => $params['textsearch']
//                ]);
//            }
//        }
//        return $dataProvider;
//    }

    public function searchLookupProductfix($params) {
        $query = (new \yii\db\Query)
                ->select('gl.SODID , gl.SeqProduct , gl.ProductID , mp.Nama , oh.CustomerID , mc.CustomerName')
                ->from(['gl' => \app\operational\models\GoLiveProduct::tableName()])
                ->Join('LEFT JOIN', 'MasterProduct mp', 'gl.ProductID = mp.ProductID')
                ->Join('LEFT JOIN', 'SOD sod', 'gl.SODID = sod.SODID')
                ->Join('LEFT JOIN', 'SOH soh', 'sod.SOIDH = soh.SOIDH')
                ->Join('LEFT JOIN', 'OfferingH oh', 'soh.SOIDH = oh.SOIDH')
                ->Join('LEFT JOIN', 'MasterCustomer mc', 'oh.CustomerID = mc.CustomerID')
                ->where(['soh.Status' => 'A', 'sod.Status' => 'A', 'sod.StatusGoLive' => 'A'])
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
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $cariData = $params;
//
//        if (isset($params['typeSearch']) && isset($params['textsearch'])) {
//            $cariData = ['MasterProductSearch' => [
//                    'r' => $params['r'],
//                    $params['typeSearch'] => $params['textsearch'],
//            ]];
//        }
//
//        $this->load($cariData);
//
//        if (!$this->validate()) {
//            return $dataProvider;
//        }
//        
//        $query->andFilterWhere([
//            'gl.ProductID' => $this->ProductID,
//            'mc.CustomerID' => $this->CustomerName,
//            'gl.SODID' => $this->SODID,
//        ]);
//        return $dataProvider;
//        
    }

    public function searchRptProduct($params) {
        $query = MasterProduct::find()
                ->select([
                    'mp.ProductID','ma.Description as AreaName', 'mp.Nama', 'mj.Description as MJDesc', 
                    'mp.Gender', 'mp.KTP', 'mp.KTPExpiredDate', 'mp.SIM', 'mp.SIMExpiredDate', 
                    'ms.Description as MSD','ms.IDStatusPernikahan as IDNikah', 
                    'mp.Address', 'mp.City', 'mp.Zip', 'mp.Phone', 'mp.Mobile1', 
                    'mp.Mobile2', 'mbg.BankGroupName as BankName', 'mp.BankAccNumber', 
                    'mp.NPWP', 'mp.Status', 'mp.IsActive','mp.NoKK','mc.CustomerName as CusName'])
                ->from('MasterProduct mp')
                ->leftJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                ->leftJoin('MasterArea ma', 'ma.AreaID = mp.AreaID')
                ->leftJoin('MasterStatusPernikahan ms', 'ms.IDStatusPernikahan = mp.IDStatusNikah')
                ->leftJoin('MasterBankGroup mbg', 'mbg.BankGroupID = mp.BankID')
                ->leftJoin('GoLiveProduct gl','gl.ProductID = mp.ProductID')
                ->leftJoin('SOD','SOD.SODID = gl.SODID')
                ->leftJoin('SOH','SOH.SOIDH = SOD.SOIDH')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = SOH.OfferingIDH')
                ->leftJoin('MasterCustomer mc','mc.CustomerID = oh.CustomerID')
                ->orderBy('mp.Status,mp.Nama');
//                ->where(['SimExpiredDate' => NULL]);
        
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => false,
            ]);
            if (isset($params['typeSearch']) && isset($params['textsearch'])) {
                if ($params['typeSearch'] != '' && $params['textsearch'] != '') {
                    $query->andFilterWhere([$params['typeSearch'] => $params['textsearch']]);
                }
            }
            return $dataProvider;
        }

}


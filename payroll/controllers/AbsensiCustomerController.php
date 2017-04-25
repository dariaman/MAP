<?php

namespace app\payroll\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\payroll\models\AbsensiCustomer;
use app\payroll\models\JadwalGolive;
use app\payroll\models\AbsensiCustomerSearch;
use yii\helpers\BaseStringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use kartik\export\ExportMenu;
//use yii\base\Model;

/**
 * AbsensiCustomerController implements the CRUD actions for AbsensiCustomer model.
 */
class AbsensiCustomerController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AbsensiCustomer models.
     * @return mixed
     */
    public function actionIndex($bulan=null,$tahun=null) {
        $searchModel = new AbsensiCustomerSearch();
        $jdwl = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($jdwl);
        return $this->render('index', [
                    'bulan' => Yii::$app->request->get('bulan',Yii::$app->request->post('bulan',date('m'))),
                    'tahun' => Yii::$app->request->get('tahun',Yii::$app->request->post('tahun',date('Y'))),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDtl() {
        $idCus  = Yii::$app->request->get('idCus','xx');
        $areaid = Yii::$app->request->get('area','xx');
        $bulan  = Yii::$app->request->get('bulan','xx');
        $tahun  = Yii::$app->request->get('tahun','xx');

        if(Yii::$app->request->post('typeSearch','xx') == 'ProductID'){
            $prod  = Yii::$app->request->post('textsearch','xx');
        }else{
            $prod  = Yii::$app->request->post('xx','xx');
        }
        

        $sql="SELECT DISTINCT 
                oh.CustomerID,
                mc.CustomerName,
                od.AreaID,
                ma.Description AS AreaName,
                mt.StartAbsen,
                mt.EndAbsen
            FROM SOD sd
            LEFT JOIN OfferingD od ON od.OfferingDID = sd.OfferingDID 
            LEFT JOIN OfferingH oh ON oh.OfferingIDH = od.OfferingIDH
            LEFT JOIN dbo.MasterCustomer mc ON mc.CustomerID = oh.CustomerID
            LEFT JOIN dbo.MasterArea ma ON ma.AreaID = od.AreaID
            LEFT JOIN dbo.MasterAbsenType mt ON mt.ID = mc.IDAbsenType
            WHERE oh.CustomerID='$idCus' AND od.AreaID='$areaid'";        
        $cus = Yii::$app->db->createCommand($sql)->queryAll();

        if (Yii::$app->request->post('typeSearch') != '' && (Yii::$app->request->post('textsearch','xx') != 'xx')) {
$cmd = Yii::$app->db->createCommand("exec SearchAbsenCustomer '$idCus','$areaid','$tahun$bulan','$prod'")->queryAll();
            $provider = new \yii\data\ArrayDataProvider([
                'allModels' => $cmd,
            ]);            
        }else{
$cmd = Yii::$app->db->createCommand("exec GetJumlahAbsenCustomer '$idCus','$areaid','$tahun$bulan'")->queryAll();
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $cmd,
        ]);
    }

        return $this->render('detail', [
            'cus' => $cus,
            'StartAbsen' => ($cus[0]['StartAbsen'] =='01') ? date($tahun.'-'.$bulan.'-01') 
                        : date($tahun.'-'.substr('0'.($bulan-1), strlen('0'.($bulan-1))-2).'-'.$cus[0]['StartAbsen']),
            'EndAbsen' => ($cus[0]['StartAbsen'] =='01') ? date('Y-m-t',strtotime($tahun.'-'.$bulan.'-01')) 
                        : date($tahun.'-'.$bulan.'-'.$cus[0]['EndAbsen']),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataProvider' => $provider,
        ]);
    }
    
    public function actionProduct() {
        $sodid = Yii::$app->request->get('sodid','xx');
        $sqid = Yii::$app->request->get('sqid','0');
        $period = Yii::$app->request->get('period','xx');

        $tahun=substr($period,0,4);
        $bulan=substr($period,4,2);

        $sql="SELECT DISTINCT 
                oh.CustomerID,
                mc.CustomerName,
                od.AreaID,
                ma.Description AS AreaName,
                gp.ProductID,
                mp.Nama,
                mt.StartAbsen,
                mt.EndAbsen
            FROM SOD sd
            LEFT JOIN OfferingD od ON od.OfferingDID = sd.OfferingDID 
            LEFT JOIN OfferingH oh ON oh.OfferingIDH = od.OfferingIDH
            LEFT JOIN dbo.MasterCustomer mc ON mc.CustomerID = oh.CustomerID
            LEFT JOIN dbo.MasterArea ma ON ma.AreaID = od.AreaID
            LEFT JOIN dbo.MasterAbsenType mt ON mt.ID = mc.IDAbsenType
            LEFT JOIN dbo.GoLiveProduct gp ON gp.SODID = sd.SODID AND gp.SeqProduct=$sqid
            LEFT JOIN dbo.MasterProduct mp ON mp.ProductID = gp.ProductID
            WHERE sd.SODID='$sodid'";
        
        $cus = Yii::$app->db->createCommand($sql)->queryAll();
        $StartAbsen = ($cus[0]['StartAbsen'] =='01') 
                            ? date($tahun.'-'.$bulan.'-01') 
                            : date($tahun.'-'.substr('0'.($bulan-1), strlen('0'.($bulan-1))-2).'-'.$cus[0]['StartAbsen']);
        $EndAbsen = ($cus[0]['StartAbsen'] =='01') 
                            ? date($tahun.'-'.$bulan.'-t') 
                            : date($tahun.'-'.$bulan.'-'.$cus[0]['EndAbsen']);

        if (Yii::$app->getRequest()->isPost) {
            $seleksi = Yii::$app->request->post('selection');
            $absen = Yii::$app->request->post('absensi');

            $sodid = Yii::$app->request->post('SODID','xx');
            $sqid = Yii::$app->request->post('seqno','0');

            if($absen != null){ // input absensi dengan jam
                foreach ($absen as $index => $item) {
                    $Absensi = $this->findModel($sodid,$sqid,$item['tgl']);
                    $Absensi->SODID = $sodid;
                    $Absensi->SeqProduct = $sqid;
                    $Absensi->Tgl = $item['tgl'];
                    $Absensi->periode = $period;
                    $Absensi->IsHadir = 0;
                    if ($Absensi->isNewRecord){
                        $Absensi->UserCrt = Yii::$app->user->identity->username;
                    }else{
                        $Absensi->UserUpdate = Yii::$app->user->identity->username;
                        $Absensi->DateUpdate = new \yii\db\Expression('getdate()');
                    }

                    

                    // Pastikan data jam keluar dan jam masuk diisi, 
                    if(($item['JamMasuk']!= null) && ($item['JamKeluar'] != null) 
                            && (strlen(str_replace('_','',$item['JamMasuk'])) === 5) 
                            && (strlen(str_replace('_','',$item['JamKeluar'])) === 5)){
                        // mastikan karakter jam yang dimasukkan benar
                        $Absensi->JamMasuk = $item['tgl'].' '.$item['JamMasuk'];
                        $Absensi->JamKeluar = $item['TglKeluar'].' '.$item['JamKeluar'];

                        if($item['InsRaya']==1){ $Absensi->InsRaya=1; }
                        if($item['spd']==1){ $Absensi->spd=1; }
                        if($item['inap']==1){ $Absensi->inap=1; }
                        // echo var_dump($item);
                    } else {
                        $Absensi->JamMasuk = null;
                        $Absensi->JamKeluar = null;
                    }
                    $Absensi->save(false);
                    Yii::$app->getSession()->setFlash('success', ' Data berhasil disimpan');
                }
            }elseif ($seleksi != null) { // input absensi dengan ceklist
                $DataAbsen = Yii::$app->request->post('DataAbsen','xx');
                $Jadwal = $this->findModelJadwal($sodid,$sqid);
                // echo var_dump($Jadwal);                

                foreach ($seleksi as $index => $item) {
                    if ($Jadwal->isNewRecord){
                        Yii::$app->getSession()->setFlash('error', ' Jadwal Kosong');
                        break;
                    }
                    $Absensi = $this->findModel($sodid,$sqid,$item);
                    
                    switch ($DataAbsen[$item]) {
                        case 'Sunday':
                            if($Jadwal->Sunday1 != '' && $Jadwal->Sunday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Sunday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Sunday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Monday':
                            if($Jadwal->Monday1 != '' && $Jadwal->Monday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Monday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Monday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Tuesday':
                            if($Jadwal->Tuesday1 != '' && $Jadwal->Tuesday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Tuesday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Tuesday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Wednesday':
                            if($Jadwal->Wednesday1 != '' && $Jadwal->Wednesday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Wednesday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Wednesday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Thursday':
                            if($Jadwal->Thursday1 != '' && $Jadwal->Thursday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Thursday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Thursday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Friday':
                            if($Jadwal->Friday1 != '' && $Jadwal->Friday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Friday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Friday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        case 'Saturday':
                            if($Jadwal->Saturday1 != '' && $Jadwal->Saturday2 != ''){
                                $Absensi->JamMasuk  = $item.' '.$Jadwal->Saturday1;
                                $Absensi->JamKeluar = $item.' '.$Jadwal->Saturday2;
                                $Absensi->IsHadir = 1;
                            }else{
                                $Absensi->JamMasuk  = null;
                                $Absensi->JamKeluar = null;
                                $Absensi->IsHadir = 0;
                            }
                            break;
                        default:
                            $Absensi->JamMasuk  = null;
                            $Absensi->JamKeluar = null;
                            $Absensi->IsHadir = 0;
                    }
                        
                    $Absensi->SODID = $sodid;
                    $Absensi->SeqProduct = $sqid;
                    $Absensi->Tgl = $item;
                    $Absensi->periode = $period;
                    
                    if ($Absensi->isNewRecord){
                        $Absensi->UserCrt = Yii::$app->user->identity->username;
                    }else{
                        $Absensi->UserUpdate = Yii::$app->user->identity->username;
                        $Absensi->DateUpdate = new \yii\db\Expression('getdate()');
                    }
                    $Absensi->save(false);
                    unset($DataAbsen[$item]);                    
                } // END foreach ($seleksi as $index => $item)

                foreach ($DataAbsen as $index => $item){
                    $Absensi = $this->findModel($sodid,$sqid,$index);
                    $Absensi->SODID = $sodid;
                    $Absensi->SeqProduct = $sqid;
                    $Absensi->Tgl = $index;
                    $Absensi->periode = $period;
                    $Absensi->IsHadir = 0;
                    $Absensi->JamMasuk  = null;
                    $Absensi->JamKeluar = null;
                    if ($Absensi->isNewRecord){
                        $Absensi->UserCrt = Yii::$app->user->identity->username;
                    }else{
                        $Absensi->UserUpdate = Yii::$app->user->identity->username;
                        $Absensi->DateUpdate = new \yii\db\Expression('getdate()');
                    }
                    $Absensi->save(false);
                }
            }
        }
        
        $cmd = Yii::$app->db
                    ->createCommand("exec GenerateAbsenVerifikasi @SODID='$sodid',@SeqProd=$sqid,@periode='$period'")
                    ->queryAll();

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $cmd,
            'pagination' => ['pageSize' => 50],
        ]);

        // variabel Ceklist=1 untuk input dengan ceklist, Ceklist=0 untuk input dengan jam
        if (Yii::$app->request->get('Ceklist') == 0) {
            return $this->render('editproduct', [
                'dataProvider' => $provider,
                'cus' => $cus,
                'sodid' => $sodid,
                'sqid'=>$sqid,
                'period' => $period,
                'StartAbsen' => $StartAbsen,
                'EndAbsen' => $EndAbsen,
            ]);
        } else {
            return $this->render('ceklist', [
                'dataProvider' => $provider,
                'cus' => $cus,
                'sodid' => $sodid,
                'sqid'=>$sqid,
                'period' => $period,
                'StartAbsen' => $StartAbsen,
                'EndAbsen' => $EndAbsen,
            ]);
        }
    }

    public function actionCloseAbsen() {

        foreach (Yii::$app->request->post('selection') as $valdata) {
            if($valdata == '') { continue ;}

            $data = BaseStringHelper::explode($valdata,'|',true,false);
            if($data[0] == '' || $data[1] == '' || $data[2] == '') { continue ;}
            try{

                $sql = Yii::$app->db->createCommand("exec dbo.CloseAbsenPerProduct @SODID= :SODID, @SeqID= :SeqID, @periode= :periode, @usercrt= :usercrt");
                                $sql->bindValue(':SODID',$data[0]);
                                $sql->bindValue(':SeqID',$data[1]);
                                $sql->bindValue(':periode',$data[2]);
                                $sql->bindValue(':usercrt',Yii::$app->user->identity->username);
                                $sql->execute();
            }catch(\yii\db\Exception $ex){
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                // return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAbsenGs() {
        $yearnw = Yii::$app->request->post('tahun', date('o'));
        $monthnw = Yii::$app->request->post('bulan', date('m'));

        $searchModel = new \app\master\models\MasterProductSearch();
        $dataProvider = $searchModel->searchAbsenGS(Yii::$app->request->queryParams, $yearnw, $monthnw);

        return $this->render('indexabsengs', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerateAbsen() {
        $productid = Yii::$app->request->get('productid');
        $period = Yii::$app->request->get('tahun') . Yii::$app->request->get('bulan');
        $pic = Yii::$app->user->identity->username;
        if (Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('selection') as $ttgl) {
                $model = new \app\payroll\models\AbsensiGS();
                $model->ProductID = $productid;
                $model->tgl = $ttgl;
                $model->UserCrt = $pic;
                $model->DateCrt = new \yii\db\Expression(' getdate() ');
                $model->save();
            }

            // biar gak re-submit data
            return $this->redirect(Yii::$app->request->referrer);
        }
        $cmd = Yii::$app->db->createCommand("exec GenerateDummyAbsenGS '$productid','$period'")->queryAll();

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $cmd,
            'pagination' => ['pageSize' => 50],
        ]);
        return $this->render('generateabsen', [
                    'dataProvider' => $provider
        ]);
    }

    public function actionCloseAbsenGs() {
        $productid = Yii::$app->request->get('ProductID');
        $period = Yii::$app->request->get('period');
        $usercrt = Yii::$app->user->identity->username;
        $pesan = Yii::$app->db->createCommand("exec CloseAbsenGS '$productid','$period','$usercrt'")->queryScalar();

        if ($pesan == '') {
            Yii::$app->getSession()->setFlash('success', ' Data berhasil di Closed');
        } else {
            Yii::$app->getSession()->setFlash('error', $pesan);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDownloadAbsen(){
        $cus = Yii::$app->request->get('idCus');
        $area = Yii::$app->request->get('area');
        $period = Yii::$app->request->get('tahun').Yii::$app->request->get('bulan');

            $kolom = [
                [
                    'attribute' => 'Tgl',
                    'header' => 'Tanggal',
                    // 'format' => 'text',
                ],
                [
                    'attribute' => 'JamMasuk',
                    'header' => 'TimeIn',
                ],
                [
                    'attribute' => 'JamKeluar',
                    'header' => 'TimeOut',
                ],
                [
                    'attribute' => 'ProductID',
                    'header' => 'Driver ID',
                ],
                [
                    'attribute' => 'Nama',
                    'header' => 'Driver Name',
                ],
                [
                    'attribute' => 'StatusKerja',
                    'header' => 'Day',
                ],
                [
                    'attribute' => 'OTPagi',
                    'header' => 'OT Pagi',
                ],
                [
                    'attribute' => 'OTMalam',
                    'header' => 'OT Malam',
                ],
                [
                    'attribute' => 'OTJamPagi',
                    'header' => 'Jam OT Pagi',
                ],
                [
                    'attribute' => 'OTPointPagi1',
                    'header' => 'Point 1 (Pagi)',
                ],
                [
                    'attribute' => 'OTPointPagi2',
                    'header' => 'Point 2 (Pagi)',
                ],
                [
                    'attribute' => 'OTPointPagi3',
                    'header' => 'Point 3 (Pagi)',
                ],
                [
                    'attribute' => 'OTPointPagi4',
                    'header' => 'Point 4 (Pagi)',
                ],
                [
                    'attribute' => 'OTJamMalam',
                    'header' => 'Jam OT Malam',
                ],
                [
                    'attribute' => 'OTPointMalam1',
                    'header' => 'Point 1 (Malam)',
                ],
                [
                    'attribute' => 'OTPointMalam2',
                    'header' => 'Point 2 (Malam)',
                ],
                [
                    'attribute' => 'OTPointMalam3',
                    'header' => 'Point 3 (Malam)',
                ],
                [
                    'attribute' => 'OTPointMalam4',
                    'header' => 'Point 4 (Malam)',
                ],
                [
                    'attribute' => 'TotalPoint',
                    'header' => 'Total Point Pagi & Malam',
                ],
                [
                    'attribute' => 'RupiahPerPoint',
                    'header' => 'Tull Perjam ',
                ],
                [
                    'attribute' => 'TotalAmount',
                    'header' => 'TOTAL',
                ],
            ];

        $sql ="SELECT ac.SODID,ac.SeqProduct
                FROM dbo.AbsensiCustomer ac 
                INNER JOIN dbo.SOD sd ON sd.SODID = ac.SODID
                INNER JOIN dbo.OfferingD od ON od.OfferingDID = sd.OfferingDID
                INNER JOIN dbo.OfferingH oh ON oh.OfferingIDH = od.OfferingIDH
                WHERE oh.CustomerID='$cus' AND od.AreaID='$area'
                GROUP BY ac.SODID,ac.SeqProduct";
        $sheet = Yii::$app->db->createCommand($sql)->queryAll();

        if(empty($sheet)){
            echo Yii::$app->getSession()->setFlash('warning', 'Data Product Kosong');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $modelArray =null;
        $kolomArray =null;

        foreach ($sheet as $key => $value) {
            $datax = Yii::$app->db->createCommand("exec dbo.DataAbsenPerProduct '$value[SODID]',$value[SeqProduct],'$period'")->queryAll();

            if($datax != null){

                $modelArray = ArrayHelper::merge($modelArray, [$datax[0]['Nama'] => $datax]);
                $kolomArray = ArrayHelper::merge($kolomArray, [$datax[0]['Nama'] => $kolom]);
            }
        }

        if($modelArray == null || empty($modelArray)){
            echo Yii::$app->getSession()->setFlash('warning', 'Data Kosong');
            return $this->redirect(Yii::$app->request->referrer);
        }

        // /// prosees edit (manipulasi data)
        foreach ($modelArray as $key => $value) {
            foreach ($value as $d => $item) {
                /// jika jam masuk kosong, maka product juga dikosongkan
                if($item['JamMasuk'] === null){
                    $modelArray[$key][$d]['ProductID'] = '';
                    $modelArray[$key][$d]['Nama'] = '';
                }

                /// jam dipotong menjadi tanggal, jam, dan menit saja
                $modelArray[$key][$d]['JamMasuk'] = ($item['JamMasuk'] === null) ? '' : substr($item['JamMasuk'], 0, -7);
                $modelArray[$key][$d]['JamKeluar'] = ($item['JamKeluar'] === null) ? '' : substr($item['JamKeluar'], 0, -7);

                $modelArray[$key][$d]['StatusKerja'] = ($item['StatusKerja'] == 'N' ) ? 'WORK DAY' : 'OFF DAY';

                /// kosongin data yang 
                $modelArray[$key][$d]['OTPagi'] = ($item['OTPagi'] == '0:00' ) ? '' : $item['OTPagi'];
                $modelArray[$key][$d]['OTMalam'] = ($item['OTMalam'] == '0:00' ) ? '' : $item['OTMalam'];
                $modelArray[$key][$d]['OTJamPagi'] = ($item['OTJamPagi'] == '.0' || $item['OTJamPagi'] == '.00') ? '' : $item['OTJamPagi'];
                $modelArray[$key][$d]['OTPointPagi1'] = ($item['OTPointPagi1'] == '.0' || $item['OTPointPagi1'] == '.00') ? '' : $item['OTPointPagi1'];
                $modelArray[$key][$d]['OTPointPagi2'] = ($item['OTPointPagi2'] == '.0' || $item['OTPointPagi2'] == '.00') ? '' : $item['OTPointPagi2'];
                $modelArray[$key][$d]['OTPointPagi3'] = ($item['OTPointPagi3'] == '.0' || $item['OTPointPagi3'] == '.00') ? '' : $item['OTPointPagi3'];
                $modelArray[$key][$d]['OTPointPagi4'] = ($item['OTPointPagi4'] == '.0' || $item['OTPointPagi4'] == '.00') ? '' : $item['OTPointPagi4'];
                $modelArray[$key][$d]['OTJamMalam'] = ($item['OTJamMalam'] == '.0' || $item['OTJamMalam'] == '.00') ? '' : $item['OTJamMalam'];
                $modelArray[$key][$d]['OTPointMalam1'] = ($item['OTPointMalam1'] == '.0' || $item['OTPointMalam1'] == '.00') ? '' : $item['OTPointMalam1'];
                $modelArray[$key][$d]['OTPointMalam2'] = ($item['OTPointMalam2'] == '.0' || $item['OTPointMalam2'] == '.00') ? '' : $item['OTPointMalam2'];
                $modelArray[$key][$d]['OTPointMalam3'] = ($item['OTPointMalam3'] == '.0' || $item['OTPointMalam3'] == '.00') ? '' : $item['OTPointMalam3'];
                $modelArray[$key][$d]['OTPointMalam4'] = ($item['OTPointMalam4'] == '.0' || $item['OTPointMalam4'] == '.00') ? '' : $item['OTPointMalam4'];
                $modelArray[$key][$d]['TotalPoint'] = ($item['TotalPoint'] == '.0' || $item['TotalPoint'] == '.00') ? '' : $item['TotalPoint'];
                $modelArray[$key][$d]['RupiahPerPoint'] = ($item['RupiahPerPoint'] == '.0' || $item['RupiahPerPoint'] == '.00') ? '' : $item['RupiahPerPoint'];
                $modelArray[$key][$d]['TotalAmount'] = ($item['TotalAmount'] == '.0' || $item['TotalAmount'] == '.00') ? '' : $item['TotalAmount'];

            }
        }

        \moonland\phpexcel\Excel::widget([
            'models' => $modelArray,
            'isMultipleSheet' => true,
            'fileName' => 'fileName',
            'mode' => 'export',
            'columns' => $kolomArray
        ]);
    }

    public function actionUploadAbsen(){
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/files/uploads/';
        $fileUpload = new \app\payroll\models\CsvUpload();
        $FileLong = Yii::$app->params['uploadPath'] . 'AbsenCsv.csv';
        if (file_exists($FileLong)){
            unlink($FileLong);
        }

        if ($fileUpload->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($fileUpload,'file');
            $file->saveAs($FileLong);

            $periode = Yii::$app->request->post('CsvUpload');

             if($file){
                $csv_file =file($FileLong);
                foreach($csv_file as $item){
                    $data = explode(",",$item);
                    if(($data[0] ?? 'SODID') == 'SODID'){ continue;}
                    if(($data[0] ?? '') == '' || ($data[1] ?? '') == '' || ($data[2] ?? '') == ''){ continue; }
                    if(($data[3] ?? '') == ($data[4] ?? '')){ continue; }

                    $DataAbsen = new AbsensiCustomer();                    
                    $DataAbsen = $this->findModel($data[0],$data[1],$data[2]);
                    $DataAbsen->periode = $periode['periode'];
                    $DataAbsen->IsHadir = 0;
                    $DataAbsen->InsRaya = ($data[5] == '1') ? 1 : 0;
                    $DataAbsen->spd     = ($data[6] == '1') ? 1 : 0;
                    $DataAbsen->inap    = ($data[7] == '1') ? 1 : 0;

                    if($data[3] == '' || $data[4] == '' ){ 
                        $DataAbsen->JamMasuk  = null;
                        $DataAbsen->JamKeluar = null;
                    }else{
                        $DataAbsen->JamMasuk  = trim($data[2]).' '.trim($data[3]);
                        $DataAbsen->JamKeluar = trim($data[2]).' '.trim($data[4]);
                    }

                    if ($DataAbsen->isNewRecord){
                        $DataAbsen->SODID = $data[0];
                        $DataAbsen->SeqProduct = $data[1];
                        $DataAbsen->Tgl = $data[2];
                        $DataAbsen->UserCrt = Yii::$app->user->identity->username;
                    }else{
                        if($DataAbsen->periode !== $periode['periode'] ) { continue;}
                        $DataAbsen->UserUpdate = Yii::$app->user->identity->username;
                        $DataAbsen->DateUpdate = new \yii\db\Expression('getdate()');
                    }
                    $DataAbsen->save(false);
                }
             }
             return $this->redirect(['index',
                    'bulan' => substr($periode['periode'],-2),
                    'tahun' => substr($periode['periode'],0,4),
                ]);
        }
        
    }

    protected function findModel($sodid,$seqno,$tgl) {
        $model = AbsensiCustomer::findOne(['SODID' => $sodid , 'SeqProduct' => $seqno,'Tgl' =>$tgl]);
        if ($model === null) {
            $model = new AbsensiCustomer();
        }
        return $model;
    }

    protected function findModelJadwal($sodid,$seqno) {
        $model = JadwalGolive::findOne(['SODID' => $sodid , 'SeqProduct' => $seqno]);
        if ($model === null) {
            $model = new JadwalGolive();
        }
        return $model;
    }

    protected function findModelP($pid) {
        if (($model = \app\master\models\MasterProduct::findOne(['ProductID' => $pid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelM($tgl, $pid, $cusid) {
        if (($model = AbsensiCustomer::findOne(['CustomerID' => $cusid, 'ProductID' => $pid, 'Tgl' => $tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findModelAbsen($ProductID) {
        if (($model = \app\payroll\models\AbsensiGS::find(['ProductID' => $ProductID])) !== null) {
            return $model;
        } else {
            $model = new \app\payroll\models\AbsensiGS();
            return $model;
        }
    }
    
    // public function actionPrintOtAll($idjadwal){
        
    //     $findjadwal = Yii::$app->db->createCommand("
    //         select SODID,SeqProductID from JadwalAbsensiStatusH jh
    //         left join JadwalAbsensiStatusD jd on jd.IDJadwalAbsensiStatusH = jh.IDJadwalAbsensiStatusH
    //         where jh.IDJadwalAbsensiStatusH = '".$idjadwal."'")->queryOne();
        
    //     $getDataMP = Yii::$app->db->createCommand("
    //     select * from OTProductAmount otp
    //         left join JadwalGolive jg on jg.SODID = otp.SODID and jg.SeqProduct = otp.SeqProduct
    //         left join AbsensiCustomer ac on ac.SODID = otp.SODID and ac.SeqProduct = otp.SeqProduct and otp.tgl = ac.Tgl
    //     where  otp.SODID  = '".$findjadwal['SODID']."' and otp.SeqProduct = '".$findjadwal['SeqProductID']."'")->queryAll();
        
    //     if(count($getDataMP) <= 0)
    //     {
    //          echo Yii::$app->getSession()->setFlash('error', 'OT Product Kosong');
    //          return $this->redirect(Yii::$app->request->referrer); 
    //     }
        
        
    //     ob_end_clean();
    //     return $this->render('exportot',['idjadwal' => $idjadwal]); 
    // }
    
    // public function actionPrintOtPartial($idarr)
    // {
    //     $newarr = json_decode($idarr);
    //     ob_end_clean();
    //     return $this->render('exportotpart',['idsodid' => $newarr]); 

    // }
}

<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\AbsensiCustomer;
use app\payroll\models\AbsensiCustomerSearch;
//use app\eprocess\models\JadwalAbsensiStatusH;
//use app\operational\models\SOH;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    public function actionIndex() {
        // echo var_dump(Yii::$app->request->queryParams);
        // echo var_dump(Yii::$app->request->post('bulan',date('m')));

        $searchModel = new \app\eprocess\models\JadwalAbsensiStatusHSearch();        
        $jdwl = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($jdwl);
        return $this->render('index', [
                    'bulan' => Yii::$app->request->post('bulan',date('m')),
                    'tahun' => Yii::$app->request->post('tahun',date('Y')),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function insertData($csv) {
        $date = date("Y-m-d");
        $handle = fopen('files/uploads/' . $csv, "r");
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
            $csid = $fileop[0];
            $pdid = $fileop[1];
            $Tgl = $fileop[2];
            $jdwlmsk = $fileop[3];
            $jdwlkluar = $fileop[4];
            $sql = "INSERT INTO AbsensiCustomer (ProductID,Tgl,CustomerID, JamMasuk,JamKeluar,UserCrt,DateCrt) VALUES ('$pdid','$Tgl','$csid','$jdwlmsk','$jdwlkluar','" . Yii::$app->user->getId() . "','$date')";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        if ($query) {
            return $this->redirect(['index']);
        }
    }

    public function actionCreate() {
        $model = new AbsensiCustomer();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $basename = 'reportJadwal.' . $model->file->extension;
            $model->file->saveAs('files/uploads/' . $basename);
            $tr = Yii::$app->db->beginTransaction();
            try {
                $this->insertData($basename);
                $tr->commit();
            } catch (Exception $ex) {
                $tr->rollback();
                echo 'Caught exception: ', $ex->getMessage(), "\n";
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdprd() {
        $req = Yii::$app->request;

        $tgl = $req->post('tgl');
        $bln = $req->post('bulan');
        $thn = $req->post('tahun');
        $pid = $req->post('pid');
        $cusid = $req->post('cusid');

        $model = $this->findModelM($tgl, $pid, $cusid);

        if (Yii::$app->request->post()) {

            $model->JamMasuk = $req->post('masuk');
            $model->JamKeluar = $req->post('keluar');
            $model->UserUpdate = Yii::$app->user->getId();
            $model->DateUpdate = date('Y-m-d h:i:s');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->redirect("./index.php?r=eprocess/jadwal-absensi-status-h/editp&pid=" . $pid . "&tgl=" . $tgl . "&cusid=" . $cusid . "&tahun=" . $thn . "&bulan=" . $bln);
        }
    }

    public function actionDtl() {
        $searchModel = new AbsensiCustomerSearch();

        $idCus  = Yii::$app->request->get('idCus','xx');
        $areaid = Yii::$app->request->get('area','xx');
        $bulan  = Yii::$app->request->get('bulan','xx');
        $tahun  = Yii::$app->request->get('tahun','xx');

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

        $jdwl = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchProd($jdwl);

        return $this->render('detail', [
                    'cus' => $cus,
                    'StartAbsen' => ($cus[0]['StartAbsen'] =='01') ? date($tahun.'-'.$bulan.'-01') 
                                : date($tahun.'-'.substr('0'.($bulan-1), strlen('0'.($bulan-1))-2).'-'.$cus[0]['StartAbsen']),
                    'EndAbsen' => ($cus[0]['StartAbsen'] =='01') ? date($tahun.'-'.$bulan.'-t') 
                                : date($tahun.'-'.$bulan.'-'.$cus[0]['EndAbsen']),
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionProduct() {
        $sodid = Yii::$app->request->get('sodid','xx');
        $sqid = Yii::$app->request->get('sqid','xx');
        $period = Yii::$app->request->get('period','xx');

        $cmd = Yii::$app->db->createCommand("exec GenerateAbsenVerifikasi @SODID='$sodid',@SeqProd=$sqid,@periode='$period'")->queryAll();
        // $cmd->bindParam(':sodid', $sodid);
        // $cmd->bindParam(':sqprod', $sqid);
        // $cmd->bindParam(':period', $period);
        // $cmd->queryAll();

        // echo var_dump($cmd);

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $cmd,
            'pagination' => ['pageSize' => 50],
        ]);

        return $this->render('editproduct', [
                    'dataProvider' => $provider,
        ]);

        // $end = Yii::$app->request->get('end','xx');
        

        // $cmd = Yii::$app->db->createCommand("exec GenerateDummyAbsenGS 'MCSO15090004','201609'")->queryAll();

        // $dataProvider = new \yii\data\ArrayDataProvider([
        //     'allModels' => $cmd,
        //     'pagination' => ['pagesize' => 32]
        // ]);
        // $models = $dataProvider->getModels();
        // $datax = Yii::$app->request->post('AbsensiCustomer');
        // $tr = Yii::$app->db->beginTransaction();
        // try {
        //     if (Yii::$app->getRequest()->isPost) {
        //         $count = 0;
        //         foreach ($datax as $index => $item) {
                    
        //             if($item['JamKeluar'] < '06:00')
        //             {
        //                 $tglJamOut = date('Y-m-d',strtotime($item['Tgl'] . ' +1 day'));
                        
        //             } else {
        //                 $tglJamOut = $item['Tgl'];
        //             }
                    
        //             $tgl = $item['Tgl'];
        //             $newModel = $this->findModel($pid,$rqid,$tgl);
        //             if (!$newModel->isNewRecord) {
        //                 $newModel->SODID = $pid;
        //                 $newModel->SeqProduct = $rqid;
        //                 $newModel->Tgl = $tgl;
        //                 $newModel->Status = $item['Status'];
        //                 $newModel->JamMasuk = $tgl . ' ' . $item['JamMasuk'];
        //                 $newModel->JamKeluar = $tglJamOut .' '. $item['JamKeluar'];
        //                 $newModel->save();
        //                 $count++;
        //             }
        //         }
        //         $tr->commit();
        //         Yii::$app->session->setFlash('success', "berhasil simpan data dengan {$count} record");
        //         return $this->redirect($alamatsblm);
        //     }

        // } catch (Exception $ex) {
        //     Yii::$app->session->setFlash('error', 'Gagal Simpan Data <br>' . $ex->errorInfo[2]);
        //     $tr->rollBack();
        // } catch (\yii\db\Exception $ex) {
        //     Yii::$app->getSession()->setFlash('error', 'Gagal Simpan Data <br>' . $ex->errorInfo[2]);
        //     $tr->rollBack();
        // }
        
        // return $this->render('editproduct', [
        //             'dataProvider' => $dataProvider,
        //             // 'model' => $models,
        //             // 'SODID' => $sodid,
        //             // 'cus' => $cus,
        //             // 'area' => $area,
        //             // 'start' => $start,
        //             // 'end' => $end
        // ]);
    }

    public function actionCloseAbsenPerCustomer() {
//        echo var_dump(Yii::$app->request->post());

        $tahun = Yii::$app->request->post('tahun', date('o'));
        $bulan = Yii::$app->request->post('bulan', date('m'));

        $usercrt = Yii::$app->user->identity->username;
        $tglcrt = date('Y-m-d H:i:s');

        if (Yii::$app->request->post('selection_all', 'x') == '1') {
            Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N' exec CloseAbsenPerCustomerAll @thn,@bln,@usercrt,@tglcrt',
                    N'@thn varchar(4),
                    @bln varchar(2),
                    @usercrt varchar(50),
                    @tglcrt datetime', 
                    '$tahun','$bulan','$usercrt','$tglcrt'
                    ")->execute();
        } else {
            foreach (Yii::$app->request->post('selection') as $valdata) {
                Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N' exec CloseAbsenPerCustomer @idjadwal,@usercrt,@tglcrt',
                    N'@idjadwal varchar(13),
                    @usercrt varchar(50),
                    @tglcrt datetime', 
                    '$valdata','$usercrt','$tglcrt'
                    ")->execute();
            }
        }
//        die();
        return $this->redirect(['index']);
    }

    public function actionSaveproduct($prid) {

        $request = Yii::$app->request;
        $status = $request->post('Status');
        $jammasuk = $request->post('JamMasuk');
        $jamkeluar = $request->post('JamKeluar');
        $countRow = count($request->post('Status'));
        $tgl = $request->post('Tgl');

        if ($request->post()) {
            for ($i = 0; $i < $countRow; $i++) {

                $model = AbsensiCustomer::find()->where(['ProductID' => $prid, 'Tgl' => $tgl[$i]])->one();

                $model->Status = $status[$i];
                $model->JamMasuk = $jammasuk[$i];
                $model->JamKeluar = $jamkeluar[$i];
                $model->UserUpdate = Yii::$app->user->getId();
                $model->DateUpdate = date('Y-m-d h:i:s');
                $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['index']);
        }
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

    protected function findModel($pid,$rqid,$ehem) {
        if (($model = AbsensiCustomer::findOne(['SODID' => $pid , 'SeqProduct' => $rqid,
            'Tgl' =>$ehem
                ])) !== null) {
            return $model;
        } else {
            $newModel = new AbsensiCustomer();
            return $newModel;
        }
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
    
    public function actionPrintOtAll($idjadwal){
        
        $findjadwal = Yii::$app->db->createCommand("
            select SODID,SeqProductID from JadwalAbsensiStatusH jh
            left join JadwalAbsensiStatusD jd on jd.IDJadwalAbsensiStatusH = jh.IDJadwalAbsensiStatusH
            where jh.IDJadwalAbsensiStatusH = '".$idjadwal."'")->queryOne();
        
        $getDataMP = Yii::$app->db->createCommand("
        select * from OTProductAmount otp
            left join JadwalGolive jg on jg.SODID = otp.SODID and jg.SeqProduct = otp.SeqProduct
            left join AbsensiCustomer ac on ac.SODID = otp.SODID and ac.SeqProduct = otp.SeqProduct and otp.tgl = ac.Tgl
        where  otp.SODID  = '".$findjadwal['SODID']."' and otp.SeqProduct = '".$findjadwal['SeqProductID']."'")->queryAll();
        
        if(count($getDataMP) <= 0)
        {
             echo Yii::$app->getSession()->setFlash('error', 'OT Product Kosong');
             return $this->redirect(Yii::$app->request->referrer); 
        }
        
        
        ob_end_clean();
        return $this->render('exportot',['idjadwal' => $idjadwal]); 
    }
    
    public function actionPrintOtPartial($idarr)
    {
        $newarr = json_decode($idarr);
        ob_end_clean();
        return $this->render('exportotpart',['idsodid' => $newarr]); 

    }
}

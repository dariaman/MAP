<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\SOD;
use app\operational\models\CostCalcOutstanding;
use app\operational\models\SODSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SODController extends Controller {

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

    public function actionIndex() {
        $searchModel = new SODSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($soidh) {
        $model = new SOD();

        if ($model->load(Yii::$app->request->post())) {
            
            $ofif = Yii::$app->request->post('off-id');
            $qty = $model->Qty;
            $periodFrom = $model->PeriodFrom;
            $periodTo = $model->PeriodTo;
            
            if ($model->PeriodFrom > $model->PeriodTo) {
                throw new \yii\db\Exception('SO Date tidak boleh lebih besar dari PO Date');
            }
            
            if ($model->Qty <= 0) {
                throw new \yii\db\Exception('QTY harus lebih besar dari nol');
            }
            
            try {
                
                $exec = Yii::$app->db->createCommand("exec InsertSOD @SOIDH = :soidh,@OffdID = :offid,
                        @qty = :qty,@periodFrom = :periodfrom,@periodTo = :periodto");
                $exec->bindParam(':soidh', $soidh);
                $exec->bindParam(':offid', $ofif);
                $exec->bindParam(':qty', $qty);
                $exec->bindParam(':periodfrom', $periodFrom);
                $exec->bindParam(':periodto', $periodTo);
                $exec->execute();
                
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                return $this->redirect(Yii::$app->request->referrer);
                
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('_form', [
                        'model' => $model,
                        'soidh' => $soidh,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->SODID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelcon($SODID, $SOIDH) {
        $tr = Yii::$app->db->beginTransaction();

        $getStatusSOH = Yii::$app->db->createCommand("select Status from SOH where SOIDH = '" . $SOIDH . "'")->queryScalar();
        $getStatusSOD = Yii::$app->db->createCommand("select Status from SOD where SODID = '" . $SODID . "'")->queryScalar();

        if ($getStatusSOD != 'A' and $getStatusSOH != 'A') {
            try {

                //Yii::$app->db->createCommand("delete SOCostCalc where SODID='$SODID'")->execute();
                Yii::$app->db->createCommand("delete SOD where SODID='$SODID'")->execute();

                $tr->commit();
                Yii::$app->getSession()->setFlash('success', 'SOD berhasil dihapus');
            } catch (\yii\db\Exception $ex) {
                $tr->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
        }

        return $this->redirect(['create', 'soidh' => $SOIDH]);
    }

    protected function findModeladd($getid) {
        if (($model = \app\operational\models\GoLiveProduct::findOne($getid)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id) {
        if (($model = SOD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException("SOD dengan ID='$id', tidak ditemukan");
        }
    }

    protected function findModelJadwalGL($id, $seqprod) {
        if (($modelJadwal = \app\operational\models\JadwalGolive::find()->where(['SODID' => $id, 'SeqProduct' => $seqprod])->one()) !== null) {
            return $modelJadwal;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSOC($id) {
        if (($model = CostCalcOutstanding::find()->where(['OfferingDID' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInsertDelete($id, $idsoh) {
        $pic = Yii::$app->user->identity->username;

        $querydelsoc = Yii::$app->db->createCommand("Exec InsertSOCostcalOutstanding @sod = :sod, @pic = :pic ");
        $querydelsoc->bindParam(':sod', $id);
        $querydelsoc->bindParam(':pic', $pic);
        $querydelsoc->execute();

        return $this->redirect(['s-o-d/change-so', 'id' => $id, 'idsoh' => $idsoh]);
    }

    public function actionViewreq($ofd) {
        $model = $this->findModelSOC($ofd);
        return $this->render('viewreq', ['model' => $model]);

    }

    public function actionViewDetailSo($soidh) {
        $model = new SOD();
        return $this->render('_viewso', [
                    'model' => $model,
                    'soidh' => $soidh,
        ]);
    }
    public function actionViewSeqpro($sodid,$seqid) {
        $model = $this->findModelGoliveHistory($seqid, $sodid);
        return $this->render('view-seqpro', [
                    'seqid' => $seqid,
                    'soidh' => $sodid
        ]);
    }
    


    public function actionViewCoscal() {
        $SODID = Yii::$app->request->get('SODID', 'xxx');
        $SOIDH = Yii::$app->request->get('SOIDH', 'xxx');
        $area = Yii::$app->request->get('area', 'xxx');
        $class = Yii::$app->request->get('class', 'xxx');
        $PeriodFrom = Yii::$app->request->get('PeriodFrom', 'xxx');
        $PeriodTo = Yii::$app->request->get('PeriodTo', 'xxx');
        return $this->render('_viewcostcal', [
                    'SODID' => $SODID,
                    'SOIDH' => $SOIDH,
                    'area' => $area,
                    'class' => $class,
                    'PeriodFrom' => $PeriodFrom,
                    'PeriodTo' => $PeriodTo
        ]);
    }
    
    public function actionViewCoscalEndContract() {
        $SODID = Yii::$app->request->get('SODID', 'xxx');
        $SOIDH = Yii::$app->request->get('SOIDH', 'xxx');
        $area = Yii::$app->request->get('area', 'xxx');
        $class = Yii::$app->request->get('class', 'xxx');
        $PeriodFrom = Yii::$app->request->get('PeriodFrom', 'xxx');
        $PeriodTo = Yii::$app->request->get('PeriodTo', 'xxx');
        return $this->render('_viewcostcalendcontract', [
                    'SODID' => $SODID,
                    'SOIDH' => $SOIDH,
                    'area' => $area,
                    'class' => $class,
                    'PeriodFrom' => $PeriodFrom,
                    'PeriodTo' => $PeriodTo
        ]);
    }

    public function actionChangeSo($id) {
    $model = new \app\operational\models\SOH();
    $model = $this->findModelWithSOH($id);
   
            if ($model->StatusCoscal == 'RFA' or $model->StatusCoscal == 'REC' or $model->Status == 'REC' or $model->Status == 'EC'){
                Yii::$app->getSession()->setFlash('error','SOD tidak dapat di Change Cost Cal, Mungkin status SO Detail sedang "Request End Contract/End Contract" atau Status Cost Calc sedang "Request For Approval". Coba Halaman web List SOD Detail di refresh atau tekan F5');
                return $this->redirect(['create', 'soidh' => $model->SOIDH]);             
            } 
        return $this->render('changeso');
    }
    
    public function actionChangeQty() {
        return $this->render('changeqty');
    }
    
    
    public function actionChangeSoCc() {
        
        
        if (Yii::$app->request->post()) {
            $userid = Yii::$app->user->identity->username;
            $period = Yii::$app->request->post('tahun') . Yii::$app->request->post('bulan');
            $sodid = Yii::$app->request->post('idsod');
            $idSOH = Yii::$app->request->post('idsoh');
            $ofd = Yii::$app->request->post('ofd');
            $ump = Yii::$app->request->post('ump');
                        
            try {
                $CountFeePost = 0;
                if (Yii::$app->request->post()) {
                    foreach (Yii::$app->request->post('coscal') as $BiayaID => $item) {
                        
                        $modelCoscalOut = new CostCalcOutstanding();
                        if(!isset($item['amount'])){
                            $item['amount'] = 0;
                        }
                        
                        if ($BiayaID == 'M1000001') {
                            if ($item['amount'] <= 0) {
                                throw new \yii\db\Exception('Management Fee harus lebih besar dari nol');
                            }
                        }
                        if ($BiayaID == 'BPJS0001' OR $BiayaID == 'BPJS0001' OR $BiayaID == 'BPJS0002' OR $BiayaID == 'BPJS0003' OR $BiayaID == 'BPJS0004' OR $BiayaID == 'BPJS0005') {
                            if ($item['amount'] > 50) {
                                throw new \yii\db\Exception('BPJS tidak boleh lebih besar dari 50%');
                            }
                        }
                        if ($BiayaID == 'GP000001') {
                            if ($item['amount'] <= 0) {
                                throw new \yii\db\Exception('Gaji Pokok harus lebih besar dari nol');
                            }
                        }
                        if ($BiayaID == 'UMP00001') {
                            if ($ump <= 0) {
                                throw new \yii\db\Exception('UMP harus lebih besar dari nol');
                            } else {
                                $item['amount'] = $ump;
                            }
                        }
                        if ($BiayaID == 'M1000001') {
                            if ($item['amount'] > 50) {
                                throw new \yii\db\Exception('Management Fee tidak boleh lebih besar dari 50%');
                            }
                        }
                        if ($BiayaID == 'M5000001') {
                            if ($item['amount'] > 50) {
                                throw new \yii\db\Exception('Management Fee Overtime tidak boleh lebih besar dari 50%');
                            }
                        }
                                                
                        if (isset($item['ismfee'])) {
                            $modelCoscalOut->IsManagementFee = $item['ismfee'];
                            $CountFeePost++;
                        } else {
                            $modelCoscalOut->IsManagementFee = null;
                        }

                        $modelCoscalOut->OfferingDID = $ofd;
                        $modelCoscalOut->BiayaID = $BiayaID;
                        $modelCoscalOut->Amount = $item['amount'];
                        $modelCoscalOut->DateCrt = new \yii\db\Expression('getdate()');
                        $modelCoscalOut->UserCrt = Yii::$app->user->identity->username;
//                        $modelCoscalOut->Remark = ($item['remark'] == '') ? new \yii\db\Expression('NULL') : $item['remark'];
//                        $modelCoscalOut->Time = (isset($item['time']) ? $item['time'] : new \yii\db\Expression('NULL') );
//                        $modelCoscalOut->TipeTagihan = (isset($item['tipetagihan']) ? $item['tipetagihan'] : new \yii\db\Expression('NULL') );
                        Yii::$app->db->createCommand("exec RequestChangeCostCalc '$ofd','$sodid','$period','$userid'")->execute();
                        $modelCoscalOut->save();
                    }
                    if ($CountFeePost <= 0) {
                        throw new \yii\db\Exception('Harus memilih management fee minimal 1');
                    } else {
                        Yii::$app->getSession()->setFlash('success', 'Change SO Costcal Successfully');
                        return $this->render('viewreq', ['id' => $sodid, 'idsoh' => $idSOH,'ofd' => $ofd]);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('info', 'Tidak masuk POST');
                }
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->getMessage());
            }
            return $this->redirect(['create', 'soidh' => $idSOH]);

        }
    }
    
    public function actionDelSlot($seqid,$sodid,$soidh) {       
        $misscom = $this->findModelDelSlot($seqid,$sodid);

        if ($misscom->Status == 'RFA' or $misscom->Status == 'A' ){
            throw new NotFoundHttpException('Product tidak dapat di hapus, Mungkin status sedang status RFA atau sudah Approve. Coba Halaman web GoLive Product di refresh atau tekan F5');
        }
        
            $pic = Yii::$app->user->identity->username;
        
            try {
            Yii::$app->db->createCommand("exec RequestChangeQtySo @sodid='$sodid', @seqid = $seqid, @pic= '$pic'")->execute();
                if (Yii::$app->request->post()) {
                        Yii::$app->getSession()->setFlash('success', 'Request for change Quantity Successfull ');
                    }
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
            return $this->redirect(['s-o-d/detailsod', 'soh' => $soidh,'did' => $sodid]);
        }

    public function actionGetCorrection($id, $idsoh) {
        $pic = Yii::$app->user->identity->username;
        
        $sql = Yii::$app->db->createCommand("exec [CorrectionSOCostCalc]  @getid = :getid, @pic = :pic, @soh = :soh");
        $sql->bindValue(':getid', $id);
        $sql->bindValue(':soh', $idsoh);
        $sql->bindValue(':pic',$pic);
        $sql->execute();
        return $this->redirect(['s-o-d/create', 'soidh' => $idsoh]);
    }

    public function actionDetailsod($did, $soh) {
        $model = $this->findModelWithSOH($did);
        $modelJadwal = new \app\operational\models\JadwalGolive();
        $modelGoLive = new \app\operational\models\GoLiveProduct();
        $request = Yii::$app->request;
        
        
        if ($modelGoLive->load(Yii::$app->request->post()) AND $modelJadwal->load(Yii::$app->request->post())) {
            $getid = Yii::$app->db->createCommand("SELECT GoLiveID = 'GL'
                    +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('000000000000'+CONVERT(varchar(12), cast(ISNULL(max(RIGHT(GoLiveID,12)),0) as bigint) +1), 12)
                    FROM GoLiveProduct where SUBSTRING(GoLiveID,3,6)=left(convert(varchar,getdate(),112),6)")->queryScalar();

            $idsodid = $request->post('idsodid');
            $periodfrom = $request->post('periodfrom');
            $periodto = $request->post('periodto');
            $productid = Yii::$app->request->post('prod-id-gs');
            $userid = Yii::$app->user->identity->username;
            $areadetil = $modelGoLive->AreaDetailDesc;
            $licenseplate = $modelGoLive->LicensePlate;
            $shift = $modelGoLive->IsShift;
            $tr = Yii::$app->db->beginTransaction();
            try {
                $queryexec = Yii::$app->db->createCommand("Exec InsertDetailSOD @goliveid = :goliveid, @sod=:sod, @from=:from, @to=:to, @product=:product,@user=:user, @shift=:shift,@areadetail=:areadetail,@licenseplate=:licenseplate");
                $queryexec->bindParam(":goliveid", $getid);
                $queryexec->bindParam(":sod", $idsodid);
                $queryexec->bindParam(":from", $periodfrom);
                $queryexec->bindParam(":to", $periodto);
                $queryexec->bindParam(":product", $productid);
                $queryexec->bindParam(":user", $userid);
                $queryexec->bindParam(":shift", $shift);
                $queryexec->bindParam(":areadetail", $areadetil);
                $queryexec->bindParam(":licenseplate", $licenseplate);
                $queryexec->execute();

                $seq = Yii::$app->db->createCommand("select isnull(max(SeqProduct),0)+1 from JadwalGoLive where SODID ='" . $idsodid . "'")->queryScalar();

                $countCheck = 7;

                $h1 = Yii::$app->request->post('H1');
                $h2 = Yii::$app->request->post('H2');
                $h3 = Yii::$app->request->post('H3');
                $h4 = Yii::$app->request->post('H4');
                $h5 = Yii::$app->request->post('H5');
                $h6 = Yii::$app->request->post('H6');
                $h7 = Yii::$app->request->post('H7');

                IF ($h1 == '' AND $h2 == '' AND $h3 == '' AND $h4 == '' AND $h5 == '' AND $h6 == '' AND $h7 == '') {
                    $tr->rollback();
                    throw new \yii\db\Exception('Harus memilih jadwal minimal 1');
                } else {

                    if ($h1 == '') {
                        $modelJadwal->Monday1 = NULL;
                        $modelJadwal->Monday2 = NULL;
                    } else {
                        $modelJadwal->Monday1;
                        $modelJadwal->Monday2;
                    }

                    if ($h2 == '') {
                        $modelJadwal->Tuesday1 = NULL;
                        $modelJadwal->Tuesday2 = NULL;
                    } else {
                        $modelJadwal->Tuesday1;
                        $modelJadwal->Tuesday2;
                    }

                    if ($h3 == '') {
                        $modelJadwal->Wednesday1 = NULL;
                        $modelJadwal->Wednesday2 = NULL;
                    } else {
                        $modelJadwal->Wednesday1;
                        $modelJadwal->Wednesday2;
                    }

                    if ($h4 == '') {
                        $modelJadwal->Thursday1 = NULL;
                        $modelJadwal->Thursday2 = NULL;
                    } else {
                        $modelJadwal->Thursday1;
                        $modelJadwal->Thursday2;
                    }

                    if ($h5 == '') {
                        $modelJadwal->Friday1 = NULL;
                        $modelJadwal->Friday2 = NULL;
                    } else {
                        $modelJadwal->Friday1;
                        $modelJadwal->Friday2;
                    }

                    if ($h6 == '') {
                        $modelJadwal->Saturday1 = NULL;
                        $modelJadwal->Saturday2 = NULL;
                    } else {
                        $modelJadwal->Saturday1;
                        $modelJadwal->Saturday2;
                    }

                    if ($h7 == '') {
                        $modelJadwal->Sunday1 = NULL;
                        $modelJadwal->Sunday2 = NULL;
                    } else {
                        $modelJadwal->Sunday1;
                        $modelJadwal->Sunday2;
                    }
                    $modelJadwal->SODID = $idsodid;
                    $modelJadwal->SeqProduct = $seq;
                    $modelJadwal->save();
                    $tr->commit();
                }
                Yii::$app->session->setFlash('success', 'Data  berhasil disimpan');
                return $this->render('detailsod', ['model' => $model]);
            } catch (\yii\db\Exception $ex) {
                $tr->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->render('detailsod', ['model' => $model]);
            }
        } else {
            return $this->render('detailsod', ['model' => $model]);
        }
    }

    public function actionViewMp($did, $soh) {
        $model = $this->findModelWithSOH($did);
        $modelJadwal = new \app\operational\models\JadwalGolive();
        $modelGoLive = new \app\operational\models\GoLiveProduct();
        $request = Yii::$app->request;

        if ($modelGoLive->load(Yii::$app->request->post()) AND $modelJadwal->load(Yii::$app->request->post())) {
            $getid = Yii::$app->db->createCommand("SELECT GoLiveID = 'GL'
                    +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('000000000000'+CONVERT(varchar(12), cast(ISNULL(max(RIGHT(GoLiveID,12)),0) as bigint) +1), 12)
                    FROM GoLiveProduct where SUBSTRING(GoLiveID,3,6)=left(convert(varchar,getdate(),112),6)")->queryScalar();

            $idsoh = $request->post('idsoh');
            $idsodid = $request->post('idsodid');
            $periodfrom = $request->post('periodfrom');
            $periodto = $request->post('periodto');
            $productid = $modelGoLive->ProductID;
            $userid = Yii::$app->user->identity->username;
            $areadetil = $modelGoLive->AreaDetailDesc;
            $licenseplate = $modelGoLive->LicensePlate;
            $shift = $modelGoLive->IsShift;
            $tr = Yii::$app->db->beginTransaction();
            try {
                $queryexec = Yii::$app->db->createCommand("Exec InsertDetailSOD @goliveid = :goliveid, @sod=:sod, @from=:from, @to=:to, @product=:product,@user=:user, @shift=:shift,@areadetail=:areadetail,@licenseplate=:licenseplate");
                $queryexec->bindParam(":goliveid", $getid);
                //            $queryexec->bindParam(":soh", $idsoh);
                $queryexec->bindParam(":sod", $idsodid);
                $queryexec->bindParam(":from", $periodfrom);
                $queryexec->bindParam(":to", $periodto);
                $queryexec->bindParam(":product", $productid);
                $queryexec->bindParam(":user", $userid);
                $queryexec->bindParam(":shift", $shift);
                $queryexec->bindParam(":areadetail", $areadetil);
                $queryexec->bindParam(":licenseplate", $licenseplate);
                $queryexec->execute();

                $seq = Yii::$app->db->createCommand("select isnull(max(SeqProduct),0)+1 from JadwalGoLive where SODID ='" . $idsodid . "'")->queryScalar();

                $modelJadwal->SODID = $idsodid;
                $modelJadwal->SeqProduct = $seq;
                $modelJadwal->save();
                $tr->commit();
                Yii::$app->session->setFlash('success', 'Data  berhasil disimpan');
                return $this->render('detailsod', ['model' => $model]);
            } catch (\yii\db\Exception $ex) {
                $tr->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->render('view-mp', ['model' => $model]);
            }
        } else {
            return $this->render('view-mp', ['model' => $model]);
        }
    }

    public function actionGoLiveRfa($sodid, $soidh) {
        try {
            $sqlstring = "if exists (select '' from GoLiveProduct where SODID = '" . $sodid . "' and Status NOT IN ('D','C'))
                            select 'SO tersebut tidak dalam status Draft, tidak dapat diajukan RFA'
                        else if not exists( select '' from GoLiveProduct where SODID = '" . $sodid . "')
                            select 'SO yang diajukan tidak memiliki item Go Live detail' 
                        else if exists( select '' from TransactionMaster where TransID='" . $sodid . "')
                            select 'SO sudah dalam proses RFA'
                        else select 'OK' ";
            $pic = Yii::$app->user->identity->username;
            $cmd = Yii::$app->db->createCommand($sqlstring)->queryScalar();
            if ($cmd == 'OK') {
                $sqlstring = 'exec RequestAllocationProduct @sodid=:sodid, @pic=:user';
                $cmd = Yii::$app->db->createCommand($sqlstring);
                $cmd->bindParam(':sodid', $sodid);
//                $cmd->bindParam(':soidh', $soidh);
                $cmd->bindParam(':user', $pic);
                $cmd->execute();

                Yii::$app->getSession()->setFlash('success', ' Berhasil RFA');
                return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $soidh]);
            } else {
                Yii::$app->getSession()->setFlash('error', $cmd);
                return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $soidh]);
            }
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $soidh]);
        }
    }

    public function actionEt($seqid, $sodid) {
        try {
            $sqlstring = 'exec RequestET @seqid=:seqid,@sodid=:sodid,@pic=:pic';
            $exec = Yii::$app->db->createCommand($sqlstring);
            $exec->bindParam(':seqid', $seqid);
            $exec->bindParam(':sodid', $sodid);
            $exec->bindParam(':pic', Yii::$app->user->identity->username);
            $exec->execute();

            Yii::$app->getSession()->setFlash('success', ' Berhasil RFA');
            return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
        }
    }

    public function actionRequestEt($sohid, $seqid, $sodid, $id) {
        $modelgl = new \app\operational\models\GoLiveProduct();
        
        $model = $this->findModelGL($id);
                
        if ($model->Status !='A'){
            Yii::$app->getSession()->setFlash('error','Product tidak dapat di Request Early Terminate, Status sedang RFA atau sudah terminate');
            return $this->redirect(['detailsod', 'did' => $model->SODID, 'soh' => $model->GoLiveID]);    
        }

        if ($model->load(Yii::$app->request->post()) AND $modelgl->load(Yii::$app->request->post())) {
            $period = $modelgl->PeriodTo;
            $periodto = Yii::$app->request->post('periodto');
            $periodfrom = Yii::$app->request->post('periodfrom');
                        
            if($period < $periodfrom)
            {
                Yii::$app->getSession()->setFlash('error','Periode efektif tidak bisa sebelum tanggal mulai tugas product');
                return $this->redirect(['request-et', 'id' => $id, 'sohid' => $sohid,'seqid' => $seqid,'sodid'=>$sodid]);
            } else if ($period > $periodto) {
                Yii::$app->getSession()->setFlash('error','Periode efektif tidak bisa melebihi tanggal SO berakhir');
                return $this->redirect(['request-et', 'id' => $id, 'sohid' => $sohid,'seqid' => $seqid,'sodid'=>$sodid]);
            } else {
                $pic = Yii::$app->user->identity->username;
                try {
                    $sqlstring = 'exec RequestET @id = :id ,@sod = :sod,  @seqid = :seqid, @pic = :pic, @periodto=:periodto';
                    $exec = Yii::$app->db->createCommand($sqlstring);
                    $exec->bindParam(':periodto', $period);
                    $exec->bindParam(':id', $id);
                    $exec->bindParam(':sod', $sodid);
                    $exec->bindParam(':seqid', $seqid);
                    $exec->bindParam(':pic', $pic);
                    $exec->execute();

                    Yii::$app->getSession()->setFlash('success', ' Berhasil Request ET');
                    return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
                } catch (\yii\db\Exception $ex) {
                    Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                    return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
                }
            }
        } else {
            return $this->render('request-et', ['id' => $id, 'seqid' => $seqid, 'sohid' => $sohid, 'sodid' => $sodid]);
        }
    }

    public function actionAddProducttt($seqid, $sodid) {
        // Action Create data baru dan hapus / pindah data lama ke tabel histori
        $modelGoLive = new \app\operational\models\GoLiveProduct;
        
        $model = $this->findModelWithSOH($sodid);
        $request = Yii::$app->request;
               
        $modelx = $this->findModelWithGo($sodid, $seqid);
        if($modelx->Status == 'A' or $modelx->Status == 'RFA' ){           
            Yii::$app->getSession()->setFlash('error',"Product sudah terdapat Go Live Product untuk Sequence Product   $seqid");
            return $this->redirect(['detailsod', 'did' => $model->SODID, 'soh' => $model->SOIDH]);              
        }
        
        if (Yii::$app->request->Ispost){
            //$modelJadwal->load(Yii::$app->request->post()) and $modelGoLive->load(Yii::$app->request->post())) {
            $modelJadwal = $this->findModelJadwal($sodid,$seqid);

            $perid = Yii::$app->request->post('SOD');
            $periodto = Yii::$app->request->post('periodtosod');
            $periodfrom = Yii::$app->request->post('periodfromsod');
            $periodtogl = Yii::$app->request->post('periodtogl');
            $effectivedate = $perid['PeriodFrom'];
            $jadwal = Yii::$app->request->post('JadwalGolive');
            $totime2 = strtotime($periodto);

            // echo var_dump($modelJadwal);
            // die();
            
            
            try {
                $idsoh = $request->post('idsoh');
                $idsodid = $request->post('idsodid');
                $periodfrom =  $request->post('PeriodFrom');
                $seqprod = $request->post('SeqProduct');
                $productid = Yii::$app->request->post('prod-id-gs');
                $userid = Yii::$app->user->identity->username;
                $areadetil = $modelGoLive->AreaDetailDesc;
                $licenseplate = $modelGoLive->LicensePlate;
                $shift = $modelGoLive->IsShift;
                
                 
                $statementsp = "Exec InsertAddProduct @sod=:sod,@seqid=:seqid,@from=:from,@to=:to,@product=:product,@user=:user,@shift=:shift,@areadetail=:areadetail,@licenseplate=:licenseplate";
                $queryexec = Yii::$app->db->createCommand($statementsp);
                $queryexec->bindValue(":sod", $idsodid);
                $queryexec->bindValue(":seqid", $seqprod);
                $queryexec->bindValue(":from", $effectivedate);
                $queryexec->bindValue(":to", $periodto);
                $queryexec->bindValue(":product", $productid);
                $queryexec->bindValue(":user", $userid);
                $queryexec->bindValue(":shift", $shift);
                $queryexec->bindValue(":areadetail", $areadetil);
                $queryexec->bindValue(":licenseplate", $licenseplate);
                $queryexec->execute();
                
                if($request->post('H1')=='1'){
                    $modelJadwal->Monday1 = $jadwal['Monday1'];
                    $modelJadwal->Monday2 = $jadwal['Monday2'];
                }else{
                    $modelJadwal->Monday1 = null;
                    $modelJadwal->Monday2 = null;
                }

                if($request->post('H2')=='1'){
                    $modelJadwal->Tuesday1 = $jadwal['Tuesday1'];
                    $modelJadwal->Tuesday2 = $jadwal['Tuesday2'];
                }else{
                    $modelJadwal->Tuesday1 = null;
                    $modelJadwal->Tuesday2 = null;
                }

                if($request->post('H3')=='1'){
                    $modelJadwal->Wednesday1 = $jadwal['Wednesday1'];
                    $modelJadwal->Wednesday2 = $jadwal['Wednesday2'];
                }else{
                    $modelJadwal->Wednesday1 = null;
                    $modelJadwal->Wednesday2 = null;
                }

                if($request->post('H4')=='1'){
                    $modelJadwal->Thursday1 = $jadwal['Thursday1'];
                    $modelJadwal->Thursday2 = $jadwal['Thursday2'];
                }else{
                    $modelJadwal->Thursday1 = null;
                    $modelJadwal->Thursday2 = null;
                }

                if($request->post('H5')=='1'){
                    $modelJadwal->Friday1 = $jadwal['Friday1'];
                    $modelJadwal->Friday2 = $jadwal['Friday2'];
                }else{
                    $modelJadwal->Friday1 = null;
                    $modelJadwal->Friday2 = null;
                }

                if($request->post('H6')=='1'){
                    $modelJadwal->Saturday1 = $jadwal['Saturday1'];
                    $modelJadwal->Saturday2 = $jadwal['Saturday2'];
                }else{
                    $modelJadwal->Saturday1 = null;
                    $modelJadwal->Saturday2 = null;
                }

                if($request->post('H7')=='1'){
                    $modelJadwal->Sunday1 = $jadwal['Sunday1'];
                    $modelJadwal->Sunday2 = $jadwal['Sunday2'];
                }else{
                    $modelJadwal->Sunday1 = null;
                    $modelJadwal->Sunday2 = null;
                }
                $modelJadwal->save();

                Yii::$app->session->setFlash('success', 'Data  berhasil disimpan');
                return $this->render('detailsod', ['model' => $model]);
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(['s-o-d/add-producttt',  'seqid' => $modelx->SeqProduct, 'sodid' => $model->SODID]);
            }
        } else {
            return $this->render('request-addproduct', ['model' => $model]);
        }
    }

    public function actionRequestAdd($id, $sohid, $sodid) {
        $model = new \app\operational\models\GoLiveProduct();
        $pic = Yii::$app->user->identity->username;
        
        if ($model->load(Yii::$app->request->post())) {
            $product = $model->ProductID;
            try {
                $sqlstring = 'exec RequestAddProduct @sod = :sod, @soh = :soh, @id = :id,@pic = :pic, @product=:product';
                $exec = Yii::$app->db->createCommand($sqlstring);
                $exec->bindParam(':product', $product);
                $exec->bindParam(':sod', $sodid);
                $exec->bindParam(':soh', $sohid);
                $exec->bindParam(':id', $id);
                $exec->bindParam(':pic', $pic);
                $exec->execute();

                Yii::$app->getSession()->setFlash('success', ' Berhasil RFA');
                return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $sohid]);
            }
        } else {
            return $this->render('request-add', ['glid' => $id, 'sohid' => $sohid, 'sodid' => $sodid]);
        }
    }
    
        public function actionRequestEndContractSod($sodid, $soidh) {
        $model = new \app\operational\models\SOD();
        $model = $this->findModelWithSOH($sodid);
        
        
        if($model->Status == 'REC')
        {           
            Yii::$app->getSession()->setFlash('error', ' Tidak dapat End Contract, mungkin status SO Detail sudah "Request End Contract" atau Status Change Cost Cal sudah "Request for Approval"');;
            return $this->redirect(['create', 'soidh' => $soidh]);
        }
        
            $pic = Yii::$app->user->identity->username;
            try {
                $sqlstring = 'exec ReqEndContractSOD @sodid = :sodid, @pic=:pic';
                $exec = Yii::$app->db->createCommand($sqlstring);
                $exec->bindParam(':sodid', $sodid);
                $exec->bindParam(':pic', $pic);
                $exec->execute();
                                    
                Yii::$app->getSession()->setFlash('success', 'Berhasil Request End Contract');
                return $this->redirect(['create', 'soidh' => $soidh]);
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(['create', 'soidh' => $soidh]);
            }
        }
        
    public function actionChangeProduct($id) {
        $model = new \app\operational\models\GoLiveProduct();
        
        $xProduct = $this->findModelGL($id);
        
        $request = Yii::$app->request;
        $sodid = $request->post('sodid');
        $periodto = $request->post('sod');
        $soidh = $request->post('soidh');
        $productold = $request->post('productold');
        $seqprod = $request->post('seq');
        $product = $request->post('prod-id-gs');
        $fromold = $request->post('fromold');
        $tglkontraksod = $request->post('tglkontraksod');
        
        if ($model->load(Yii::$app->request->post())) {
            $periodfromForm = $model->PeriodFrom;
            
            if($periodfromForm == Null)
            {
                 Yii::$app->getSession()->setFlash('error', 'Tanggal Tugas Pengganti tidak boleh kosong');
               return $this->redirect(['change-product', 'id' => $xProduct->GoLiveID]);    
            }
            
            if ($fromold > $periodfromForm){
               Yii::$app->getSession()->setFlash('error', 'Tanggal tugas Product Pengganti tidak boleh lebih awal bertugas dari Product sebelumnnya');
               return $this->redirect(['change-product', 'id' => $xProduct->GoLiveID]);    
            }
            if ($tglkontraksod > $periodfromForm OR $periodto < $periodfromForm ){
               Yii::$app->getSession()->setFlash('error', "Tanggal kontrak SOD : $tglkontraksod sampai $periodto, sedangkan tgl tugas pengganti : $periodfromForm");
               return $this->redirect(['change-product', 'id' => $xProduct->GoLiveID]);  
            }
            
            try {
                $areadetil = $model->AreaDetailDesc;
                $licenseplate = $model->LicensePlate;
                $pic = Yii::$app->user->identity->username;   
                $shift = $model->IsShift;
                
                $sqlstring = 'exec RequestChangeProduct @sod = :sod, @id = :id,  @product = :product, @productold=:productold, @from=:from,
                        @to = :to, @areadetail=:areadetail, @licenseplate = :licenseplate, @shift = :shift, @seqid=:seqid, @pic= :pic ';
                $exec = Yii::$app->db->createCommand($sqlstring);
                $exec->bindParam(':productold', $productold);
                $exec->bindParam(':product', $product);
                $exec->bindParam(':sod', $sodid);
                $exec->bindParam(":seqid", $seqprod);
                $exec->bindParam(':id', $id);
                $exec->bindParam(":from", $periodfromForm);
                $exec->bindParam(":to", $periodto);
                $exec->bindParam(":shift", $shift);
                $exec->bindParam(":areadetail", $areadetil);
                $exec->bindParam(":licenseplate", $licenseplate);
                $exec->bindParam(':pic', $pic);
                $exec->execute();

                Yii::$app->getSession()->setFlash('success', 'Change Product Succesfully');
                return $this->redirect(['s-o-d/detailsod', 'did' => $sodid, 'soh' => $soidh]);
            } catch (\yii\db\Exception $ex) {
               Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
               return $this->redirect(['s-o-d/change-product', 'id' => $xProduct->GoLiveID]);
            }
        } else {
            return $this->render('changeproduct', [
                        'model' => $this->findModelGL($id),
            ]);
        }
    }

    public function actionViewJadwal($SODID, $SeqProduct) {
        $model = new \app\operational\models\JadwalGolive();
        return $this->render('_viewjadwal', [
                    'model' => $model,
                    'SODID' => $SODID,
                    'SeqProduct' => $SeqProduct,
        ]);
    }

    protected function findModelGL($id) {
        if (($model = \app\operational\models\GoLiveProduct::find()->where(['GoLiveID' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelDelSlot($seqid,$sodid) {
        if (($model = \app\operational\models\GoLiveProduct::find()->where(['SeqProduct' => $seqid,'SODID' => $sodid])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelGoliveHistory($seqid,$sodid) {
        if (($model = \app\operational\models\GoLiveProductHistory::find()->where(['SeqProduct' => $seqid,'SODID' => $sodid])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangeRfa($id, $sodid, $soidh) {

        if ($model->load(Yii::$app->request->post())) {
            
        } else {
            return $this->render('change-product', ['id' => $id]);
        }
    }

    protected function findModelWithSOH($id) {
        if (($model = SOD::find()->where(['SODID' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelWithGo($id, $seqid) {
        if (($model = \app\operational\models\GoLiveProduct::find()->where(['SODID' => $id,'SeqProduct' => $seqid])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelViewDetailSo($soidh) {
        if (($model = SOD::find()->where(['SOIDH' => $soidh])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelJadwal($sodid, $seqid) {
        $model = \app\operational\models\JadwalGolive::find()->where(['SODID' => $sodid,'SeqProduct' => $seqid])->one();
        if ( $model == null) {
            $model = new \app\operational\models\JadwalGolive();
            $model->SODID = $sodid;
            $model->SeqProduct = $seqid;
        }
        return $model;
    }

}

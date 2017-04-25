<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\OfferingD;
use app\operational\models\OfferingDSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OfferingDController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new OfferingDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView() {
        $model = new OfferingD();
        return $this->render('view', [
                    'model' => $model,
                    'OIDH' => $model->OfferingIDH,
        ]);
    }

    public function actionViewofdet() {
        return $this->render('viewofdet');
    }

    public function actionViewCoscal() {
        $OFIH = Yii::$app->request->get('OFIH', NULL);
        $OFID = Yii::$app->request->get('OFID', NULL);
        $area = Yii::$app->request->get('area', NULL);
        $class = Yii::$app->request->get('class', NULL);
        return $this->render('_viewcostcal', [
                    'OFIH' => $OFIH,
                    'OFID' => $OFID,
                    'area' => $area,
                    'class' => $class
        ]);
    }

    public function actionEditCoscal() {

        $OFIH = Yii::$app->request->get('OFIH', 'xxx');
        $OFID = Yii::$app->request->get('OFID', 'xxx');

        return $this->render('_editcostcal', [
                    'OFIH' => $OFIH,
                    'OFID' => $OFID
        ]);
    }

    public function actionSaveEditCoscal() {
        $OfferingIDH = Yii::$app->request->post('OfferingIDH');
        $OfferingDID = Yii::$app->request->post('OfferingDID');
        $class = Yii::$app->request->post('Class');
        $areaid = Yii::$app->request->post('OfferingH')['AreaID'];
        $id = Yii::$app->user->identity->username;
        $tr = Yii::$app->db->beginTransaction();
        try {

            $cariclass = Yii::$app->db->createCommand("
                        Select
                        Class
                        from OfferingD 
                        where OfferingIDH='$OfferingIDH' and OfferingDID !='$OfferingDID'")->queryScalar();
            $cariarea = Yii::$app->db->createCommand("
                        Select
                        AreaID
                        from OfferingD 
                        where OfferingIDH='$OfferingIDH' and OfferingDID !='$OfferingDID'")->queryScalar();
            $carinamaarea = Yii::$app->db->createCommand("
                        Select
                        Description
                        from MasterArea 
                        where AreaID ='$cariarea'")->queryScalar();
            if ($cariclass == $class && $cariarea == $areaid) {
                throw new \yii\db\Exception('Area '.$carinamaarea.' dengan Class ' . $class . ' sudah ada');
            }

            $modelofd = OfferingD::find()->where(['OfferingDID' => $OfferingDID, 'OfferingIDH' => $OfferingIDH])->one();
            $modelofd->AreaID = $areaid;
            $modelofd->Class = $class;
            $modelofd->save();
            $CountFeeModel = \app\operational\models\CosCalc::find()->select(['COUNT(IsManagementFee) AS IsManagementFee'])->where(['OfferingDID' => $OfferingDID, 'IsManagementFee' => 1])->one();
            $CountFeePost = 0;
            foreach (Yii::$app->request->post('coscal') as $BiayaID => $item) {
                
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
                    if ($BiayaID == 'M1000001' OR $BiayaID == 'M5000001') {
                        if ($item['amount'] > 50) {
                            throw new \yii\db\Exception('Management Fee tidak boleh lebih besar dari 50%');
                        }
                    }
                    if ($BiayaID == 'UMP00001' OR $item['amount'] == '') {
                        if ($item['amount'] == NULL) {
                            throw new \yii\db\Exception('UMP kosong, silahkan diperiksa kembali');
                        }
                    }
                    if ($item['amount'] == NULL OR $item['amount'] == '') {
                        throw new \yii\db\Exception('Terdapat amount kosong, silahkan diperiksa kembali');
                    } else if (!is_numeric($item['amount'])) {
                        throw new \yii\db\Exception('Input yang di masukan harus angka');
                    }

                    if (isset($item['ismfee'])) {
                        $CountFeePost++;
                    }
                    
                    $updateCostCalc = "Exec UpdateCostCalc @ofd = '$OfferingDID',".
                                " @biayaid = '$BiayaID', ".
                                "@amount = $item[amount],".
                                ((isset($item['time']))? "@time = '$item[time]',":"" ).
                                ((isset($item['tipetagihan']))? "@tipetagihan = '$item[tipetagihan]',":"" ).
                                "@pic = '$id',".
                                ((isset($item['ismfee']))? "@ismfee = '$item[ismfee]',":"" ).
                                "@remark = '$item[remark]'";
                    $execspCostCalc = Yii::$app->db->createCommand($updateCostCalc);
                    $execspCostCalc->execute();
            }
            
            $insertSumOfferingD = "Exec InsertSummaryOfd @ofh = :ofh, @pic = :pic,@ofd=:ofd";
            $execspsumOfferingD = Yii::$app->db->createCommand($insertSumOfferingD);
            $execspsumOfferingD->bindParam(':ofh', $OfferingIDH);
            $execspsumOfferingD->bindParam(':ofd', $OfferingDID);
            $execspsumOfferingD->bindParam(':pic', $id);
            $execspsumOfferingD->execute();
            
            if ($CountFeePost <= 0) {
                $tr->rollback();
                throw new \yii\db\Exception('Harus memilih management fee minimal 1');
            } else {
                $tr->commit();
            }
            Yii::$app->getSession()->setFlash('success', 'Costcalc Berhasil disimpan');
        } catch (yii\db\Exception $ex) {
            $tr->rollback();
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionInsertCoscal() {
        $model = new \app\operational\models\CosCalc();        
        $tr = Yii::$app->db->beginTransaction();
        try {
            $req = Yii::$app->request->post('model');
            $ofh = Yii::$app->request->post('OfferingIDH');
            $area = Yii::$app->request->post('MasterArea')['AreaID'];
            $class = Yii::$app->request->post('OfferingD')['Class'];
            $cariClass = $this->findModelclass($ofh, $class, $area);
            $id = Yii::$app->user->identity->username;
            if ($cariClass->isNewRecord) {
                $ofdid = Yii::$app->db->createCommand("
                        select 'OFD' + LEFT(convert(varchar,GETDATE(),112),6) + 
                        RIGHT('0000' + convert(varchar,isnull(max(RIGHT(OfferingDID,4)),0)+1),4)
                        from OfferingD where SUBSTRING(OfferingDID,4,6)=LEFT(convert(varchar,GETDATE(),112),6) ")->queryScalar();

                if (Yii::$app->request->post()) {
                    $insertOfferingD = "Exec InsertOfferingD @ofh = :ofh, @area = :area, @class = :class, @pic = :pic,@ofd=:ofd";
                    $execspOfferingD = Yii::$app->db->createCommand($insertOfferingD);
                    $execspOfferingD->bindParam(':ofh', $ofh);
                    $execspOfferingD->bindParam(':ofd', $ofdid);
                    $execspOfferingD->bindParam(':area', $area);
                    $execspOfferingD->bindParam(':class', $class);
                    $execspOfferingD->bindParam(':pic', $id);
                    $execspOfferingD->execute();
                    $CountFee = 0;
                    foreach ($req as $biayaid => $item) {

                        $model = new \app\operational\models\CosCalc();
                        if (isset($item['ismanagementfee'])) {
                            $CountFee++;
                        } 
                  
                        $amount = $item['amount'];
                        $remark = $item['remark'];
                        
                        if ($biayaid == 'M1000001') {
                            if ($amount <= 0) {
                                throw new \yii\db\Exception('Management Fee harus lebih besar dari nol');
                            }
                        }
                        if ($biayaid == 'GP000001') {
                            if ($amount <= 0) {
                                throw new \yii\db\Exception('Gaji Pokok harus lebih besar dari nol');
                            }
                        }
                        if ($biayaid == 'BPJS0001' OR $biayaid == 'BPJS0001' OR $biayaid == 'BPJS0002' OR $biayaid == 'BPJS0003' OR $biayaid == 'BPJS0004' OR $biayaid == 'BPJS0005') {
                            if ($item['amount'] > 50) {
                                throw new \yii\db\Exception('BPJS tidak boleh lebih besar dari 50%');
                            }
                        }
                        if ($biayaid == 'M1000001') {
                            if ($amount > 50) {
                                throw new \yii\db\Exception('Management Fee tidak boleh lebih besar dari 50%');
                            }
                        }
                        if ($biayaid == 'M5000001') {
                            if ($amount > 50) {
                                throw new \yii\db\Exception('Management Fee Overtime tidak boleh lebih besar dari 50%');
                            }
                        }
                        if ($biayaid == 'UMP00001') {
                            if ($amount == NULL) {
                                throw new \yii\db\Exception('UMP kosong, silahkan diperiksa kembali');
                            }
                        }
                        if ($amount == NULL OR $amount == '') {
                            throw new \yii\db\Exception('Terdapat amount kosong, silahkan diperiksa kembali');
                        } else if (!is_numeric($item['amount'])) {
                            throw new \yii\db\Exception('Input yang di masukan harus angka');
                        }
                        
                        $insertCostCalc = "Exec InsertCostCalc @ofd = '$ofdid',".
                                    " @biayaid = '$biayaid', ".
                                    "@amount = $amount,".
                                    ((isset($item['time']))? "@time = '$item[time]',":"" ).
                                    ((isset($item['tipetagihan']))? "@tipetagihan = '$item[tipetagihan]',":"" ).
                                    "@pic = '$id',".
                                    ((isset($item['ismanagementfee']))? "@ismfee = '$item[ismanagementfee]',":"" ).
                                    "@remark = '$remark'";
                        $execspCostCalc = Yii::$app->db->createCommand($insertCostCalc);
                        $execspCostCalc->execute();
                    }
                    
                    $insertSumOfferingD = "Exec InsertSummaryOfd @ofh = :ofh, @pic = :pic,@ofd=:ofd";
                    $execspsumOfferingD = Yii::$app->db->createCommand($insertSumOfferingD);
                    $execspsumOfferingD->bindParam(':ofh', $ofh);
                    $execspsumOfferingD->bindParam(':ofd', $ofdid);
                    $execspsumOfferingD->bindParam(':pic', $id);
                    $execspsumOfferingD->execute();
                    
                    if ($CountFee <= 0) {
                        $tr->rollback();
                        throw new \yii\db\Exception('Harus memilih management fee minimal 1');
                    } else {
                        $tr->commit();
                    }

                    Yii::$app->getSession()->setFlash('success', 'Berhasil disimpan');
                } else {
                    Yii::$app->getSession()->setFlash('info', 'Gagal disimpan');
                }
            } else {
                throw new \yii\db\Exception('Class sudah ada');
            }
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteCoscal($IdOfferingH, $IdOfferingD) {
        $id = Yii::$app->user->identity->username;
        try {
            $sqlstring = 'exec DeleteCostCalc @IdOfferingH=:IdOfferingH,@IdOfferingD=:IdOfferingD,@UserUpdate=:user';
            $cmd = Yii::$app->db->createCommand($sqlstring);
            $cmd->bindParam(':IdOfferingH', $IdOfferingH);
            $cmd->bindParam(':IdOfferingD', $IdOfferingD);
            $cmd->bindParam(':user',$id);
            $cmd->execute();
            Yii::$app->getSession()->setFlash('success', 'Delete CostCalc Berhasil');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreate() {
        $model = new \app\operational\models\CosCalc();
        $ofhmodel = new \app\operational\models\OfferingHSearch();
        if(isset($_GET['IsSO']))
        {
            $sodid = $_GET['SODID'];
            
           $cekstat = \app\operational\models\SOD::find()->select('StatusCoscal')->where(['SODID'=>$sodid])->one();
           
           if($cekstat['StatusCoscal'] == 'RFA')
           {
               throw new NotFoundHttpException('Costcalc sedang dalam proses Approval');
           } else {
              return $this->render('_form', [
                            'model' => $model,
                            'OIDH' => Yii::$app->request->get('OIDH', 'xxx'),
                ]); 
           }
        } else {
        
            return $this->render('_form', [
                        'model' => $model,
                        'OIDH' => Yii::$app->request->get('OIDH', 'xxx'),
            ]);
        }
//        }
    }

    protected function findModel($id) {
        if (($model = OfferingD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelCoscal($OfferingDID, $Biayaid) {
        $model = \app\operational\models\CosCalc::find()->where([
                    'OfferingDID' => $OfferingDID,
                    'BiayaID' => $Biayaid])->one();

        if ($model == null) {
            $model = new \app\operational\models\CosCalc();
        }
        return $model;
    }

    protected function findModelclass($OfferingIDH, $class, $areaid) {
        $model = OfferingD::find()->where(['OfferingIDH' => $OfferingIDH, 'Class' => $class, 'AreaID' => $areaid])->one();

        if ($model == null) {
            $model = new OfferingD();
        }
        return $model;
    }

    public function actionDelcon($did, $idh) {
        $modelcoscal = \app\operational\models\CosCalH::find()->where(['OfferingDID' => $did])->one();

        $modelcoscal->OfferingDID = NULL;
        $modelcoscal->save();
        $this->findModel($did)->delete();
        Yii::$app->getSession()->setFlash('success', ' Data sukses dihapus');
        return $this->redirect(['offering-d/create', 'OIDH' => $idh]);
    }

    public function actionExportccmap() {
        ob_end_clean();
        return $this->render('exportccmap');
    }

    public function actionExportccss() {
        ob_end_clean();
        return $this->render('exportccss');
    }
    
}

<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\SOH;
use app\operational\models\SOHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SOHController extends Controller {

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
        $searchModel = new SOHSearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams));

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionViewSo($id) {
        $model = $this->findModel($id);
        return $this->render('detail', [
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new SOH();
        
        if ($model->load(Yii::$app->request->post())) {

            $idoffering = Yii::$app->request->post('of-id');
            $isdirect = $model->IsDirect;
            $sodate = $model->SODate;
            $tipebayar = $model->TipeBayar;
            $tipekontrak = $model->TipeKontrak;
            $pono = $model->PONo;
            $podate = $model->POdate;
            
            if($isdirect == 1)
            {
                $subcus = NULL;
            } else {
                $subcus = Yii::$app->request->post('sub-cus-id');
            }
            
            try {
                
                $exec = Yii::$app->db->createCommand("exec SOHInsert @OffID = :offid,@SubCust = :subcust,@isDirect = :isdirect,
                        @SODate= :sodate,@type = :type,@PaymentType = :paytype,@PONo = :pono,@PODate = :podate");
                $exec->bindParam(':offid', $idoffering);
                $exec->bindParam(':subcust', $subcus);
                $exec->bindParam(':isdirect', $isdirect);
                $exec->bindParam(':sodate', $sodate);
                $exec->bindParam(':type', $tipekontrak);
                $exec->bindParam(':paytype', $tipebayar);
                $exec->bindParam(':pono', $pono);
                $exec->bindParam(':podate', $podate);
                $exec->execute();
                
                Yii::$app->getSession()->setFlash('success', 'Create SO Successfully');
                return $this->redirect(['index']);
                
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(Yii::$app->request->referrer);
            }
            
            
        } else {
            return $this->render('_form', ['model' => $model,]);
        }
    }

    protected function findModel($id) {
        if (($model = SOH::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('SOIDH tidak ditemukan');
        }
    }

    protected function findModelOFH($id) {
        if (($model = \app\operational\models\OfferingH::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('OfferingIDH tidak ditemukan');
        }
    }

    public function actionCancelRfa($soid) {
        $tr = Yii::$app->db->beginTransaction();
        try {
            Yii::$app->db->createCommand("exec CancelRFASO '$soid'")->execute();
            $tr->commit();
            Yii::$app->getSession()->setFlash('success', ' SO telah batal RFA');
            return $this->redirect(['s-o-d/create', 'soidh' => $soid]);
        } catch (\yii\db\Exception $ex) {
            $tr->rollback();
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
            return $this->redirect(['s-o-d/create', 'soidh' => $soid]);
        }
    }

    public function actionRfa($soid) {
//        $asd = Yii::$app->request->get('soid', 'xxx');

        try {
            $sqlstring = "exec ValidasiRFASO '$soid'";
            $user = Yii::$app->user->identity->username;
            $cmd = Yii::$app->db->createCommand($sqlstring)->queryScalar();
            if ($cmd == 'OK') {
                $sqlstring = 'exec RequestApprovalSO @transid=:idTrans, @pic=:user';
                $cmd = Yii::$app->db->createCommand($sqlstring);
                $cmd->bindParam(':idTrans', $soid);
                $cmd->bindParam(':user', $user);
                $cmd->execute();
                Yii::$app->getSession()->setFlash('success', 'Berhasil RFA');
                return $this->redirect(['s-o-d/create', 'soidh' => $soid]);
            } else {
                Yii::$app->getSession()->setFlash('error', $cmd);
                return $this->redirect(['s-o-d/create', 'soidh' => $soid]);
            }
        } catch (\yii\db\Exception $ex) {
//            echo var_dump($ex);
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
            return $this->redirect(['s-o-d/create', 'soidh' => $soid]);
        }
    }
    
    public function actionRequestEndContractSoh($soidh) {
//        $model = new \app\operational\models\SOD();
//        $model = $this->findModelD($id);
//        
//        echo var_dump($model);
//        die();
//        
            $pic = Yii::$app->user->identity->username;
            try {
                $sqlstring = 'exec ReqEndContractSOH @idsoh = :idsoh, @pic=:pic';
                $exec = Yii::$app->db->createCommand($sqlstring);
                $exec->bindParam(':idsoh', $soidh);
                $exec->bindParam(':pic', $pic);
                
                $exec->execute();

                Yii::$app->getSession()->setFlash('success', 'Berhasil Request End Contract');
                return $this->redirect(['index', 'soidh' => $soidh]);
            } catch (\yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                return $this->redirect(['index', 'soidh' => $soidh]);
            }
        }

    public function actionCorrection($transid) {
        $user = Yii::$app->user->identity->username;
        $reason = Yii::$app->request->post('Reason');
        try {
            Yii::$app->db->createCommand("exec CorrectionApprovalSO '$transid', '$user' ,'$reason'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SO perlu review kembali.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(['transaction-master/index']);
    }
    
    public function actionDeleteSoh($SOH,$OFH){
        $pic = Yii::$app->user->identity->username;
        try {
            Yii::$app->db->createCommand("exec DeleteSOH '$SOH','$OFH','$pic'")->execute();
            Yii::$app->getSession()->setFlash('success', 'SO telah terhapus.');
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }
        return $this->redirect(['s-o-h/index']);
    }

    protected function findModelD($id) {
        if (($model = SOD::find()->where('SOIDH = ' . $id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data SO tidak ditemukan');
        }
    }
    
    protected function findModelWithSOD($id) {
        if (($model = SOD::find()->where(['SODID' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

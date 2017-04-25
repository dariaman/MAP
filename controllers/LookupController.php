<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use mPDF;

class LookupController extends Controller {

    public $layout = 'login';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLookupsoOfferingh() {
        

        $searchModel = new \app\operational\models\OfferingHSearch;
        $dataProvider = $searchModel->searchsooffering(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams));

        return $this->render('_offering', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProd($idjob) {
        // cari product yang status tidak sama dengan NM (masih terikat kontrak) 
        $searchModel = new \app\master\models\MasterProductSearch();
        $dataProvider = $searchModel->searchAllocProd(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams), $idjob);

        return $this->render('prod', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
//            'idaph' => $idaph
        ]);
    }

    public function actionLookupsod($soh) {
        // cari product yang status tidak sama dengan NM (masih terikat kontrak) 
        $searchModel = new \app\operational\models\SOHSearch();
        $dataProvider = $searchModel->Searchsod(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams), $soh);

        return $this->render('_sodidlookup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupmodalsod($soh) {
        $searchModel = new \app\operational\models\SOHSearch();
        $dataProvider = $searchModel->Searchsod(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams), $soh);
        return $this->render('_sodidlookup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupmodalsoh() {
        $searchModel = new \app\operational\models\SOHSearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams));
        return $this->render('_sohidlookup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionLookupmodalprod($idjob) {
        $searchModel = new \app\master\models\MasterProductSearch();
        $dataProvider = $searchModel->searchAllocProd(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams), $idjob);
        return $this->render('_prodidlookup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionLookupcustomer() {
        // cari offering yang belum diimplementasikan di SO
        $searchModel = new \app\master\models\MasterCustomerSearch();
        $dataProvider = $searchModel->searchLookupCustomer(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams));
        return $this->render('_customer', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupinvno() {
        // cari offering yang belum diimplementasikan di SO
        $searchModel = new \app\finance\models\BillingHSearch();
        $dataProvider = $searchModel->searchInv(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams));
        return $this->renderAjax('_invnolookup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupOfferingD($offeringH, $soh) {
        // cari offering Detail atas OfferingH
        try {
            $searchModel = new \app\operational\models\OfferingDSearch();
            $dataProvider = $searchModel->searchOfferingD(array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams), $offeringH, $soh);
        } catch (Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }

        return $this->render('_offeringdetail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupproductgs($idjob) {
        $searchModel = new \app\master\models\MasterProductSearch();
        $allprod = array_merge(Yii::$app->request->queryParams, Yii::$app->request->post());
        $dataProvider = $searchModel->searchLookupProductgs($allprod, $idjob);
        return $this->render('_productgs', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'idjob' => $idjob,
        ]);
    }
    
    public function actionLookuppseq($sodid,$seqid) {
        return $this->renderAjax('view-seqpro', [
                    'seqid' => $seqid,
                    'soidh' => $sodid
        ]);
    }
    
    public function actionLookupjadwal($sodid,$seqid) {
        return $this->renderAjax('viewjadwal', [
                    'seqid' => $seqid,
                    'soidh' => $sodid
        ]);
    }
    
    public function actionLookjlh($sodid, $seqid, $start, $end) { 
       return $this->renderAjax('viewjlh', [
                    'sodid'=>$sodid,
                    'seqid'=>$seqid,
                    'start'=>$start,
                    'end'=>$end,
        ]);
    }
    public function actionLooksalary($payroll) { 
       $html = $this->render('view-salary', [
                    'payroll'=>$payroll,
        ]);
        $mpdf=new mPDF('c','A4','30',''); 
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Slip Gaji Employee ".date('d-m-Y'));
        $mpdf->SetAuthor("MAP");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output(); exit;
        exit;
    }
    

    public function actionLookupproductfix() {
        $searchModel = new \app\operational\models\GoLiveProductSearch();
        $allprod = array_merge(Yii::$app->request->queryParams, Yii::$app->request->post());
        $dataProvider = $searchModel->searchLookupProductfix1($allprod);
        return $this->render('_productfix', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLookupproductpayroll() {
        $searchModel = new \app\payroll\models\PayrollInsentiveSearch();
        $allprod = array_merge(Yii::$app->request->queryParams, Yii::$app->request->post());
        $dataProvider = $searchModel->Searchpro($allprod);
        return $this->render('_productpayroll', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPro()
    {
        $this->layout = '@app/views/layouts/login.php';
        $searchModell = new \app\payroll\models\PayrollPotonganSearch();
        $reqpo=array_merge(Yii::$app->request->queryParams, Yii::$app->request->post());
        $dataProvider = $searchModell->SearchPotongan($reqpo);

        return $this->render('mp', [
            'searchModell' => $searchModell,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    protected function findModelGoliveHistory($seqid,$sodid) {
        if (($model = \app\operational\models\GoLiveProductHistory::find()->where(['SeqProduct' => $seqid,'SODID' => $sodid])->one()) !== null) {
            return $model;
        } else {
            return $model;
        }
    }
    
    protected function findModelAbsensiCustomer($seqid,$sodid) {
        if (($model = \app\payroll\models\AbsensiCustomer::find()->where(['SeqProduct' => $seqid,'SODID' => $sodid])->one()) !== null) {
            return $model;
        } else {
            return $model;
        }
    }
}


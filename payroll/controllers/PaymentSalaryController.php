<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PaymentSalary;
use app\payroll\models\PaymentSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mPDF;
use kartik\mpdf\Pdf;

/**
 * PaymentSalaryController implements the CRUD actions for PaymentSalary model.
 */
class PaymentSalaryController extends Controller
{
    public function behaviors()
    {
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
     * Lists all PaymentSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSalarySearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams));

        return $this->render('index', [
            'bulan' => Yii::$app->request->post('bulan',date('m')),
            'tahun' => Yii::$app->request->post('tahun',date('Y')),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PaymentSalary model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PaymentSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PaymentSalary();
        $request = Yii::$app->request;

        if ($model->load(Yii::$app->request->post())) {
            
            $pgidh = $request->post('pgidh');
            $bankgroup = $request->post('bankgroupid');
            $bankacc = $request->post('bankaccnum');
            $userid = Yii::$app->user->identity->username;
            $apdate = $model->APDate;
            $amount = $model->AmountPayment;
            $biayaadm = $model->BiayaAdmin;
            $idbankmap = $model->IDBankMAP;
            
            $exec = Yii::$app->db->createCommand("
            exec CreateAP 
            @pgidh=:pgidh,
            @apdate=:apdate,
            @amount=:amount,
            @biayaadm=:biayaadm,
            @idbankmap=:idbankmap,
            @bankgroupid=:bankgroupid,
            @bankreknum=:bankreknum,
            @userid=:userid");
            $exec->bindValue(':pgidh', $pgidh);
            $exec->bindValue(':apdate', $apdate);
            $exec->bindValue(':amount', $amount);
            $exec->bindValue(':biayaadm', $biayaadm);
            $exec->bindValue(':idbankmap', $idbankmap);
            $exec->bindValue(':bankgroupid', $bankgroup);
            $exec->bindValue(':bankreknum', $bankacc);
            $exec->bindValue(':userid', $userid);
            $exec->execute();
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PaymentSalary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->APNO]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the PaymentSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PaymentSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentSalary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSlipAll() {        
        
        $html = $this->render('_reportPdf');
        $mpdf=new mPDF('c','A4','30','','10','15','10'); 
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Slip Gaji Employee ".date('d-m-Y'));
        $mpdf->SetAuthor("MAP");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML("<h1>Hello World!</h1>");
        $mpdf->WriteHTML($html);
        $mpdf->Output(); 
        exit;
    }
    
    public function actionSlipPartial() {
        $idPy = Yii::$app->request->post('selection');
        $groupPY = '';

        foreach ($idPy as $key => $value) {
            // echo var_dump($value);
            $groupPY .= "'".$value."'".",";
        }

        $groupPY = substr($groupPY, 0,-1);

        // return $this->render('_reportView',['PayroolIDH' => $groupPY]);
        
        // die();
            // $Employee = substr($Employee,0,-1);
            $html = $this->render('_reportView',['PayroolIDH' => $groupPY]);
            $mpdf=new mPDF('c','A4','30',''); 
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Slip Gaji Employee ".date('d-m-Y'));
            $mpdf->SetAuthor("MAP");
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            // $mpdf->WriteHTML("<h1>Hello World!</h1>");
            $mpdf->Output(); 
            exit;
            exit;
    }

    public function actionRptSlip()
    {
        $searchModel = new PaymentSalarySearch();
        $postgaji = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchGaji($postgaji);

        if (isset($bulan)) { echo var_dump('bul =>'.$bulan); }
        if (isset($tahun)) { echo var_dump('tah =>'.$tahun); }

        echo var_dump('posBul =>'.Yii::$app->request->post('bulan',date('m')));
        echo var_dump('posTah =>'.Yii::$app->request->post('tahun',date('Y')));

        $bulanx = Yii::$app->request->post('bulan',date('m'));
        $tahunx = Yii::$app->request->post('tahun',date('Y')) ;

        return $this->render('_reportPdf', [
            'bulan' => $bulanx,
            'tahun' => $tahunx,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrintSlip(){
        // $parollid=Yii::$app->request->post('selection');
        // $content = null;
        // foreach ($parollid as $key => $value) {
        //     $content = $content . $this->renderPartial('_reportView',['PayroolIDH'=>$value]);            
        // }

        $idPy = Yii::$app->request->post('selection');


        $groupPY = '';

        foreach ($idPy as $key => $value) {
            $groupPY .= "'".$value."'".",";
        }
        $groupPY = substr($groupPY, 0,-1);

        // return $this->render('_reportView',['PayroolIDH'=>$groupPY]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'=> '.JudulKiri{border-top: 1px solid black;  border-bottom: 1px solid black; padding-top:5px; padding-bottom:5px;text-align: left;}.JudulKanan{border-top: 1px solid black;  border-bottom: 1px solid black; padding-top:5px; padding-bottom:5px;text-align: right;}',
            'content' => $this->renderPartial('_reportView',['PayroolIDH'=>$groupPY]),
            'filename' => 'SlipGaji.pdf',
            'options' => ['title' => 'dariaman'],
            // 'methods' => [ 
            //     'SetHeader'=>['PT. Mitra Asri Pratama'], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/pdf');

        // $pdfName = 'FILE-_' . date('d-m-Y') . '.pdf';

        // Yii::$app->response->format = yii\web\Response::FORMAT_HTML;
        // Yii::$app->response->setDownloadHeaders($pdfName, 'application/pdf');


        return $pdf->render(); 
    }

}

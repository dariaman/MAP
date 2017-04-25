<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PaymentSalary;
use app\payroll\models\PaymentSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mPDF;

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
     * Deletes an existing PaymentSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        
        $html = $this->render('_reportView');
        $mpdf=new mPDF('c','A4','30','','10','15','10'); 
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Slip Gaji Employee ".date('d-m-Y'));
        $mpdf->SetAuthor("MAP");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output(); exit;
        exit;
    }
    
    public function actionSlipPartial($idarr) {        
        
            $newarr = json_decode($idarr);
            $Employee = '';
            for($i = 0; $i < count($newarr); $i++) {
			$id = $newarr[$i];
			$Employee .= "'".$id."'".",";			
		} 		
            $Employee = substr($Employee,0,-1);
            $html = $this->render('_reportView',['pr' => $Employee]);
            $mpdf=new mPDF('c','A4','30',''); 
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Slip Gaji Employee ".date('d-m-Y'));
            $mpdf->SetAuthor("MAP");
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output(); exit;
            exit;
    }

}

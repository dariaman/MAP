<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\CosCalH;
use app\operational\models\CosCalD;
use app\operational\models\CosCalHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CosCalHController extends Controller
{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new CosCalHSearch();
        $cch = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($cch);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($CostcalIDH){
        $model = $this->findModel($CostcalIDH);
        
        try {
            return $this->render('view', [
                'model' => $model,
            ]);
        } catch (\Exception $e) {
            Yii::$app->getSession()->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Creates a new CosCalH model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CosCalH();

        if ($model->load(Yii::$app->request->post())) {    
            try{
                 $getid = Yii::$app->db->createCommand("
                    SELECT CostcalIDH = 'CCH'
                    + RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('0000'+CONVERT(varchar,isnull(max(right(CostcalIDH,4)),0)+1),4)
                    FROM CosCalH where SUBSTRING(CostcalIDH,4,6)=left(convert(varchar,getdate(),112),6) ")->queryScalar();
                $model->CostcalIDH = $getid;
                if($model->validate()){
                    $model->save();
                    Yii::$app->session->setFlash('Sukses', 'Data Berhasil Disimpan'); 
                    return $this->redirect(['cos-cal-d/create', 'CostcalIDH' => $getid, 'flag' => 'C']);
                }else{
                    Yii::$app->session->setFlash('Gagal Simpan', 'Pastikan data sudah diisi dengan lengkap !!'); 
                    return $this->render('create', ['model' => $model,]);
                }
            } catch (Exception $ex) {
                 Yii::$app->session->setFlash('error', $ex->errorInfo[2]); 
                 return $this->render('_form', ['model' => $model,]);
            }            
        } else {
            return $this->render('_form', ['model' => $model,]);
        }
    }

    public function actionUpdate($CostcalIDH)
    {
        $model = $this->findModel($CostcalIDH);
        if ($model->load(Yii::$app->request->post())) {            
            $model->CostcalIDH = $CostcalIDH;
            $model->save();
            return $this->redirect(['view', 'CostcalIDH' => $model->CostcalIDH]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    protected function findModel($CostcalIDH)
    {
        try {
            if (($model = CosCalH::findOne(['CostcalIDH' => $CostcalIDH])) !== null) return $model;
        } catch (\Exception $e) {
            Yii::$app->getSession()->setFlash('error', ErrorHandler::convertExceptionToError($e));
        }
    }
    
    public function actionAdd()
    {        
        $model = new CosCalD();       
        if (Yii::$app->request->post()) {
            
            $getid = Yii::$app->db->createCommand("
                SELECT CostcalDID = 'CCD'
                +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                +RIGHT('0000'+CONVERT(varchar,isnull(max(right(cd.CostcalDID,4)),0)+1),4)
                FROM CosCalD cd ")->queryScalar();
            
            $model->CostcalDID = $getid;
            $model->CostcalIDH = Yii::$app->request->post('idcchdr');
            $model->TipeBiaya = Yii::$app->request->post('TipeBiaya');
            $model->BiayaID = Yii::$app->request->post('jenis');
            $model->Amount = Yii::$app->request->post('Amount');
            $model->Remark = YIi::$app->request->post('Remark');
//            if(Yii::$app->request->post('percent') != NULL)
//            {
//                $model->IsPercentage = Yii::$app->request->post('percent');
//            } else {
//                $model->IsPercentage = 0;
//            }
            
//            print_r($model);
//            die();
            $model->save();
            return $this->redirect('./index.php?r=operational/cos-cal-h/detail&id='.$model->CostcalIDH);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        
    }
    
}

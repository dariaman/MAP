<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PayrollPotongan;
use app\payroll\models\PayrollPotonganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollPotonganController implements the CRUD actions for PayrollPotongan model.
 */
class PayrollPotonganController extends Controller
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
     * Lists all PayrollPotongan models.
     * @return mixed
     */
     public function actionIndex()
    {
        $searchModel = new PayrollPotonganSearch();
        $params = Yii::$app->request->queryParams;
        $query  = Yii::$app->request->post();
        $merge  =  array_merge($params,$query);
        $dataProvider = $searchModel->Search($merge);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       
    }
    
    public function actionEditpotongan($id)
    {
        $model = $this->findModel($id);
        $req = Yii::$app->request;
        $periodthn = $req->post('Thn');
        $periodbln = $req->post('Bulan');
        $pic = Yii::$app->user->identity->username;
        if($model->load(Yii::$app->request->post()))
        {
            
            $model->PeriodeBayar = $periodthn.''.$periodbln;
            $model->UserUpdate = $pic;
            $model->DateUpdate = new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect('index.php?r=payroll/payroll-potongan');
            
        } else {
            return $this->render('_editpotongan',['model' => $model]);
        }
    }
    
    
    /**
     * Creates a new PayrollPotongan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollPotongan();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) {
                        
            $req = Yii::$app->request;
            $tahun = $req->post('Thn');
            $bulan = $req->post('Bulan');
            
            if($model->IsReguler == 0 && $tahun == ''){
               \Yii::$app->session->setFlash('error', Yii::t('app', 'data gagal Di Save'));
               return $this->render('create', [
                'model' => $model,
                ]);
            }
            elseif($model->IsReguler == 0 && $bulan == '')
            {
               \Yii::$app->session->setFlash('error', Yii::t('app', 'data gagal Di Save'));
               return $this->render('create', [
                'model' => $model,
                ]);
            }
            elseif($model->IsReguler == 1) {
                $model->PeriodeBayar = Null;
            }
           else{
                $model->PeriodeBayar = $tahun.''.$bulan;
           }
           
            $model->IDKey = Yii::$app->db->createCommand("
                SELECT IDKey = RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('0000'+CONVERT(varchar,isnull(max(right(IDKey,4)),0)+1),4)
                    FROM PayrollPotongan where LEFT(IDKey,6)=left(convert(varchar,getdate(),112),6)
            ")->queryScalar();
           $model->UserCrt = $pic;
           $model->DateCrt = new \yii\db\Expression(' getdate() ');
           $model->save();
           return $this->redirect('index.php?r=payroll/payroll-potongan');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PayrollPotongan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $IDPotongan
     * @param string $ProductID
     * @return mixed
     */
    public function actionUpdate($IDPotongan, $ProductID)
    {
        $model = $this->findModel($IDPotongan, $ProductID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IDPotongan' => $model->IDPotongan, 'ProductID' => $model->ProductID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PayrollPotongan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $IDPotongan
     * @param string $ProductID
     * @return mixed
     */
//    public function actionDelete($IDPotongan, $ProductID)
//    {
//        $this->findModel($IDPotongan, $ProductID)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the PayrollPotongan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $IDPotongan
     * @param string $ProductID
     * @return PayrollPotongan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModel($IDPotongan, $ProductID)
//    {
//        if (($model = PayrollPotongan::findOne(['IDPotongan' => $IDPotongan, 'ProductID' => $ProductID])) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }
    
    protected function findModel($id)
    {
        if (($model = PayrollPotongan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

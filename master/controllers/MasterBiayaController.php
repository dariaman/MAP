<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterBiaya;
use app\master\models\MasterBiayaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterBiayaController implements the CRUD actions for MasterBiaya model.
 */
class MasterBiayaController extends Controller
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
    
    public function actionIndex()
    {
        $searchModel = new MasterBiayaSearch();
        $Biaya = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->SearchBiaya($Biaya);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionCreate(){
        $model = new MasterBiaya();        
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {

            $idtun=Yii::$app->db->createCommand(
                    "select RIGHT('0000000' + convert(varchar(8),ISNULL(max(BiayaID),0) + 1),8) from MasterBiaya
                     where BiayaID  not in('GP000001','M1000001','M5000001','LMB00001','LMB00002','LMB00003','LMB00004','TRN00001','THR00001','SRG00001','CMC00001','BPJS0001')")->queryScalar();
            $model->BiayaID = $idtun;
            $model->UserCrt= $pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            if($model->validate()){ 
                $model->save();
                Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            }else{
                Yii::$app->session->setFlash('error', 'Data Gagal Disimpan');
            }
            return $this->redirect(['index']); 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BiayaID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    protected function findModel($id)
    {
        if (($model = MasterBiaya::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

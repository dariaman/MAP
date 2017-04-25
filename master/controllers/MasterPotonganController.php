<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterPotongan;
use app\master\models\MasterPotongansearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MasterPotonganController extends Controller
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
        $searchModel  = new MasterPotongansearch();
        $arraymerge   =  array_merge(Yii::$app->request->queryParams,Yii::$app->request->post());
        $dataProvider = $searchModel->search($arraymerge);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()    {
        $model = new MasterPotongan();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) {
            $idpot=Yii::$app->db->createCommand("select IDPotongan='P' +right('000000'+convert(varchar,isnull(max(right(IDPotongan,7)),0)+1),7) FROM MasterPotongan")
                    ->queryScalar();
            $model->IDPotongan = $idpot;
            $model->UserCrt = $pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserUpdate =$pic;
            $model->DateUpdate=new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil diupdate');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    protected function findModel($id){
        if (($model = MasterPotongan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

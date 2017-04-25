<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterTunjangan;
use app\master\models\MasterTunjanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterTunjanganController implements the CRUD actions for MasterTunjangan model.
 */
class MasterTunjanganController extends Controller
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
    
    public function actionIndex(){
        $searchModel  = new MasterTunjanganSearch();
        $arraymerge   =  array_merge(Yii::$app->request->queryParams,Yii::$app->request->post());
        $dataProvider = $searchModel->search($arraymerge);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate(){
        $model = new MasterTunjangan();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) {
           $idtun=Yii::$app->db->createCommand("select IDTunjangan='T' +right('000000'+convert(varchar,isnull(max(right(IDTunjangan,7)),0)+1),7) FROM MasterTunjangan")->queryScalar();
           $model->IDTunjangan = $idtun;
           $model->UserCrt = $pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
           $model->save();
           return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
    
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserUpdate =$pic;
            $model->DateUpdate=new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
    
    protected function findModel($id){
        if (($model = MasterTunjangan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

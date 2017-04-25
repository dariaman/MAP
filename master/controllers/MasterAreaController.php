<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterArea;
use app\master\models\MasterAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MasterAreaController extends Controller
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
        $searchModel = new MasterAreaSearch();
        $area = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($area);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2()
    {
        $searchModel = new MasterAreaSearch();
        $area = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($area);

        return $this->renderPartial('asd', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate() {
        $model = new MasterArea();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {          
            $id= Yii::$app->db->createCommand( "SELECT right('0000000' + CONVERT(VARCHAR,(ISNULL(MAX(AreaID),0)+1)),8) from MasterArea")->queryScalar();
            $model->AreaID=$id;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->UserCrt=$pic;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Ditambahkan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdate($id){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->DateUpdate=new \yii\db\Expression(' getdate() ');
            $model->UserUpdate=Yii::$app->user->getId();
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id){
        if (($model = MasterArea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan....');
        }
    }
}

<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterBankGroup;
use app\master\models\MasterBankGroupsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterBankGroupController implements the CRUD actions for MasterBankgroup model.
 */
class MasterBankGroupController extends Controller
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
        $searchModel = new MasterBankGroupsearch();
        $postpotongan = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($postpotongan);

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
    
    public function actionCreate(){
        $model = new MasterBankgroup();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $maxid = Yii::$app->db->createCommand("SELECT RIGHT('0000' + CONVERT(VARCHAR(5),(ISNULL(MAX(BankGroupID),0)+1)),5) FROM MasterBankGroup")->queryScalar();
            $model->BankGroupID = $maxid;            
            $model->UserCrt = $pic;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil disimpan');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) {
            $model->UserUpdate =$pic;
            $model->DateUpdate=new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil diupdate');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    protected function findModel($id)
    {
        if (($model = MasterBankgroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

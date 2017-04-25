<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterBank;
use app\master\models\MasterBankSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterBankController implements the CRUD actions for MasterBank model.
 */
class MasterBankController extends Controller
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
    
    public function actionIndex() {
        $searchModel = new MasterBankSearch();
        $postpotongan = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($postpotongan);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate() {
        $model = new MasterBank();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->BankID =  Yii::$app->db->createCommand("SELECT RIGHT('0000000' + CONVERT(VARCHAR,(ISNULL(MAX(BankID),0)+1)),8) FROM MasterBank")->queryScalar();
            $model->UserCrt = $pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model]);
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
    
    protected function findModel($id)    {
        if (($model = MasterBank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

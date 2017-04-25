<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterCustomer;
use app\master\models\MasterCustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MasterCustomerController extends Controller {

    public function behaviors() {
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

        $searchModel = new MasterCustomerSearch();
        $cust = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($cust);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('detail', [
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new MasterCustomer();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->CustomerID = Yii::$app->db->createCommand("
                    SELECT CustomerID = 'CUS' +
                    LEFT(convert(varchar,GETDATE(),12),4) +
                    RIGHT('000'+convert(varchar,isnull(max(right(CustomerID,3)),0)+1),3) 
                    FROM mastercustomer WHERE SUBSTRING(CustomerID,4,4)= LEFT(convert(varchar,GETDATE(),12),4) ")->queryScalar();
            $model->UserCrt = $pic;
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
            if ($model->IDAbsenType == "") {
                $model->IDAbsenType = NULL;
            }
//            $model->FormulaJam = NULL;
//            $model->FormulaPoint = NULL;
//            $model->FormulaAmount = NULL;
//            echo var_dump(Yii::$app->request->post($model->IDFormulaOT));
//            echo var_dump(Yii::$app->request->post('formula-ot'));
////            echo $model->IDFormulaOT;
//            die();
            $model->IDFormulaOT = Yii::$app->request->post('formula-ot');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Ditambahkan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {

            $model->UserUpdate = $pic;
            $model->DateUpdate = new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = MasterCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

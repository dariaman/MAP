<?php

namespace app\master\controllers;

use Yii;
use app\master\models\NilaiTes;
use app\master\models\NilaiTesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NilaiTesController implements the CRUD actions for NilaiTes model.
 */
class NilaiTesController extends Controller {

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

    /**
     * Lists all NilaiTes models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NilaiTesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NilaiTes model.
     * @param string $CalonProductID
     * @param string $IDJenisTes
     * @return mixed
     */
//    public function actionView($CalonProductID, $IDJenisTes) {
//        return $this->render('view', [
//                    'model' => $this->findModel($CalonProductID, $IDJenisTes),
//        ]);
//    }

    /**
     * Creates a new NilaiTes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new NilaiTes();
        $CalonProductID = Yii::$app->request->get('CalonProductID', 'xxx');
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) {

            $model->CalonProductID = $CalonProductID;
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
            $model->UserCrt = $pic;
//            print_r($model->CalonProductID);
//            echo '<br>';
//            print_r($model->TglTes);
//            echo '<br>';
//            print_r($model->IDJenisTes);
//            echo '<br>';
//            print_r($model->Nilai);
//            echo '<br>';
//            print_r($model->CustomerID);
//            echo '<br>';
//            print_r($model->IDAbsenType);
//             die();
            $model->save();
            return $this->redirect(['master-calon-product/update','id'=>$CalonProductID]);
//            return $this->redirect(['view', 'CalonProductID' => $model->CalonProductID, 'IDJenisTes' => $model->IDJenisTes]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NilaiTes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CalonProductID
     * @param string $IDJenisTes
     * @return mixed
     */
    public function actionUpdate($CalonProductID, $IDJenisTes) {
        $model = $this->findModel($CalonProductID, $IDJenisTes);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CalonProductID' => $model->CalonProductID, 'IDJenisTes' => $model->IDJenisTes]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NilaiTes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CalonProductID
     * @param string $IDJenisTes
     * @return mixed
     */
//    public function actionDelete($CalonProductID, $IDJenisTes) {
//        $this->findModel($CalonProductID, $IDJenisTes)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the NilaiTes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CalonProductID
     * @param string $IDJenisTes
     * @return NilaiTes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CalonProductID, $IDJenisTes) {
        if (($model = NilaiTes::findOne(['CalonProductID' => $CalonProductID, 'IDJenisTes' => $IDJenisTes])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

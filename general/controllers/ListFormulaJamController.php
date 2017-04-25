<?php

namespace app\general\controllers;

use Yii;
use app\general\models\ListFormulaJam;
use app\general\models\ListFormulaJamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListFormulaJamController implements the CRUD actions for ListFormulaJam model.
 */
class ListFormulaJamController extends Controller {

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
     * Lists all ListFormulaJam models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ListFormulaJamSearch();
        $area = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($area);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ListFormulaJam model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ListFormulaJam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ListFormulaJam();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
            $model->UserCrt = $pic;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ListFormulaJam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->DateUpdate = new \yii\db\Expression(' getdate() ');
            $model->UserUpdate = $pic;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Diubah');
            return $this->redirect(["index"]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ListFormulaJam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ListFormulaJam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ListFormulaJam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ListFormulaJam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

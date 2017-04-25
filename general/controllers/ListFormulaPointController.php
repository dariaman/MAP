<?php

namespace app\general\controllers;

use Yii;
use app\general\models\ListFormulaPoint;
use app\general\models\ListFormulaPointSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListFormulaPointController implements the CRUD actions for ListFormulaPoint model.
 */
class ListFormulaPointController extends Controller {

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
     * Lists all ListFormulaPoint models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ListFormulaPointSearch();
        $area = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($area);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ListFormulaPoint model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ListFormulaPoint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ListFormulaPoint();
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
     * Updates an existing ListFormulaPoint model.
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
     * Deletes an existing ListFormulaPoint model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ListFormulaPoint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ListFormulaPoint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ListFormulaPoint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

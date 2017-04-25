<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PayrollGajiD;
use app\payroll\models\PayrollGajiDSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollGajiDController implements the CRUD actions for PayrollGajiD model.
 */
class PayrollGajiDController extends Controller
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

    /**
     * Lists all PayrollGajiD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollGajiDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollGajiD model.
     * @param string $ItemID
     * @param string $PayrollGajiIDH
     * @return mixed
     */
    public function actionView($ItemID, $PayrollGajiIDH)
    {
        return $this->render('view', [
            'model' => $this->findModel($ItemID, $PayrollGajiIDH),
        ]);
    }

    /**
     * Creates a new PayrollGajiD model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollGajiD();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ItemID' => $model->ItemID, 'PayrollGajiIDH' => $model->PayrollGajiIDH]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PayrollGajiD model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ItemID
     * @param string $PayrollGajiIDH
     * @return mixed
     */
    public function actionUpdate($ItemID, $PayrollGajiIDH)
    {
        $model = $this->findModel($ItemID, $PayrollGajiIDH);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ItemID' => $model->ItemID, 'PayrollGajiIDH' => $model->PayrollGajiIDH]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PayrollGajiD model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ItemID
     * @param string $PayrollGajiIDH
     * @return mixed
     */
    public function actionDelete($ItemID, $PayrollGajiIDH)
    {
        $this->findModel($ItemID, $PayrollGajiIDH)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PayrollGajiD model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ItemID
     * @param string $PayrollGajiIDH
     * @return PayrollGajiD the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ItemID, $PayrollGajiIDH)
    {
        if (($model = PayrollGajiD::findOne(['ItemID' => $ItemID, 'PayrollGajiIDH' => $PayrollGajiIDH])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

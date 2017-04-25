<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\ProductPKWT;
use app\operational\models\ProductPKWTSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductPKWTController implements the CRUD actions for ProductPKWT model.
 */
class ProductPKWTController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductPKWT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPKWTSearch();
        $caripkwt = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($caripkwt);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductPKWT model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductPKWT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new ProductPKWT();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->PeriodFrom > $model->PeriodTo) {
                Yii::$app->getSession()->setFlash('error','PeriodFrom harus lebih kecil daripada PeriodTo');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            
            try {
                $model->UserCrt = Yii::$app->user->identity->username;
                $model->save(false);
                
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                return $this->redirect(['index']);
            } catch (Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
                return $this->redirect(Yii::$app->request->referrer);
            }
            
            return $this->redirect(['view', 'id' => $model->ProductID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductPKWT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ProductID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductPKWT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductPKWT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductPKWT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPKWT::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

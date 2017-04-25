<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\FakturPajakD;
use app\finance\models\FakturPajakDSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FakturPajakDController implements the CRUD actions for FakturPajakD model.
 */
class FakturPajakDController extends Controller
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
     * Lists all FakturPajakD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FakturPajakDSearch();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FakturPajakD model.
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
     * Creates a new FakturPajakD model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->findModel($_GET['NoFakturPajak']);
        
        $nofakturpajak = $model->NoFakturPajak;
        
        if ($model->load(Yii::$app->request->post())) {
            $active = $model->IsActive;
           
            $exec = Yii::$app->db->createCommand("update FakturPajakD SET IsActive =:isactive where NoFakturPajak='" . $nofakturpajak . "' ");
            $exec->bindParam(":isactive", $active);
            $exec->execute();
            
            Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            return $this->redirect(['index', 'TRNo' => $model->TRNo]);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FakturPajakD model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NoFakturPajak]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FakturPajakD model.
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
     * Finds the FakturPajakD model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FakturPajakD the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FakturPajakD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

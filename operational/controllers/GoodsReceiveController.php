<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\GoodsReceive;
use app\operational\models\GoodsReceiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsReceiveController implements the CRUD actions for GoodsReceive model.
 */
class GoodsReceiveController extends Controller
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
     * Lists all GoodsReceive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsReceiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsReceive model.
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
     * Creates a new GoodsReceive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsReceive();
        $modelStock = new \app\operational\models\StockCard();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $getid = Yii::$app->db->createCommand("
                    SELECT GRID = 'GR'
                    +left(convert(varchar,getdate(),112),4)
                    +RIGHT('00000'+CONVERT(varchar,isnull(max(right(GRID,5)),0)+1),5)
                    FROM GoodsReceive 
                    ")->queryScalar();
            $model->GRID = $getid;
            
            $execsp = Yii::$app->db->createCommand("exec InOutStock @item = :item, @qty = :qty ,@tgl = :tgl, @user = :user, @flag = :flag");
            $execsp->bindValue(':item', $model->ItemID);
            $execsp->bindValue(':qty', $model->Qty);
            $execsp->bindValue(':tgl', $model->ReceiveDate);
            $execsp->bindValue(':user', Yii::$app->user->getId());
            $execsp->bindValue(':flag', 'G');
            $execsp->execute();
            
            $model->save();
//            return $this->redirect(['view', 'id' => $model->GRID]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GoodsReceive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->GRID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GoodsReceive model.
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
     * Finds the GoodsReceive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsReceive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsReceive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

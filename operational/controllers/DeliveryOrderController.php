<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\DeliveryOrder;
use app\operational\models\DeliveryOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeliveryOrderController implements the CRUD actions for DeliveryOrder model.
 */
class DeliveryOrderController extends Controller
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
     * Lists all DeliveryOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliveryOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeliveryOrder model.
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
     * Creates a new DeliveryOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeliveryOrder();

        if ($model->load(Yii::$app->request->post())) {
            $model->DONo = Yii::$app->db->createCommand("
                        SELECT DONo = 'DO'
                        +left(convert(varchar,getdate(),112),4)
                        +RIGHT('00000'+CONVERT(varchar,isnull(max(right(DONo,5)),0)+1),5)
                        FROM DeliveryOrder 
                        ")->queryScalar();
            
            $grid = $model->GRID;
            
            $modelGrid = \app\operational\models\GoodsReceive::find()->where(['GRID' => $grid])->one();
            try {
                $execsp = Yii::$app->db->createCommand("exec InOutStock @item = :item, @qty = :qty ,@tgl = :tgl, @user = :user, @flag = :flag, @sodid = :sodid");
                $execsp->bindValue(':item', $modelGrid->ItemID);
                $execsp->bindValue(':qty', $model->Qty);
                $execsp->bindValue(':tgl', $model->DODate);
                $execsp->bindValue(':user', Yii::$app->user->getId());
                $execsp->bindValue(':flag', 'D');
                $execsp->bindValue(':sodid', $model->SODID);
                $execsp->execute();

                $model->save();
            } catch(\yii\db\Exception $ex){
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
            
            
            //return $this->redirect(['view', 'id' => $model->DONo]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DeliveryOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->DONo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DeliveryOrder model.
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
     * Finds the DeliveryOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DeliveryOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\AccountReceivable;
use app\finance\models\AccountReceivableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountReceivableController implements the CRUD actions for AccountReceivable model.
 */
class AccountReceivableController extends Controller
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
     * Lists all AccountReceivable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountReceivableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccountReceivable model.
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
     * Creates a new AccountReceivable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountReceivable();

        if ($model->load(Yii::$app->request->post())) {
            
            $invno = $model->InvoiceNo;
            $refno = $model->RefNo;
            $paydate = $model->PaymentDate;
            $userid = Yii::$app->user->identity->username;
            
            $exec = Yii::$app->db->createCommand("exec CreateAR @invno = :invno, @refno = :refno, @paydate = :paydate, @userid = :userid");
            $exec->bindValue(':invno', $invno);
            $exec->bindValue(':refno', $refno);
            $exec->bindValue(':paydate', $paydate);
            $exec->bindValue(':userid', $userid);
            $exec->execute();
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AccountReceivable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ARNo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AccountReceivable model.
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
     * Finds the AccountReceivable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AccountReceivable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountReceivable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

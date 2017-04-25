<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\BillingD;
use app\finance\models\BillingDSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BillingDController implements the CRUD actions for BillingD model.
 */
class BillingDController extends Controller
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
     * Lists all BillingD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillingDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new BillingD();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BillingNo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCancelBilling()
    {
        $iscancelfp = Yii::$app->request->post('CancelFP');
        $cancelreason = Yii::$app->request->post('CancelReason');
        $userid = Yii::$app->user->identity->username;
        
        if(!isset($iscancelfp)) { $iscancelfp = 0;
        } else { $iscancelfp = $iscancelfp; }
        
        $model = new \app\finance\models\FakturPajakD();

        if (Yii::$app->request->post()) {
            
            $execsp = Yii::$app->db->createCommand("EXEC CancelBilling @invno = :invno, @flag = :flag, @reason = :reason, @userid = :userid");
            $execsp->bindValue(':invno', Yii::$app->request->post('idInvNo'));
            $execsp->bindValue(':flag', $iscancelfp);
            $execsp->bindValue(':reason', $cancelreason);
            $execsp->bindValue(':userid', $userid);
            $execsp->execute();
            
            return $this->redirect(['billing-h/index']);
        } else {
            return $this->render('create', ['model' => $model ]);
        }
    }
    
    protected function findModel($id)
    {
        if (($model = BillingD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

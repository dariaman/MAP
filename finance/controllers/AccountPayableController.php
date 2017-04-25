<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\AccountPayable;
use app\finance\models\AccountPayableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountPayableController implements the CRUD actions for AccountPayable model.
 */
class AccountPayableController extends Controller
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
     * Lists all AccountPayable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountPayableSearch();
        $params=Yii::$app->request->queryParams;
        $post=  \Yii::$app->request->post();
        $datamerge=array_merge($params,$post);
        $dataProvider = $searchModel->search($datamerge);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
//      public function actionPayment()
//    {
//        $searchModel = new AccountPayableSearch();
//        $param=Yii::$app->request->queryParams;
//        $data=\Yii::$app->request->post();
//        $merge=array_merge($param,$data);
//        $dataProvider = $searchModel->Searchpayment($merge);
//
//        return $this->render('payment', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    /**
     * Displays a single AccountPayable model.
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
     * Creates a new AccountPayable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountPayable();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()))
            
        {
//            $request=  \Yii::$app->request;
            $model->APNo=\Yii::$app->db->createCommand("select APNo='APN'
                                    +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                                    +RIGHT('00'+CONVERT(varchar,isnull(max(right(AP.APNo,3)),0)+1),3)
                                    FROM AccountPayable AP")->queryScalar();
            $model->UserCrt=$pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
             $hasil=$model->save();
             if($hasil)
             {
                  Yii::$app->session->setFlash('info', Yii::t('app', 'Succes saved Data'));
                 return $this->redirect('index.php?r=finance/account-payable');
             }
             else{
                  \Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot update data'));
                return $this->redirect('index.php?r=finance/account-payable');
             }
           
        }  
          return $this->render('create', [
                'model' => $model,
            ]);   
    }
             
    

    /**
     * Updates an existing AccountPayable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->APNo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AccountPayable model.
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
     * Finds the AccountPayable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AccountPayable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = AccountPayable::find()->where("PaymentReqNo='". $model->APNo."'")) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

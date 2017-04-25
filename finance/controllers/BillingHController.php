<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\BillingH;
use app\finance\models\BillingHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\finance\models\Invoice;
/**
 * BillingHController implements the CRUD actions for BillingH model.
 */
class BillingHController extends Controller
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
     * Lists all BillingH models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillingHSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new BillingH();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->InvoiceNo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    protected function findModel($id)
    {
        if (($model = BillingH::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelTtbill($inv)
    {
        if (($model = \app\finance\models\DocBilling::findOne($inv)) !== null) {
            return $model;
        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
            return NULL;
        }
    }
        
    public function actionTandaTerimaBilling($invno)
    {
        $model = $this->findModelTtbill($invno);
        $pic = Yii::$app->user->identity->username;
        $invdate = Invoice::find()->where(['InvoiceNo' => $invno])->one();
        
        $datetotime1 = strtotime($invdate['InvoiceDate']);
        

        if($model == NULL)
        {
            $model = new \app\finance\models\DocBilling();
            $model->UserCrt = $pic;
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
//            echo var_dump($model);
        } else {
            $model = $this->findModelTtbill($invno);
            $model->UserUpdate = $pic;
            $model->DateUpdate = new \yii\db\Expression(' getdate() ');
//            echo var_dump($model);
        }
        
        if($model->load(Yii::$app->request->post()))
        {
            
             $model->InvoiceNo = $invno;
             
//             if($datetotime1 > strtotime($model->SendDate))
//             {
//                Yii::$app->getSession()->setFlash('error', 'Tanggal Kirim tidak boleh kurang dari tanggal terbit billing');
//                return $this->redirect(['tanda-terima-billing','invno' => $invno]);
//             } else if ($model->ReceivedDate != NULL)
//             {
//                 if(strtotime($model->SendDate) > strtotime($model->ReceivedDate))
//                 {
//                    Yii::$app->getSession()->setFlash('error', 'Tanggal Terima tidak boleh kurang dari tanggal Kirim billing');
//                    return $this->redirect(['tanda-terima-billing','invno' => $invno]);
//                 } else if ($datetotime1 > strtotime($model->ReceivedDate)){
//                    Yii::$app->getSession()->setFlash('error', 'Tanggal Terima tidak boleh kurang dari tanggal terbit billing');
//                    return $this->redirect(['tanda-terima-billing','invno' => $invno]);
//                 } 
//             } else {
                 $model->save();
             
    //             echo var_dump($model);
                 Yii::$app->getSession()->setFlash('success', 'Sukses menyimpan data');
                 return $this->redirect(['index']);
//             }
        } else {
            
            return $this->render('_ttbill',['model' => $model]);
        }
        
    }
        
    public function actionPrintAll(){
        ob_end_clean();
        return $this->render('exportinvall');  
    }
    
    public function actionPrintPartial($idinv)
    {
        
        $newarr = json_decode($idinv);
        ob_end_clean();
        return $this->render('exportinvpart',['idinv' => $newarr]); 

    }
}

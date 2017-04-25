<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PayrollInsentive;
use app\payroll\models\PayrollInsentiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollInsentiveController implements the CRUD actions for PayrollInsentive model.
 */
class PayrollInsentiveController extends Controller
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
     * Lists all PayrollInsentive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollInsentiveSearch();
        $params = Yii::$app->request->queryParams;
        $query  = Yii::$app->request->post();
        $merge  =  array_merge($params,$query);
        $dataProvider = $searchModel->Search($merge);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       
    }

    /**
     * Displays a single PayrollInsentive model.
     * @param string $id
     * @return mixed
     */

    
    public function actionEditinsentive($id)
    {
        $model = $this->findModel($id);
        $req = Yii::$app->request;
        $periodthn = $req->post('Thn');
        $periodbln = $req->post('Bulan');
        if($model->load(Yii::$app->request->post()))
        {
            $model->ProductID = Yii::$app->request->post('prod-id-payroll');
            $model->PeriodeBayar = $periodthn.''.$periodbln;
            $model->UserUpdate = Yii::$app->user->identity->username;
            $model->DateUpdate = date('Y-m-d h:i:s');
            $model->save();
            return $this->redirect('index.php?r=payroll/payroll-insentive');
            
        } else {
            return $this->render('_editform',['model' => $model]);
        }
    }

    /**
     * Creates a new PayrollInsentive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new PayrollInsentive();
        $req = Yii::$app->request;
        $pic = Yii::$app->user->identity->username;
        if ($model->load($req->post())) {
            $periodthn = $req->post('Thn');
            $periodbln = $req->post('Bulan');
            $ipprod = Yii::$app->request->post('prod-id-payroll');
            $query = "select ProductID from PayrollInsentive where ProductID='".$ipprod."'";
            $sql = Yii::$app->db->createCommand($query)->queryScalar();
            if($sql == $ipprod )
            {
//                Jika ProductID Double
                \Yii::$app->session->setFlash('error', Yii::t('app', 'data gagal Di Save')); 
                return $this->render('create', [
                'model' => $model,
            ]);
            }
            elseif($periodthn == '')
            {
//                Jika Tahun Kosong
               \Yii::$app->session->setFlash('error', Yii::t('app', ' Maaf Tahun Tolong DIisi')); 
                return $this->render('create', [
                'model' => $model,
            ]);
            }
            else{
                $model->IDKey = Yii::$app->db->createCommand("
                SELECT IDKey = RIGHT(CONVERT(varchar(6),getdate(),112),6)
                    +RIGHT('0000'+CONVERT(varchar,isnull(max(right(pp.IDKey,4)),0)+1),4)
                    FROM PayrollPotongan pp where SUBSTRING(IDKey,4,6)=left(convert(varchar,getdate(),112),6)
                ")->queryScalar();
                $model->ProductID = $ipprod;
                $model->PeriodeBayar = $periodthn.''.$periodbln;
                $model->UserCrt = $pic;
                $model->DateCrt = new \yii\db\Expression(' getdate() ');
                $model->save();
                return $this->redirect('index.php?r=payroll/payroll-insentive');
            }
           
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PayrollInsentive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
             $model->save();
            return $this->redirect('index.php?r=payroll/payroll-insentive');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PayrollInsentive model.
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
     * Finds the PayrollInsentive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PayrollInsentive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollInsentive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

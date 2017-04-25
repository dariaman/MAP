<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PayrollInsentive;
use app\payroll\models\PayrollInsentiveSearch;
use app\master\models\MasterProduct;
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PayrollInsentiveSearch();
        $dataProvider = $searchModel->Search(array_merge(Yii::$app->request->queryParams,Yii::$app->request->post()));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => false,
        ]);
       
    }
    
    public function actionCreate()
    {
        $model = new PayrollInsentive();

        if (Yii::$app->request->IsPost) {

            if(Yii::$app->request->post('Thn')=='' || Yii::$app->request->post('Bulan')==''){
                \Yii::$app->session->setFlash('error', Yii::t('app', 'data gagal Di Save, Tahun dan Bulan Periode pembayaran harus diisi')); 
                return $this->redirect(Yii::$app->request->referrer);
            }

            $model->load(Yii::$app->request->post());
            $model->PeriodePayroll = Yii::$app->request->post('Thn').Yii::$app->request->post('Bulan');
            $model->ProductID = Yii::$app->request->post('prod-id-payroll');
            $model->UserCrt = Yii::$app->user->identity->username;
            $model->save(false);

            \Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(['index']);
           
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($ItemID, $PeriodePayroll, $ProductID){
        $model = $this->findModel($ItemID, $PeriodePayroll, $ProductID);
        
        if (Yii::$app->request->IsPost) {
            $tahun = Yii::$app->request->post('Thn');
            $bulan = Yii::$app->request->post('Bulan');
            if($tahun=='' || $bulan==''){
                throw new NotFoundHttpException('Data Periode Pembayaran salah');
            }
            $model->load(Yii::$app->request->post());
            $model->ProductID = Yii::$app->request->post('prod-id-payroll');
            $model->PeriodePayroll = $tahun.''.$bulan;
            $model->UserUpdate = Yii::$app->user->identity->username;
            $model->DateUpdate = new \yii\db\Expression('getdate()');
            $model->Remark = ($model->Remark == '') ? null : $model->Remark ;
            $model->save(false);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    protected function findModel($ItemID, $PeriodePayroll, $ProductID)
    {
        if (($model = Payrollinsentive::find()
                        ->alias('pt')
                        ->select('pt.ProductID,pt.ItemID,pt.Amount,pt.PeriodePayroll,mp.Nama,mj.Description AS jobdesk,pt.Remark,pt.IsActive,pt.tgl')
                        ->innerJoin('MasterProduct mp', 'mp.ProductID = pt.ProductID')
                        ->innerJoin('MasterJobDesc mj', 'mj.IDJobDesc = mp.IDJobDesc')
                        ->where([
                            'pt.ItemID' => $ItemID, 
                            'pt.PeriodePayroll' => $PeriodePayroll, 
                            'pt.ProductID' => $ProductID
                        ])->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data Tidak ditemukan atau data tidak dapat di Ubah.');
        }
    }
}

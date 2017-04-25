<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PayrollPotongan;
use app\payroll\models\PayrollPotonganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollPotonganController implements the CRUD actions for PayrollPotongan model.
 */
class PayrollPotonganController extends Controller
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
     * Lists all PayrollPotongan models.
     * @return mixed
     */
     public function actionIndex()
    {
        $searchModel = new PayrollPotonganSearch();
        $params = Yii::$app->request->queryParams;
        $query  = Yii::$app->request->post();
        $merge  =  array_merge($params,$query);
        $dataProvider = $searchModel->Search($merge);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       
    }
    

    public function actionCreate()
    {
        $model = new PayrollPotongan();
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

    /**
     * Updates an existing PayrollPotongan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $IDPotongan
     * @param string $ProductID
     * @return mixed
     */
    public function actionUpdate($ItemID, $PeriodePayroll, $ProductID)
    {
        $model = $this->findModel($ItemID, $PeriodePayroll, $ProductID);
        
        if (Yii::$app->request->IsPost) {
            $model->load(Yii::$app->request->post());
            $model->ProductID = Yii::$app->request->post('prod-id-payroll');

            $tahun = Yii::$app->request->post('Thn');
            $bulan = Yii::$app->request->post('Bulan');

            if($model->IsReguler =='1'){
                $model->PeriodePayroll = 'R';
            }else{
                if($tahun=='' || $bulan=='') {
                    throw new NotFoundHttpException('Data Periode Pembayaran salah');
                }
                $model->PeriodePayroll = $tahun.''.$bulan;
            }

            if (($model = PayrollPotongan::findOne(['ItemID' => $ItemID, 'PeriodePayroll' => $PeriodePayroll, 'ProductID' => $ProductID])) !== null) {
                throw new NotFoundHttpException('Duplikat data, cek kembali ProductID, jenis potongan, dan periode pembayaran');
            }

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
        if (($model = PayrollPotongan::find()
                        ->alias('pt')
                        ->select('pt.ProductID,pt.ItemID,pt.Amount,pt.PeriodePayroll,mp.Nama,mj.Description AS jobdesk,pt.Remark,pt.IsActive,pt.tgl,pt.IsReguler')
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

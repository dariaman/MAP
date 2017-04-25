<?php

namespace app\eprocess\controllers;

use Yii;
use app\eprocess\models\JadwalAbsensiStatusD;
use app\eprocess\models\JadwalAbsensiStatusDSearch;
use app\master\models\MasterJadwalKerja;
use app\operational\models\SOH;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\helpers\Json;

/**
 * JadwalAbsensiStatusDController implements the CRUD actions for JadwalAbsensiStatusD model.
 */
class JadwalAbsensiStatusDController extends Controller
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
     * Lists all JadwalAbsensiStatusD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JadwalAbsensiStatusDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new JadwalAbsensiStatusD();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IDJadwalAbsensiStatusH' => $model->IDJadwalAbsensiStatusH, 'ProductID' => $model->ProductID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdprd()
    {
        $req = Yii::$app->request;
        
        $tgl = $req->post('tgl');
        $bln = $req->post('bulan');
        $thn = $req->post('tahun');
        $pid = $req->post('pid');
        $cusid = $req->post('cusid');
        
        $model = $this->findModelM($tgl, $pid, $cusid);

        if (Yii::$app->request->post()) {
            $model->JadwalKeluar = $req->post('keluar');
            $model->JadwalMasuk = $req->post('masuk');
            $model->UserUpdate = Yii::$app->user->getId();
            $model->DateUpdate = date('Y-m-d h:i:s');
            $model->save();
        } else {
            return $this->redirect("./index.php?r=eprocess/jadwal-absensi-status-d/editp&pid=".$pid."&tgl=".$tgl."&cusid=".$cusid."&tahun=".$thn."&bulan=".$bln);
        }
    }
    
    public function actionDtl()
    {
        
        $searchModel = new JadwalAbsensiStatusDSearch();
        $jdwl = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchProd($jdwl);

        return $this->render('detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionProduct($pid)    {
        return $this->render('editproduct', [
            'model' => $this->findModelP($pid)
        ]);
    }
    
//    public function actionEditp($pid)    {
//        return $this->render('edproduct', [
//            'model' => $this->findModelP($pid)
//        ]);
//    }
    
    public function actionCloseAll($idthn,$idbln,$idtipe,$idtext,$idcus,$idarea)    {
        if($idtipe == 1)        {
            $idtipe = 'AD.ProductID';
        } else if($idtipe == 2)        {
            $idtipe = 'mp.Nama';
        } else {
            $idtipe = '';
        }
        
        if($idtipe == '' && $idtext == '')        {
            $getJAS = SOH::find()
                ->select('AD.ProductID,jas.IDJadwalAbsensiStatusH')
                ->distinct(true)
                ->from('SOH')
                ->innerJoin('SOD','SOD.SOIDH = SOH.SOIDH')
                ->innerJoin('AllocationProductH AH','AH.SOIDH = SOD.SOIDH')
                ->innerJoin('AllocationProductD AD','AD.AllocationProductIDH = AH.AllocationProductIDH')
                ->leftJoin('MasterProduct mp','mp.ProductID = AD.ProductID')
                ->leftJoin('JadwalAbsensiStatusH jas','jas.CustomerID = SOH.CustomerID')
                ->leftJoin('MasterJadwalKerja mj','mj.CustomerID = jas.CustomerID')
                ->where(['SOH.CustomerID'=>$idcus,'SOD.AreaID'=>$idarea])
                ->orderBy('AD.ProductID')
                ->all();
        } else {
            $getJAS = SOH::find()
                ->select('AD.ProductID,jas.IDJadwalAbsensiStatusH')
                ->distinct(true)
                ->from('SOH')
                ->innerJoin('SOD','SOD.SOIDH = SOH.SOIDH')
                ->innerJoin('AllocationProductH AH','AH.SOIDH = SOD.SOIDH')
                ->innerJoin('AllocationProductD AD','AD.AllocationProductIDH = AH.AllocationProductIDH')
                ->leftJoin('MasterProduct mp','mp.ProductID = AD.ProductID')
                ->leftJoin('JadwalAbsensiStatusH jas','jas.CustomerID = SOH.CustomerID')
                ->leftJoin('MasterJadwalKerja mj','mj.CustomerID = jas.CustomerID')
                ->where(['mj.CustomerID'=>$idcus,'jas.AreaID'=>$idarea])
                ->andWhere(['jas.Thn'=>$idthn,'jas.Bln'=>$idbln])
                ->andWhere([$idtipe => $idtext])
                ->orderBy('AD.ProductID')
                ->all();
        }
        
        $JASvalue = \yii\helpers\ArrayHelper::map($getJAS,'ProductID','IDJadwalAbsensiStatusH');

        foreach($JASvalue as $product => $idabs)        {

            $queryProduct = MasterJadwalKerja::find()
                    ->select('ProductID,CustomerID')
                    ->distinct(true)
                    ->where(['ProductID'=>$product])
                    ->all();

            $arrayProduct = \yii\helpers\ArrayHelper::map($queryProduct,'CustomerID','ProductID');
           
            foreach($arrayProduct as $customer => $product)
            {
                $insert =  \app\eprocess\models\JadwalAbsensiStatusD::find()
                        ->where(['IDJadwalAbsensiStatusH' =>$idabs,'ProductID' =>$product  ])
                        ->one();
                $insert->CloseJadwalStatus = 1;
                $insert->CloseJadwalDate = new \yii\db\Expression(' getdate() ');
                $insert->save();
            }
        }

        if($insert->validate())        {
           $valid = "Success";
        } else {
           $valid = "Failure";
        }
       
        return \yii\helpers\Json::encode($valid);
    }
    
    public function actionClosePartial($idarr,$idabs)    {
        $newarr = json_decode($idarr);
         
        foreach($newarr as $val)
        {
            $insert = \app\eprocess\models\JadwalAbsensiStatusD::find()
                    ->where(['IDJadwalAbsensiStatusH' => $idabs,'ProductID' => $val])
                    ->one();
            $insert->CloseJadwalStatus = 1;
            $insert->CloseJadwalDate = new \yii\db\Expression(' getdate() ');
            $insert->save();
        }
        
        if($insert->validate())        {
           $valid = "Success";
        } else {
           $valid = "Failure";
        }
       
        return \yii\helpers\Json::encode($valid);
    }
    
    protected function findModel($IDJadwalAbsensiStatusH, $ProductID)    {
        if (($model = JadwalAbsensiStatusD::findOne(['IDJadwalAbsensiStatusH' => $IDJadwalAbsensiStatusH, 'ProductID' => $ProductID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelP($pid)    {
        if (($model = \app\master\models\MasterProduct::findOne(['ProductID' => $pid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelM($tgl, $pid, $cusid)    {
        if (($model = MasterJadwalKerja::findOne(['CustomerID' => $cusid, 'ProductID' => $pid,'Tgl'=>$tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

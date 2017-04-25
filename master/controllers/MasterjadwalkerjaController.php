<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterJadwalKerja;
use app\master\models\MasterJadwalKerjaSearch;
use app\master\models\MasterProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\operational\models\AllocationProductD;
/**
 * MasterJadwalKerjaController implements the CRUD actions for MasterJadwalKerja model.
 */
class MasterJadwalKerjaController extends Controller
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
     * Lists all MasterJadwalKerja models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterJadwalKerjaSearch();
        $jdwl = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchJadwalH($jdwl);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single MasterJadwalKerja model.
     * @param string $CustomerID
     * @param string $ProductID
     * @param string $Tgl
     * @return mixed
     */
    public function actionView($CustomerID, $ProductID, $Tgl)
    {
        return $this->render('view', [
            'model' => $this->findModel($CustomerID, $ProductID, $Tgl),
        ]);
    }

    public function insertData($csv)
    {
      $date = date("Y-m-d h:i:s");
      $handle = fopen('files/uploads/'.$csv, "r");
            while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
            {
               
               $pdid = $fileop[2];
               $Tgl = $fileop[3];
               $jdwlmsk = $fileop[4];
               $jdwlkluar = $fileop[5];
               $csid = $fileop[0];
               $stat = $fileop[1];
               //print_r($fileop);exit();
               
               $sql = "INSERT INTO MasterJadwalKerja (CustomerID,ProductID, Tgl,Status, JadwalMasuk,JadwalKeluar,UserCrt,DateCrt) VALUES ('$csid','$pdid', '$Tgl','$stat', '$jdwlmsk','$jdwlkluar','sys','$date')";
               $query = Yii::$app->db->createCommand($sql)->execute();

            }
            if ($query) 
            {
                return $this->redirect('./index.php?r=master/master-jadwal-kerja');
            }
    }
    
    /**
     * Creates a new MasterJadwalKerja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterJadwalKerja();

         if ($model->load(Yii::$app->request->post())) {
            
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $basename = 'reportJadwal.'.$model->file->extension;
            $model->file->saveAs('files/uploads/'.$basename);
            $tr = Yii::$app->db->beginTransaction();
            try{
                $this->insertData($basename);
                $tr->commit();
            } catch (Exception $ex) {
                $tr->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterJadwalKerja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CustomerID
     * @param string $ProductID
     * @param string $Tgl
     * @return mixed
     */
    public function actionUpdate($CustomerID, $ProductID, $Tgl)
    {
        $model = $this->findModel($CustomerID, $ProductID, $Tgl);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CustomerID' => $model->CustomerID, 'ProductID' => $model->ProductID, 'Tgl' => $model->Tgl]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterJadwalKerja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CustomerID
     * @param string $ProductID
     * @param string $Tgl
     * @return mixed
     */
    public function actionDelete($CustomerID, $ProductID, $Tgl)
    {
        $this->findModel($CustomerID, $ProductID, $Tgl)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterJadwalKerja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CustomerID
     * @param string $ProductID
     * @param string $Tgl
     * @return MasterJadwalKerja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CustomerID, $ProductID, $Tgl)
    {
        if (($model = MasterJadwalKerja::findOne(['CustomerID' => $CustomerID, 'ProductID' => $ProductID, 'Tgl' => $Tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModeld($absenH)
    {

        if (($model = \app\eprocess\models\JadwalAbsensiStatusH::findOne(['IDJadwalAbsensiStatusH' => $absenH])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelP($pid)
    {

        if (($model = \app\master\models\MasterProduct::findOne(['ProductID' => $pid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDtl($id)
    {
        return $this->render('detail', [
            'model' => $this->findModeld($id)
        ]);
    }
    
    public function actionProduct($pid)
    {
        return $this->render('editproduct', [
            'model' => $this->findModelP($pid)
        ]);
    }
}

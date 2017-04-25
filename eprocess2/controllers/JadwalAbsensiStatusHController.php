<?php

namespace app\eprocess\controllers;

use Yii;
use app\eprocess\models\JadwalAbsensiStatusH;
use app\eprocess\models\JadwalAbsensiStatusHSearch;
use app\master\models\MasterJadwalKerja;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//use yii\helpers\Json;
//use yii\base\Model;

/**
 * JadwalAbsensiStatusHController implements the CRUD actions for JadwalAbsensiStatusH model.
 */
class JadwalAbsensiStatusHController extends Controller {

    public function behaviors() {
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
     * Lists all JadwalAbsensiStatusH models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JadwalAbsensiStatusHSearch();
        $jdwl = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($jdwl);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDtl() {
        $searchModel = new JadwalAbsensiStatusHSearch();
        $jdwl = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchProd($jdwl);

        return $this->render('detail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProduct($idjadwal, $rqid, $sodid, $start, $end) {
        $sql = MasterJadwalKerja::find()
                ->select(['SODID',
                    'SeqProduct',
                    'Tgl',
                    'JadwalMasuk' => 'convert(time(0),JadwalMasuk)',
                    'JadwalKeluar' => 'convert(time(0),JadwalKeluar)'])
                ->where(['=', 'SODID', $sodid])
                ->andWhere(['=', 'SeqProduct', $rqid])
                ->andWhere(['>=', 'Tgl', $start])
                ->andWhere(['<=', 'Tgl', $end]);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $sql,
            'pagination' => ['pagesize' => 32]
        ]);

        $models = $dataProvider->getModels();
        $datax = Yii::$app->request->post('MasterJadwalKerja');
        $pic = Yii::$app->user->identity->username;
        $tr = Yii::$app->db->beginTransaction();
        try {
            if (Yii::$app->getRequest()->isPost) {
                $count = 0;
                foreach ($datax as $index => $item) {
                    $newModel = $this->findModelJadwal($sodid, $rqid, $item['Tgl']);
                    if (!$newModel->isNewRecord) {
                        $newModel->JadwalMasuk = $item['Tgl'] . ' ' . $item['JadwalMasuk'];
                        $newModel->JadwalKeluar = $item['Tgl'] . ' ' . $item['JadwalKeluar'];
                        $newModel->UserCrt = $pic;
                        $newModel->DateCrt = new \yii\db\Expression(' getdate() ');
                        $newModel->save();
//                        echo var_dump($item['Tgl'].' '.$item['JadwalMasuk']);
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "berhasil simpan data dengan {$count} record");
            }
            $tr->commit();
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $sql,
                'pagination' => ['pagesize' => 32]
            ]);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', 'Gagal Simpan Data <br>' . $ex->getMessage());
            $tr->rollBack();
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', 'Gagal Simpan Data <br>' . $ex->getMessage());
            $tr->rollBack();
        }

        return $this->render('editproduct', [
                    'dataProvider' => $dataProvider,
                    'model' => $models,
                    'idjadwal' => $idjadwal,
                    'sodid' => $sodid
        ]);
    }

    public function insertData($csv) {
        $date = date("Y-m-d h:i:s");
        $handle = fopen('files/uploads/' . $csv, "r");
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
            $pdid = $fileop[2];
            $Tgl = $fileop[3];
            $jdwlmsk = $fileop[4];
            $jdwlkluar = $fileop[5];
            $csid = $fileop[0];
            $stat = $fileop[1];
            $area = $fileop[6];

            $sql = "INSERT INTO MasterJadwalKerja (CustomerID,ProductID, Tgl,Status, JadwalMasuk,JadwalKeluar,UserCrt,DateCrt,AreaID) VALUES ('$csid','$pdid', '$Tgl','$stat', '$jdwlmsk','$jdwlkluar','sys','$date',$area)";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        if ($query) {
            return $this->redirect('./index.php?r=eprocess/jadwal-absensi-status-h');
        }
    }

    public function actionCreate() {
        $model = new MasterJadwalKerja();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $basename = 'reportJadwal.' . $model->file->extension;
            $model->file->saveAs('files/uploads/' . $basename);
            $tr = Yii::$app->db->beginTransaction();
            try {
                $this->insertData($basename);
                $tr->commit();
            } catch (Exception $ex) {
                $tr->rollback();
                echo 'Caught exception: ', $ex->getMessage(), "\n";
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCloseJadwalPerCustomer() {
        $tahun = Yii::$app->request->post('tahun', date('o'));
        $bulan = Yii::$app->request->post('bulan', date('m'));

        $usercrt = Yii::$app->user->getId();
        $tglcrt = date('Y-m-d H:i:s');

        if (Yii::$app->request->post('selection_all', 'x') == '1') {
            Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N' exec CloseJadwalPerCustomerAll @thn,@bln,@usercrt,@tglcrt',
                    N'@thn varchar(4),
                    @bln varchar(2),
                    @usercrt varchar(50),
                    @tglcrt datetime', 
                    '$tahun','$bulan','$usercrt','$tglcrt'
                    ")->execute();
        } else {
            foreach (Yii::$app->request->post('selection') as $valdata) {
                Yii::$app->db->createCommand("exec sys.sp_executesql 
                    N' exec CloseJadwalPerCustomer @idjadwal,@usercrt,@tglcrt',
                    N'@idjadwal varchar(13),
                    @usercrt varchar(50),
                    @tglcrt datetime', 
                    '$valdata','$usercrt','$tglcrt'
                    ")->execute();
            }
        }
        return $this->redirect(['index']);
    }

    protected function findModel($AreaID, $Bln, $CustomerID, $Thn) {
        if (($model = JadwalAbsensiStatusH::findOne(['AreaID' => $AreaID, 'Bln' => $Bln, 'CustomerID' => $CustomerID, 'Thn' => $Thn])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelM($tgl, $pid, $cusid) {
        if (($model = MasterJadwalKerja::findOne(['CustomerID' => $cusid, 'ProductID' => $pid, 'Tgl' => $tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelJadwal($sodid, $rqid, $Tgl) {
        if (($model = MasterJadwalKerja::findOne(['SODID' => $sodid, 'SeqProduct' => $rqid, 'Tgl' => $Tgl])) !== null) {
            return $model;
        } else {
            $newModel = new MasterJadwalKerja();
            return $newModel;
        }
    }

}

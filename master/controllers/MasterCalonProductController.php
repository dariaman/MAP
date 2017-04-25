<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterCalonProduct;
use app\master\models\MasterCalonProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\operational\models\NilaiTes;

/**
 * MasterCalonProductController implements the CRUD actions for MasterCalonProduct model.
 */
class MasterCalonProductController extends Controller {

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
     * Lists all MasterCalonProduct models.
     * @return mixed
     */
    public function actionIndex() {

        $postcalon = array_merge(Yii::$app->request->post(), Yii::$app->request->queryParams);
        $searchModel = new MasterCalonProductSearch();
        $dataProvider = $searchModel->search($postcalon);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id) {
        $model = $this->findModelP($id);
            return $this->render('detail', [
                        'model' => $model,
            ]);

    } 
    public function actionDetail($id) {
        return $this->render('nilaites', [
                    'model' => $this->findModelP($id),
        ]);
    }
    
    public function actionCreate() {
        $model = new MasterCalonProduct();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->IDJobDesc == '00001' && $model->SIM == '') {
                \Yii::$app->session->setFlash('error', Yii::t('app', ' Maaf Calon Product driver Tolong isi SIM'));
                return $this->render('create', [
                            'model' => $model,
                ]);
            } elseif ($model->IDJobDesc == '00001' && $model->SIMExpireDate == '') {

                \Yii::$app->session->setFlash('error', Yii::t('app', ' Maaf Calon Product driver Tolong isi SIMExpireDate'));
                return $this->render('create', [
                            'model' => $model,
                ]);
            } elseif ($model->KTPExpireddate == '') {
                \Yii::$app->session->setFlash('error', Yii::t('app', ' Maaf Calon Product Harus ISI KTPExpiredDate '));
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
            $cpid = Yii::$app->db->createCommand("select  'CP' + RIGHT(CONVERT(varchar(6),GETDATE(),112),4) + 
                    RIGHT('000'+CONVERT(varchar(4),ISNULL(max(right(CalonProductID,4)),0)+1),4) 
                FROM MasterCalonProduct
                where SUBSTRING(CalonProductID,3,4)=RIGHT(CONVERT(varchar(6),GETDATE(),112),4) ")->queryScalar();
            $model->CalonProductID = $cpid;
            if ($model->BankID == "") {
                $model->BankID = null;
            }
            
            $id = Yii::$app->user->identity->username;

            $model->UserCrt = $id;
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
            
            if(!$model->validate())
            {
                echo $id;
                echo var_dump($model->getErrors());
                die();
            } else {
                $model->save();
            }
            Yii::$app->session->setFlash('success', 'Data Berhasil ditambahkan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->findModelP($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->DateUpdate = new \yii\db\Expression(' getdate() ');
            $model->UserUpdate = $pic;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    }

    public function actionRecruitment($mcpid) {
        $pic = Yii::$app->user->identity->username;
        try {
            $sqlstring = 'exec Recruitment @IDcalonpRoduct=:CalonProductID, @usercrt=:user';
            $cmd = Yii::$app->db->createCommand($sqlstring);
            $cmd->bindParam(':CalonProductID', $mcpid);
            $cmd->bindParam(':user', $pic);
            $cmd->execute();
            Yii::$app->getSession()->setFlash('success', 'Proses Recruitment Berhasil');
            return $this->redirect(['master-calon-product/index']);
        } catch (\yii\db\Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            return $this->redirect(['master-calon-product/index', 'CalonProductID' => $mcpid]);
        }
    }

    public function actionAdd() {
        $model = new NilaiTes();
        $id = Yii::$app->request->post('idc');
        $pic = Yii::$app->user->identity->username;
        if ((Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $tr = $connection->beginTransaction();
            try {
                $idjenis = Yii::$app->request->post('absen');
                $ceknilai = Yii::$app->request->post('nilai');
                $tgl = Yii::$app->request->post('Tgltes');
                if ($ceknilai == '' || $tgl == '') {
                    \Yii::$app->session->setFlash('error', Yii::t('app', ' Field Tolong Diisi '));
                    return $this->redirect(["detail",'id'=>$id]);
                }
                $cek = Yii::$app->db->createCommand("select count (IDJenisTes) from NilaiTes where IDJenisTes='" . $idjenis . "' and CalonProductID='" . $id . "'")->queryScalar();
                if ($cek == 1) {
                    \Yii::$app->session->setFlash('error', Yii::t('app', ' Maaf CalonProduct Sudah Pernah Mengikuti Tes'));
                    return $this->redirect(["detail",'id'=>$id]);
                }
                $connection->createCommand()
                        ->insert('NilaiTes', [
                            'CalonProductID' => $id,
                            'IDJenisTes' => $idjenis,
                            'TglTes' => Yii::$app->request->post('Tgltes'),
                            'Nilai' => Yii::$app->request->post('nilai'),
                            'UserCrt' => $pic,
                            'DateCrt' => date('Y-m-d h:i:s')])
                        ->execute();

                $nilai1 = \Yii::$app->db->createCommand("select SUM(Nilai) from NilaiTes where CalonProductID='" . $id . "'")->queryScalar();

                $hitung = $nilai1 / 4;
                $connection->createCommand("update MasterCalonProduct SET JumlahNilai=" . $hitung . " where CalonProductID='" . $id . "' ")
                        ->execute();
                $tr->commit();
                
                Yii::$app->getSession()->setFlash('success', 'Sukses menyimpan data');
            } catch (Exception $ex) {
                $tr->rollback();
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
            return $this->redirect(["detail",'id'=>$id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    protected function findModel($id) {
        if (($model = MasterCalonProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan....');
        }
    }

    protected function findModelP($id) {
        if (($model = MasterCalonProduct::find()->where("CalonProductID='" . $id . "'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelN($CalonProductID, $IDJenisTes) {
        if (($model = NilaiTes::findOne(['CalonProductID' => $CalonProductID, 'IDJenisTes' => $IDJenisTes])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

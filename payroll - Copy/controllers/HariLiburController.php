<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\HariLibur;
use app\payroll\models\HariLiburSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\Alert;

/**
 * HariLiburController implements the CRUD actions for HariLibur model.
 */
class HariLiburController extends Controller {

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
     * Lists all HariLibur models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new HariLiburSearch();
        $params = Yii::$app->request->queryParams;
        $query = Yii::$app->request->post();
        $merge = array_merge($params, $query);
        $dataProvider = $searchModel->search($merge);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate() {
        $model = new HariLibur();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
//            echo var_dump(Yii::$app->request->post());
//            echo var_dump($model);
            $cekTgl = Yii::$app->db->createCommand("select Tgl from HariLibur where Tgl='" . $model->Tgl . "'");
            $exec = $cekTgl->queryScalar();
            if ($exec > 0) {

                Alert::begin([
                    'options' => [
                        'class' => 'alert-danger',
                    ],
                ]);

                echo 'anda gagal menyimpan';
                Alert::end();
            } else {
                $model->UserCrt = $pic;
                $model->DateCrt = new \yii\db\Expression(' getdate() ');
                $model->save();
                return $this->render('create', ['model' => $model]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }
    
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserUpdate = $pic;
            $model->DateUpdate = date('Y-m-d h:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->Tgl]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }
    
    protected function findModel($id) {
        if (($model = HariLibur::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

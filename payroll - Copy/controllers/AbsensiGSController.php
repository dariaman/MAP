<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\AbsensiGS;
use app\payroll\models\AbsensiGSSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AbsensiGSController implements the CRUD actions for AbsensiGS model.
 */
class AbsensiGSController extends Controller
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
     * Lists all AbsensiGS models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbsensiGSSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AbsensiGS model.
     * @param string $ProductID
     * @param string $tgl
     * @return mixed
     */
    public function actionView($ProductID, $tgl)
    {
        return $this->render('view', [
            'model' => $this->findModel($ProductID, $tgl),
        ]);
    }

    /**
     * Creates a new AbsensiGS model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AbsensiGS();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ProductID' => $model->ProductID, 'tgl' => $model->tgl]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    protected function findModel($ProductID, $tgl)
    {
        if (($model = AbsensiGS::findOne(['ProductID' => $ProductID, 'tgl' => $tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }   
    
}

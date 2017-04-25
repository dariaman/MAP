<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\BPJSRegistrasi;
use app\operational\models\BPJSRegistrasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BPJSRegistrasiController implements the CRUD actions for BPJSRegistrasi model.
 */
class BPJSRegistrasiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BPJSRegistrasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BPJSRegistrasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->ProductID = $id;

        if ($model->load(Yii::$app->request->post())) {
            if($model->isNewRecord){
                $model->UserCrt = Yii::$app->user->identity->username;
            }else{
                $model->UserUpdate = Yii::$app->user->identity->username;
                $model->DateUpdate = new \yii\db\Expression('getdate()');;
            }
            
            $model->save();
            return $this->redirect(['index']);
        }
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    protected function findModel($id)
    {
        $model = BPJSRegistrasi::findOne($id);
        if ($model === null) {
            $model = new BPJSRegistrasi();
        } 
        return $model;
    }
}

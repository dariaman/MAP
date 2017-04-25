<?php

namespace app\finance\controllers;

use Yii;
use app\finance\models\FakturPajakH;
use app\finance\models\FakturPajakHSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FakturPajakHController implements the CRUD actions for FakturPajakH model.
 */
class FakturPajakHController extends Controller
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
     * Lists all FakturPajakH models.
     * @return mixed
     */
    public function actionIndex()    {
        $searchModel = new FakturPajakHSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()    {
        $model = new FakturPajakH();

        if ($model->load(Yii::$app->request->post())) {            
            $execsp = Yii::$app->db->createCommand("exec CreateFP 
                @entity = :entity ,
                @thnpajak = :thnpajak ,
                @noawal = :noawal ,
                @noakhir = :noakhir,
                @periodestart = :periodestart ,
                @periodeend = :periodeend ,
                @userid = :userid");
            $execsp->bindValue(':entity', $model->EntityID);
            $execsp->bindValue(':thnpajak', $model->TahunPajak);
            $execsp->bindValue(':noawal', $model->NoAwal);
            $execsp->bindValue(':noakhir', $model->NoAkhir);
            $execsp->bindValue(':periodestart', $model->StartPeriod);
            $execsp->bindValue(':periodeend', $model->EndPeriod);
            $execsp->bindValue(':userid', Yii::$app->user->identity->username);            
            $execsp->execute();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
    
    protected function findModel($EntityID, $TahunPajak)    {
        if (($model = FakturPajakH::findOne(['EntityID' => $EntityID, 'TahunPajak' => $TahunPajak])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

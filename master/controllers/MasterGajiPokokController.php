<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterGajiPokok;
use app\master\models\MasterGajiPokokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Component;

/**
 * MasterGajiPokokController implements the CRUD actions for MasterGajiPokok model.
 */
class MasterGajiPokokController extends Controller
{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new MasterGajiPokokSearch();
        $gapok = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($gapok);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
//    public function actionView($ID, $seqID)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($ID, $seqID),
//        ]);
//    }
    
    public function actionCreate()
    {
        $model = new MasterGajiPokok();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $maxid = Yii::$app->db->createCommand("select LEFT(CONVERT(varchar(8),GETDATE(),112),6) + RIGHT('000000' + CONVERT(varchar(7),ISNULL(max(right(GapokID,7)),0) + 1),7) from MasterGajiPokok
                                                    where LEFT(GapokID,6)=LEFT(CONVERT(varchar(8),GETDATE(),112),6)")->queryScalar();
            $model->GapokID = $maxid;
            $model->SeqID = 1;
            $model->UserCrt= $pic;
            $model->DateCrt = new \yii\db\Expression("getdate()");
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Ditambahkan');
            return $this->redirect(["index"]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    public function actionUpdate($gapokid, $seqID){
        $model = $this->findModel($gapokid, $seqID);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserCrt=$pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil diupdate');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
      
    protected function findModel($ID, $seqID) {
        if (($model = MasterGajiPokok::findOne(['GapokID' => $ID, 'SeqID' => $seqID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

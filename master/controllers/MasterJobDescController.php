<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterJobDesc;
use app\master\models\MasterJobDescSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MasterJobDescController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new MasterJobDescSearch();
        $jobdesc = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($jobdesc);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionLists($id){
        $subquery = (new \yii\db\Query)->select("GapokID,max(SeqID) SeqID")->from("MasterGajiPokok")->groupBy("GapokID");
        $countJob = MasterJobDesc::find()
                ->select('mj.IDJobDesc,mj.Description')
                ->from('MasterGajiPokok mg')
                ->join('INNER JOIN',['a'=>$subquery],'a.GapokID = mg.GapokID and a.SeqID = mg.SeqID')
                ->join('LEFT JOIN','MasterArea ma','ma.AreaID = mg.AreaID')
                ->join('LEFT JOIN','MasterJobDesc mj','mj.IDJobDesc = mg.IDJobDesc')
                ->count();
 
        $job = MasterJobDesc::find()
                ->select('mj.IDJobDesc,mj.Description')
                ->from('MasterGajiPokok mg')
                ->join('INNER JOIN',['a'=>$subquery],'a.GapokID = mg.GapokID and a.SeqID = mg.SeqID')
                ->join('LEFT JOIN','MasterArea ma','ma.AreaID = mg.AreaID')
                ->join('LEFT JOIN','MasterJobDesc mj','mj.IDJobDesc = mg.IDJobDesc')
                ->all();

        if($countJob>0){
            echo "<option> Select Job </option>";
            foreach($job as $post){               
                echo "<option value='".$post->IDJobDesc."'>".$post->Description."</option>";
            }
        }
        else{
            echo "<option> - </option>";
        }
        }
    
    public function actionCreate() {
        $model = new MasterJobDesc();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $maxid = Yii::$app->db->createCommand("SELECT RIGHT('0000' + CONVERT(VARCHAR,(ISNULL(MAX(IDJobDesc),0)+1)),5)  FROM MasterJobDesc")->queryScalar();
            $model->IDJobDesc = $maxid;
            $model->UserCrt = $pic;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Ditambahkan');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserUpdate =$pic;
            $model->DateUpdate=new \yii\db\Expression(' getdate() ');
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil diupdate');
            return $this->redirect(['index']);
        } else {
            return $this->render('create',['model' => $model,]);
        }
    }
    
    protected function findModel($id){
        if (($model = MasterJobDesc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan');
        }
    }
}

<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterAbsenType;
use app\master\models\MasterAbsenTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterAbsenTypeController implements the CRUD actions for MasterAbsenType model.
 */
class MasterAbsenTypeController extends Controller
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
     * Lists all MasterAbsenType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterAbsenTypeSearch();
        $absen = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($absen);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterAbsenType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MasterAbsenType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterAbsenType();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            //Yii::$app->db->createCommand("insert into master_absentype values ((select isnull(max(ID),0)+1 from master_absentype),".$model->startAbsen.",".$model->endAbsen.",1,'sys',getdate())")->execute();
            $maxid = Yii::$app->db->createCommand("select right('00'+convert(varchar,isnull(max(right(ID,3)),0)+1),2) FROM MasterAbsenType")->queryScalar();
            $model->ID = $maxid;
//            if($model->StartAbsen <=9||$model->EndAbsen <=9)
//            {
//                $model->StartAbsen=\Yii::$app->db->createCommand("select '0' +RIGHT($model->StartAbsen,1)from MasterAbsenType")->queryScalar();
//                $model->EndAbsen = \Yii::$app->db->createCommand("select '0' +RIGHT($model->EndAbsen,1)from MasterAbsenType")->queryScalar();
//            }
            
            $model->StartAbsen = substr( '0' . $model->StartAbsen, -2) ;
            $model->EndAbsen = substr( '0' . $model->EndAbsen, -2) ; 
            
            $model->UserCrt = $pic;
            $model->DateCrt = new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect('./index.php?r=master/master-absen-type');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterAbsenType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            $model->UserCrt= $pic;
            $model->DateCrt= new \yii\db\Expression(' getdate() ');
            $model->save();
            return $this->redirect('./index.php?r=master/master-absen-type');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the MasterAbsenType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterAbsenType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterAbsenType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

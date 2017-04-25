<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\SuratTilang;
use app\operational\models\SuratTilangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuratTilangController implements the CRUD actions for SuratTilang model.
 */
class SuratTilangController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Lists all SuratTilang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuratTilangSearch();
        $st = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($st);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

      
    public function actionPro()
    {
        $searchModelll = new SuratTilangSearch();
          $sp = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
           $dataProvider = $searchModelll->searchpgw($sp);

        
//        $sp = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
//        $dataProvider = $searchModel->searchpgw($sp);

        return $this->renderAjax('Product', [
            'searchModelll' => $searchModelll,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single SuratTilang model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SuratTilang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SuratTilang();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post()) ) { 
//              print_r(Yii::$app->request->post());
//            die();
          $id = Yii::$app->db->createCommand(" SELECT IDSuratTilang = 'ST'
            +RIGHT(CONVERT(varchar(6),getdate(),112),6)
            +RIGHT('00'+CONVERT(varchar,isnull(max(right(st.IDSuratTilang,3)),0)+1),3)
            FROM SuratTilang st ")->queryScalar();
//          Yii::$app->formatter->asDate($model->tanggal_kejadian, 'long');
          $model->IDSuratTilang=$id;
          $model->UserCrt= $pic;
           $model->ProductID = Yii::$app->request->post('idp');
           $model->TglTilang=\Yii::$app->request->post('TglTilang');
          $model->DateCrt= new \yii\db\Expression(' getdate() ');
//            $model->save();
//          print_r($model);
//          die();
            $save_result = $model->save();
            if ($save_result) {
                Yii::$app->session->setFlash('info', Yii::t('app', 'Object saved'));
                 return $this->redirect('./index.php?r=operational/surat-tilang');
            } else {
                \Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot update data'));
                return $this->redirect('./index.php?r=operational/surat-tilang');
            }


        
//        return $this->redirect('./index.php?r=operational/surat-tilang');
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SuratTilang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            
             $model->save();
              return $this->redirect('./index.php?r=operational/surat-tilang');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the SuratTilang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SuratTilang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuratTilang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

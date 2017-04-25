<?php

namespace app\master\controllers;

use Yii;
use app\master\models\Masterproduct;
use app\master\models\MasterProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterProductController implements the CRUD actions for Masterproduct model.
 */
class MasterProductController extends Controller
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
     * Lists all Masterproduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterProductSearch();
        $postproduct = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($postproduct);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Masterproduct model.
     * @param string $id
     * @return mixed
     */
/**    public function actionView($id)
    {
        $model = $this->findModel($id);
            return $this->render('detail', [
                'model' => $model,
            ]);
    }*/

    /**
     * Creates a new Masterproduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Masterproduct();

        if ($model->load(Yii::$app->request->post()) ) {
            try {
                $prid=yii::$app->db->createCommand("exec GetNextProductID '$model->IDJobDesc' ")->queryScalar();
                $model->ProductID=$prid;
                if($model->NPWP == '') { $model->NPWP = null;}
                if($model->KTP == '') { $model->KTP = null;}
                if($model->KTPExpiredDate == '') { $model->KTPExpiredDate = null;}
                if($model->NoKK == '') { $model->NoKK = null;}
                if($model->SIM == '') { $model->SIM = null;}
                if($model->SIMExpiredDate == '') { $model->SIMExpiredDate = null;}
                if($model->Address == '') { $model->Address = null;}
                if($model->City == '') { $model->City = null;}
                if($model->Zip == '') { $model->Zip = null;}
                if($model->Phone == '') { $model->Phone = null;}
                if($model->Mobile1 == '') { $model->Mobile1 = null;}
                if($model->Mobile2 == '') { $model->Mobile2 = null;}
                $model->save(FALSE);
                Yii::$app->getSession()->setFlash('success', 'ManPower Berhasil disimpan');
                
            } catch (yii\db\Exception $ex) {
                Yii::$app->getSession()->setFlash('error', $ex->errorInfo[2]);
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Masterproduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            $model->UserUpdate = Yii::$app->user->identity->username;
            $model->DateUpdate = new \yii\db\Expression('getdate()');
            if($model->NPWP == '') { $model->NPWP = null;}
            if($model->KTP == '') { $model->KTP = null;}
            if($model->KTPExpiredDate == '') { $model->KTPExpiredDate = null;}
            if($model->NoKK == '') { $model->NoKK = null;}
            if($model->SIM == '') { $model->SIM = null;}
            if($model->SIMExpiredDate == '') { $model->SIMExpiredDate = null;}
            if($model->Address == '') { $model->Address = null;}
            if($model->City == '') { $model->City = null;}
            if($model->Zip == '') { $model->Zip = null;}
            if($model->Phone == '') { $model->Phone = null;}
            if($model->Mobile1 == '') { $model->Mobile1 = null;}
            if($model->Mobile2 == '') { $model->Mobile2 = null;}
            $model->save();
            Yii::$app->session->setFlash('success', 'Data Berhasil Disimpan');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Masterproduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Masterproduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {  
        \Yii::$app->language = 'fr';
        if (($model = Masterproduct::findOne($id)) !== null) {
//           MasterGajiPokok::findOne(['GapokID' => $ID, 'SeqID' => $seqID]))
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionRptProduct()
    {
        $searchModel = new MasterProductSearch();
        $postproduct = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchRptProduct($postproduct);

        return $this->render('rpt_product', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

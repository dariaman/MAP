<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\NilaiTes;
use app\operational\models\NilaiTesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\Alert;

/**
 * NilaiTesController implements the CRUD actions for NilaiTes model.
 */
class NilaiTesController extends Controller
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
     * Lists all NilaiTes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NilaiTesSearch();
        $posttes=array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($posttes);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
      public function actionCalonproduct()
    {
        $searchModell = new NilaiTesSearch();
      $calonproduct=array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
       $dataProvider = $searchModell->SearchcalonProduct($calonproduct);


        return $this->renderAjax('CalonProduct', [
            'searchModell' => $searchModell,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single NilaiTes model.
     * @param string $id
     * @return mixed
     */
    public function actionView($CalonProductID,$IDJenisTes)
    {
        return $this->render('view', [
            'model' => $this->findModel($CalonProductID,$IDJenisTes),
        ]);
    }

    /**
     * Creates a new NilaiTes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NilaiTes();
        $var=Yii::$app->request->post('calonproduct');
        if ($model->load(Yii::$app->request->post())  ) {
//            $query= new Query;
//            $query->select('IDJenisTes')
//                  -> from NilaiTes
////                    
//           print_r($model->IDJenisTes);
//           die();
           $cari= Yii::$app->db->createCommand("select IDJenisTes from NilaiTes where CalonProductID='".$var."' and IDJenisTes='".$model->IDJenisTes."'")->queryScalar();
           if($cari == $model->IDJenisTes)
           {    
               
              Alert::begin([
    'options' => [
        'class' => 'alert-danger',
    ],
]);

      echo 'anda gagal menyimpan';
        Alert::end();

           }
        else {
             $model->CalonProductID = Yii::$app->request->post('calonproduct');
               $model->save();
           
           return $this->redirect('./index.php?r=operational/nilai-tes');
     
         }
         
        }
        
        return $this->render('create', [
                'model' => $model,
            ]);
    }
//             $model->CalonProductID = Yii::$app->request->post('calonproduct');
//              $model->UserCrt='sys';
//              $model->DateCrt=date('Y-m-d h:i:s');
//            $model->save();
////            print_r($model);
////            die();
//           
//           return $this->redirect('./index.php?r=operational/nilai-tes');
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing NilaiTes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($CalonProductID,$IDJenisTes)
    {
        $model = $this->findModel($CalonProductID,$IDJenisTes);

        if ($model->load(Yii::$app->request->post()) ) {
            
             $model->save();
                return $this->redirect('./index.php?r=operational/nilai-tes');
//           return $this->redirect(['view', 'CalonProductID' => $model->CalonProductID, 'IDJenisTes' => $model->IDJenisTes]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the NilaiTes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NilaiTes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CalonProductID,$IDJenisTes)
    {
        if (($model = NilaiTes::findOne(['CalonProductID'=>$CalonProductID,'IDJenisTes'=>$IDJenisTes])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

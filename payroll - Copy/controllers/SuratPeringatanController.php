<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\SuratPeringatan;
use app\payroll\models\SuratPeringatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * SuratPeringatanController implements the CRUD actions for SuratPeringatan model.
 */
class SuratPeringatanController extends Controller
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
     * Lists all SuratPeringatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuratPeringatanSearch();
        $params=Yii::$app->request->queryParams;
        $post= Yii::$app->request->post();
        $parampost=array_merge($params,$post);
        $dataProvider = $searchModel->search($parampost);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
     public function actionProduct()
    {
        $searchModell = new SuratPeringatanSearch();
        $req=Yii::$app->request->queryParams;
        $po=Yii::$app->request->post();
        $reqpo=array_merge($req,$po);
        $dataProvider = $searchModell->Searchproduct($reqpo);

        return $this->render('product', [
            'searchModell' => $searchModell,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single SuratPeringatan model.
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
     * Creates a new SuratPeringatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SuratPeringatan();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())) {
            
            $con=Yii::$app->db;
            $spno=$con->createCommand("SELECT SpNo = 'SP'
                                      +RIGHT(CONVERT(varchar(6),getdate(),112),6)
                                      +RIGHT('00'+CONVERT(varchar,isnull(max(right(spn.SpNo,3)),0)+1),3)
                                       FROM SuratPeringatan spn");
            $value=$spno->queryScalar();
            $request=Yii::$app->request;
            $model->ProductID=$request->post('sp');
            $model->SpDate=$request->post('SPdate');
            $model->SpNo=$value;
            $model->DateCrt=new \yii\db\Expression(' getdate() ');
            $model->UserCrt=$pic;
             $model->save();
            return $this->redirect('index.php?r=payroll/surat-peringatan');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SuratPeringatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->SpNo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SuratPeringatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SuratPeringatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SuratPeringatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuratPeringatan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

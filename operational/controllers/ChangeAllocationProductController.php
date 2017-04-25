<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\ChangeAllocationProduct;
use app\operational\models\ChangeAllocationProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * ChangeAllocationProductController implements the CRUD actions for ChangeAllocationProduct model.
 */
class ChangeAllocationProductController extends Controller
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
     * Lists all ChangeAllocationProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChangeAllocationProductSearch();
        $all=Yii::$app->request->queryParams;
        $prod=Yii::$app->request->post();
        $allprod=  array_merge($all,$prod);
        $dataProvider = $searchModel->search($allprod);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
      public function actionAllocation()
    {
        $searchModell = new ChangeAllocationProductSearch();
        $change=Yii::$app->request->queryParams;
        $allocation=Yii::$app->request->post();
        $changeall=  array_merge($change,$allocation);
        $dataProvider = $searchModell->searchallocation($changeall);
        return $this->renderAjax('allocation', [
            'searchModell' => $searchModell,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChangeAllocationProduct model.
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
     * Creates a new ChangeAllocationProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChangeAllocationProduct();

        if ($model->load(Yii::$app->request->post()) ) {
//             print_r(Yii::$app->request->post());
//            die();
            $konek=Yii::$app->db;
            $id=$konek->createCommand("SELECT ChangeAllocationProductID = 'CAP'
            +RIGHT(CONVERT(varchar(6),getdate(),112),6)
            +RIGHT('00'+CONVERT(varchar,isnull(max(right(ca.ChangeAllocationProductID,3)),0)+1),3)
            FROM ChangeAllocationProduct ca");
            $ID=$id->queryScalar();
            $model->ChangeAllocationProductID=$ID;
            $request=Yii::$app->request;
            $model->AllocationProductID=$request->post('allocation');
            $model->AreaID=$request->post('areaid');
            $model->RefID=$request->post('refid');
            $model->SOID=$request->post('soid');
            $model->ProductID=$request->post('productid');
            $model->JobDescID=$request->post('jobdescid');
            $model->ToProductID=$request->post('toproduct');
            $model->save();
           
            return $this->redirect('index.php?r=operational/change-allocation-product');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChangeAllocationProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ChangeAllocationProductID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ChangeAllocationProduct model.
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
     * Finds the ChangeAllocationProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ChangeAllocationProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChangeAllocationProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

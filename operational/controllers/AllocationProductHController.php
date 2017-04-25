<?php

namespace app\operational\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\operational\models\SOHSearch;
use app\operational\models\AllocationProductD;
use app\operational\models\AllocationProductDOutstanding;
use app\operational\models\AllocationProductH;
use app\operational\models\AllocationProductHSearch;

/**
 * AllocationProductHController implements the CRUD actions for AllocationProductH model.
 */
class AllocationProductHController extends Controller
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
     * Lists all AllocationProductH models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationProductHSearch();
        $soh = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($soh);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationProductH model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModelD($id),
        ]);
    }

    public function actionViewRequest($id)
    {
        return $this->render('viewRequest', [
            'model' => $this->findModelDOut($id),
        ]);
    }
    
    /**
     * Creates a new AllocationProductH model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationProductH();

        if ($model->load(Yii::$app->request->post())) {
            
            $getsoid = Yii::$app->db->createCommand("SELECT AllocationProductIDH = 'APH'
            +RIGHT(CONVERT(varchar(6),getdate(),112),6)
            +RIGHT('0000'+CONVERT(varchar,isnull(max(right(aph.AllocationProductIDH,4)),0)+1),4)
            FROM AllocationProductH aph ")->queryScalar();
            $model->AllocationProductIDH = $getsoid;
            $model->Status = 'D';
            $model->save();
            return $this->redirect('./index.php?r=operational/allocation-product-h');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationProductH model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->AllocationProductIDH]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationProductH model.
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
     * Finds the AllocationProductH model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AllocationProductH the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AllocationProductH::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelD($id)
    {
        if (($model = AllocationProductD::find()->where('AllocationProductIDH = '.$id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelDOut($id)
    {
        if (($model = AllocationProductDOutstanding::find()->where('AllocationProductIDH = '.$id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSoh()
    {
        $searchModel = new SOHSearch();
        $postof = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        $dataProvider = $searchModel->Search($postof);
        
          return $this->render('soh',[
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider,
        ]);
    
    }
                    
    public function actionGetQty($sodid)
    {
        $getareaclass = AllocationProductD::find()
                ->select(['COUNT(AllocationProductDID) as AllocationProductDID'])
                ->where("SODID = '".$sodid."'")
                ->one()
                ;

        echo Json::encode($getareaclass);
    }
}

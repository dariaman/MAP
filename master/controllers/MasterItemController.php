<?php

namespace app\master\controllers;

use Yii;
use app\master\models\MasterItem;
use app\master\models\MasterItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterItemController implements the CRUD actions for MasterItem model.
 */
class MasterItemController extends Controller
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
     * Lists all MasterItem models.
     * @return mixed
     */
    public function actionIndex()
    {
            $searchModel = new MasterItemSearch();
            $item = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
            $dataProvider = $searchModel->search($item);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterItem model.
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
     * Creates a new MasterItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterItem();
        $pic = Yii::$app->user->identity->username;
        if ($model->load(Yii::$app->request->post())  ) {
            $conect=Yii::$app->db;
            $command=$conect->createCommand("select ItemID='ITM'
                                            +right(convert(varchar(6),getdate(),112),6)
                                            +right('00'+convert(varchar,isnull(max(right(it.ItemID,3)),0)+1),3) 
                                            from MasterItem it");
             $val=$command->queryScalar();
             $model->ItemID=$val;
             $model->UserCrt= $pic;
             $model->DateCrt= new \yii\db\Expression(' getdate() ');
             $model->save();
            return $this->redirect('index.php?r=master/master-item');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ItemID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the MasterItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MasterItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

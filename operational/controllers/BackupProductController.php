<?php

namespace app\operational\controllers;

use Yii;
use app\operational\models\BackupProduct;
use app\operational\models\BackupProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BackupProductController implements the CRUD actions for BackupProduct model.
 */
class BackupProductController extends Controller {

    public function behaviors() {
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
     * Lists all BackupProduct models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BackupProductSearch();
        $all = Yii::$app->request->queryParams;
        $prod = Yii::$app->request->post();
        $allprod = array_merge($all, $prod);
        $dataProvider = $searchModel->search($allprod);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($PeriodTo, $ProductIDGS, $TglTugas) {
        return $this->render('view', [
                    'model' => $this->findModel($PeriodTo, $ProductIDGS, $TglTugas),
        ]);
    }

    public function actionCreate() {

        $model = new BackupProduct();
        if ($model->load(Yii::$app->request->post())) {
            
            $backupid = Yii::$app->db->createCommand("
                SELECT LEFT(CONVERT(VARCHAR,GETDATE(),112),6)+RIGHT('000'+ CONVERT(VARCHAR,ISNULL(MAX(RIGHT(backupid,3)),0)+1),3)  FROM BackupProduct
                where SUBSTRING(BackupID,4,6)=left(convert(varchar,getdate(),112),6)
                ")->queryScalar();          
            $model->BackupID = $backupid;
            if (Yii::$app->request->post('prod-id-fix') == NULL || Yii::$app->request->post('prod-id-fix') == "-" || Yii::$app->request->post('prod-id-fix') == "") {
                $model->ProductIDFix = NULL;
            } else {
                $model->ProductIDFix = Yii::$app->request->post('prod-id-fix');
            }
            $model->SODID = Yii::$app->request->post('prod-sodid-fix');
            $model->SeqProduct = Yii::$app->request->post('prod-seqprod-fix');
            $model->ProductIDGS = Yii::$app->request->post('prod-id-gs');
            $model->save();
//            echo var_dump($model);
//            die();
            return $this->redirect('index.php?r=operational/backup-product');
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BackupProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $PeriodTo
     * @param string $ProductIDGS
     * @param string $TglTugas
     * @return mixed
     */
    public function actionUpdate($PeriodTo, $ProductIDGS, $TglTugas) {
        $model = $this->findModel($PeriodTo, $ProductIDGS, $TglTugas);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'PeriodTo' => $model->PeriodTo, 'ProductIDGS' => $model->ProductIDGS, 'TglTugas' => $model->TglTugas]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BackupProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $PeriodTo
     * @param string $ProductIDGS
     * @param string $TglTugas
     * @return mixed
     */
    public function actionDelete($PeriodTo, $ProductIDGS, $TglTugas) {
        $this->findModel($PeriodTo, $ProductIDGS, $TglTugas)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BackupProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $PeriodTo
     * @param string $ProductIDGS
     * @param string $TglTugas
     * @return BackupProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($PeriodTo, $ProductIDGS, $TglTugas) {
        if (($model = BackupProduct::findOne(['PeriodTo' => $PeriodTo, 'ProductIDGS' => $ProductIDGS, 'TglTugas' => $TglTugas])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

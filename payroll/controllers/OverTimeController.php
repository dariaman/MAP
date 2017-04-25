<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\OverTime;
use app\payroll\models\OverTimeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OverTimeController implements the CRUD actions for OverTime model.
 */
class OverTimeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OverTime models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OverTimeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($SeqProduct, $SODID, $tgl)
    {
        if (($model = OverTime::findOne(['SeqProduct' => $SeqProduct, 'SODID' => $SODID, 'tgl' => $tgl])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

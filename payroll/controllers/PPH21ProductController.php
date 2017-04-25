<?php

namespace app\payroll\controllers;

use Yii;
use app\payroll\models\PPH21Product;
use app\payroll\models\PPH21ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PPH21ProductController implements the CRUD actions for PPH21Product model.
 */
class PPH21ProductController extends Controller
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
     * Lists all PPH21Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PPH21ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($Periode, $ProductID)
    {
        if (($model = PPH21Product::findOne(['Periode' => $Periode, 'ProductID' => $ProductID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

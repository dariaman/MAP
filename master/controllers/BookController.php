<?php

namespace app\master\controllers;

use Yii;
use app\master\models\Book;
use app\master\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
    $searchModel = new BookSearch;
    $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
    
 
    // validate if there is a editable input saved via AJAX
    if (Yii::$app->request->post('hasEditable')) {
        $bookId = Yii::$app->request->post('editableKey');
        $model = Book::findOne($bookId);
    
//        print_r(Yii::$app->request->post('editableKey'));
//            print_r($_POST);
//            die();
            
        // store a default json response as desired by editable
        $out = Json::encode(['output'=>'', 'message'=>'']);
 
        // fetch the first entry in posted data (there should 
        // only be one entry anyway in this array for an 
        // editable submission)
        // - $posted is the posted data for Book without any indexes
        // - $post is the converted array for single model validation
        $post = [];
        $posted = current( $_POST['Book']);
        $post['Book'] = $posted;
 
        // load model like any single model validation
        if ($model->load($post)) {
            // can save model or do something before saving model
            $model->save();
 
            // custom output to return to be displayed as the editable grid cell
            // data. Normally this is empty - whereby whatever value is edited by 
            // in the input by user is updated automatically.
            $output = '';
 
            // specific use case where you need to validate a specific
            // editable column posted when you have more than one 
            // EditableColumn in the grid view. We evaluate here a 
            // check to see if buy_amount was posted for the Book model
            if (isset($posted['buy_amount'])) {
               $output =  Yii::$app->formatter->asDecimal($model->buy_amount, 2);
            } 
 
            // similarly you can check if the name attribute was posted as well
            // if (isset($posted['name'])) {
            //   $output =  ''; // process as you need
            // } 
            $out = Json::encode(['output'=>$output, 'message'=>'']);
        } 
        // return ajax json encoded response and exit
        echo $out;
        return;
    }
 
        // non-ajax - render the grid by default
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
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
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

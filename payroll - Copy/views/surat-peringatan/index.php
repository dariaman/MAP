<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\SuratPeringatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Peringatan';
//$this->params['breadcrumbs'][] = $this->title;

?>

<div class="surat-peringatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <?php Pjax::begin(['id'=>'PtlCommentsPjax']) ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'SpNo',
            'SpDate',
            'ProductID',
            'Remark',
//            'ApproveBy',
            // 'ApproveDate',
            // 'UserCrt',
            // 'DateCrt',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);?>
    
    <?php Pjax::end(); ?>
    <p style="float: right">
        <?= Html::a('add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
   
</div>

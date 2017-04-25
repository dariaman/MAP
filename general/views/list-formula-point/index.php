<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\general\models\ListFormulaPointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Formula Points';
$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="list-formula-point-index">
    <h1><center><?= Html::encode($this->title) ?></center></h1>
   <?php 
//   echo $this->render('_search', ['model' => $searchModel]); 
   ?>
    
    <?php Pjax::begin(['id'=>'PtlCommentsPjax'])?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'JenisFormulaPoint',
            'Description:ntext',
//            'UserCrt',
//            'DateCrt',
//            'UserUpdate',
            // 'DateUpdate',
            ['class' => 'yii\grid\ActionColumn','template' => "{update}"],
        ],
    ]); ?>
    <?php Pjax::end(); ?> 
    
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>    
</div>

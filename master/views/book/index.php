<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $gridColumns = [
    // the name column configuration
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'name',
        'pageSummary' => true,
//        'readonly'=>function($model, $key, $index, $widget) {
//            return (!$model->status); // do not allow editing of inactive records
//        },
        'editableOptions'=> function ($model, $key, $index, $widget) {
            return [
                'header' => 'Name', 
                'size' => 'md',
                'asPopover' => false
            ];
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'buy_amount', 
//        'readonly'=>function($model, $key, $index, $widget) {
//            return (!$model->status); // do not allow editing of inactive records
//        },
        'editableOptions' => [
            'header' => 'Buy Amount',
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            'options' => [
//                'pluginOptions' => ['min'=>0, 'max'=>5000]
            ]
        ],
//        'hAlign'=>'right', 
//        'vAlign'=>'middle',
//        'width'=>'100px',
        'format'=>['decimal', 2],
//        'pageSummary' => true
    ],
];
        
        
    echo GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>

</div>

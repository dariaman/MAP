<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\BPJSRegistrasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BPJS Registrasis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bpjsregistrasi-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ProductID',
            'Nama',
            [
                'label'=>'JKK',
                'hAlign'=>'center',
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'JKK',
            ],
            [
                'label'=>'JKM',
                'hAlign'=>'center',
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'JKM',
            ],
            [
                'label'=>'JHT',
                'hAlign'=>'center',
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'JHT',
            ],
            [
                'label'=>'JP',
                'hAlign'=>'center',
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'JP',
            ],
            [
                'label'=>'BPJS',
                'hAlign'=>'center',
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'BPJS',
            ],
            [
                'header' => 'Edit',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
                        ['b-p-j-s-registrasi/update', 'id' => $data['ProductID']],'');
                },
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

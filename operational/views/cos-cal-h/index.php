<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Cost Calc';
?>
<div class="cos-cal-h-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'contentOptions'=>['style'=>'width: 120px;'],
                'label' => 'CostCalcID',
                'format' => 'raw',
                'value' => function($data){        
                    return Html::a($data['CostcalIDH'], ['cos-cal-h/view', 'CostcalIDH'=>$data['CostcalIDH']]); 
                }
            ],
            [
                'label' => 'ID OfferingD',
                'value' => 'OfferingDID',
                'hAlign'=>'center'
            ],
            [
                'label' => 'ID SOD',
                'value' => 'SODID',
                'hAlign'=>'center'
            ],
            [
                'label' => 'CostCalc Date',
                'value' => 'CostcalDate',
                'contentOptions'=>['style'=>'width: 120px;'],
            ],
            'JobDescription',   
            [
                'label' => 'Date Create',
                'value' => 'DateCrt',
                'contentOptions'=>['style'=>'width: 250px;'],
            ],
            [
                'header'=>'Detail',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data){
                   return Html::a('<span class="glyphicon glyphicon-file"></span>',
                            ['cos-cal-d/create', 'CostcalIDH'=>$data['CostcalIDH']]);
                },
            ],
        ],
    ]); ?>
    <?= Html::a('ADD', ['create'], ['class' => 'btn btn-success']) ?>
</div>

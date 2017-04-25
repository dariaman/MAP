<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Faktur Pajak';
?>
<div class="faktur-pajak-h-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'TRNo',
                            'EntityID',
                            'TahunPajak',
                            'TrDate',
                            'NoAwal',
                            'NoAkhir',
                            'StartPeriod',
                            'EndPeriod',
                            [
                                'label'=>'Action',
                                'format' => 'raw',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'contentOptions'=>['style'=>'text-align:center'],
                                'value' => function($data){
                                   return Html::a('<span class="glyphicon glyphicon-check"></span>',
                                            ['faktur-pajak-d/index','TRNo' => $data['TRNo']]);
                                },
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>

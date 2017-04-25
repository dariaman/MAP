<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\finance\models\FakturPajakDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faktur Pajak Details';
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
//                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'NoFakturPajak',
                        'KodeFaktur',
//                        'TRNo',
                        'InvoiceNo',
                        'InvoiceDate',
                        [
//                                'class'=>'kartik\grid\BooleanColumn',
                            'header' => 'Status',
                            'format' => 'raw',
                            'value'=>function($data)
                            {
                                if($data['IsActive'] == 1)
                                {
                                    return '<span class="label label-success">Active</span>';
                                } else {
                                    return '<span class="label label-danger">Not Active</span>';
                                }
                                }
                        ],
                        [
                                'label'=>'Edit',
                                'format' => 'raw',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'contentOptions'=>['style'=>'text-align:center'],
                                'value' => function($data){
                                   return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                            ['create','NoFakturPajak' => $data['NoFakturPajak']]);
                                },
                        ],
                        // 'IsCancel',
                        // 'InvoiceCancel',
                        // 'CancelDate',
                        // 'CancelReason',
                        // 'UserCrt',
                        // 'DateCrt',
                        // 'UserUpdate',
                        // 'DateUpdate',

                    ],
                ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php // Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
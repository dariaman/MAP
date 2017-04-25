<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Absensi Product GS';
?>
<div class="masterproduct-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                 <?php
                    echo $this->render('_searchGS', ['model' => $searchModel]);
                    $yearnw = Yii::$app->request->post('tahun', date('o'));
                    $monthnw = Yii::$app->request->post('bulan', date('m'));
                ?>   
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List ManPower') ?></h1>
                </div>
                <div class="box-body">
                    <?=    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'Product',
                                'format' => 'raw',
                                'value' => 'ProductID'
                            ],
                            [
                                'header' => 'Nama Product',
                                'value' => 'Nama',
                                'contentOptions' => ['style' => 'max-width: 1000px;']
                            ],
                            [
                                'label' => 'JobDesc',
                                'value' => 'MJDesc',
                            ],
                            [
                                'label' => 'Tahun',
                                'value' => 'Thn',
                            ],
                            [
                                'label' => 'Bulan',
                                'value' => 'Bln',
                            ],
                            [
                                'label' => 'IsClose Absen',
                                'width' => '100px',
                                'hAlign' => 'center',
                                'class' => 'kartik\grid\BooleanColumn',
                                'attribute' => 'IsCloseAbsen',
                            ],
                            [
                                'label' => 'CloseAbsen Date',
                                'value' => 'CloseAbsenDate',
                                'width' => '200px',
                                'format' => 'date',
                                'hAlign'=> 'center'
                            ],
                            [
                                'label' => 'Jumlah Absen',
                                'value' => 'jlh',
                                'width' => '100px',
                                'hAlign'=>'right'
                            ],
                            [
                                'label' => 'Edit',
                                'format' => 'raw',
                                'width' => '100px',
                                'hAlign' => 'center',
                                'value' => function($data) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['absensi-customer/generate-absen',
                                                'productid' => $data['ProductID'],
                                                'tahun' => $data['Thn'],
                                                'bulan' => (strlen('0'.$data['Bln']) == 2) ? '0'.$data['Bln'] : $data['Bln'],
                                        ]);
                                    },
                            ],
                        ],
                    ]);
                            ?>
                </div>
            </div>
        </div>
    </div> 
</div>

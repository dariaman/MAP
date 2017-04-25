<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$conversi = new \app\controllers\GlobalFunction();

$this->title = 'Absensi Verifikasi';
?>
<div class="absensi-status-h-index">
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <?=Html::beginForm(['absensi-customer/close-absen-per-customer'],'post');?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label'=>'CustomerID',
                                'value'=> 'CustomerID'
                            ],
                            [
                                'label'=>'Customer Name',
                                'value'=> 'CustomerName'
                            ],

                           [
                               'label'=>'AreaID',
                               'value'=> 'AreaID'
                           ],

                            [
                                'label'=>'Area Name',
                                'value'=> 'AreaName'
                            ],
                            [
                                'label'=>'Action',
                                'format' => 'raw',
                                'value' => function($data) use($bulan,$tahun) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['absensi-customer/dtl',
                                        'idCus' => $data['CustomerID'],
                                        'area'  => $data['AreaID'],
                                        'bulan' => $bulan,
                                        'tahun' => $tahun,
                                    ]);
                                }
                            ]

                        ],
                    ]);
                ?>
                </div>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>
</div>

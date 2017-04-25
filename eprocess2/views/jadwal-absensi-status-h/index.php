<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$conversi = new \app\controllers\GlobalFunction();

$this->title = 'Jadwal Kerja';

?>
<div class="jadwal-absensi-status-h-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <?=Html::beginForm(['jadwal-absensi-status-h/close-jadwal-per-customer'],'post');?>
    <?=Html::hiddenInput('bln',Yii::$app->request->post('tahun',date('m')) ) ?>
    <?=Html::hiddenInput('thn',Yii::$app->request->post('bulan',date('o')) ) ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                               'class' => 'yii\grid\CheckboxColumn'
                            ],
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
                                'label'=>'Bulan',
                                'value' => function($data) use($conversi){
                                    return $conversi->ConversiNamaBulan($data['Bln']);
                                }
                            ],
                            [
                                'label'=>'Tahun',
                                'value'=>'Thn'
                            ],
                            [
                                'label'=>'Action',
                                'format' => 'raw',
                                'value' => function($data){
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['jadwal-absensi-status-h/dtl','idJadwal'=> $data['IDJadwalAbsensiStatusH']]);
                                }
                            ]

                        ],
                    ]);
                ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Close', ['class' =>'btn btn-primary',
                                    'onclick'=>"
                                            var keys = $('#w1.grid-view').yiiGridView('getSelectedRows');
                                            if(keys==''){ 
                                                alert('Tidak ada data yang dipilih');
                                                return false;
                                            }
                "]) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>
    <?php //Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
</div>

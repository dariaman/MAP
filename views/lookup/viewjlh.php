<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
// use yii\bootstrap\Modal;

$this->title = 'Riwayat Absensi';

$conversi = new \app\controllers\GlobalFunction();
?>
<div class="data-pjax">
   <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <p style="text-align:center">Sequence Product : <?= Html::encode($seqid) ?></p>
                     <?php
                        $sql = new \yii\db\Query;
                        $sql->select(['Tgl',
                            'DATENAME(WEEKDAY,Tgl) AS hari',
                            'CONVERT(VARCHAR(5),JamMasuk, 108) AS JamMasuk',
                            'JamKeluar',
                            'CASE WHEN CONVERT(VARCHAR(8),JamMasuk,112)=CONVERT(VARCHAR(8),JamKeluar,112) THEN 1 ELSE 0 END AS IsTgl',
                            'InsRaya','spd','inap'
                            ])
                                ->from(app\payroll\models\AbsensiCustomer::tableName())
                                ->where('SODID=\'' . $sodid . '\' AND Tgl >= \'' . $start . '\' AND Tgl <= \'' . $end . '\'  AND SeqProduct = ' . $seqid . '')
                                ->orderby('Tgl');
                        
                        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                        $dataProvider->pagination->pageSize = 50;
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn',
                                    'header' => 'No'
                                ],
                                [
                                    'header'=>'Tanggal',
                                    'format'=>['date', 'php:d M Y'],
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value'=> 'Tgl',
                                ],
                                [
                                    'header'=>'Hari',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) use($conversi) {
                                        return $conversi->IndoHari($data['hari']);
                                    },
                                ],
                                [
                                    'header'=>'Jam Masuk',
                                    'value' =>'JamMasuk',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center']
                                ],
                                [
                                    'header'=>'Jam Keluar',
                                    'attribute' =>'JamKeluar',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:right'],
                                    'value' => function($data){
                                        if($data['IsTgl'] == 1){
                                            return substr($data['JamKeluar'],11,5);
                                        }else{
                                            return substr($data['JamKeluar'],0,16);
                                        }

                                    }
                                ],
                                [
                                    'class'=>'kartik\grid\BooleanColumn',
                                    'label'=>'Insentif Hari Raya',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data){
                                        if($data['InsRaya'] == 1){ return 1; }
                                    }
                                ],
                                [
                                    'class'=>'kartik\grid\BooleanColumn',
                                    'label' =>'Insentif Perjalanan Dinas',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data){
                                        if($data['spd'] == 1){ return 1; }
                                    }
                                ],
                                [
                                    'class'=>'kartik\grid\BooleanColumn',
                                    'label' =>'Insentif Penginapan',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data){
                                        if($data['inap'] == 1){ return 1; }
                                    }
                                ],
                            ],
                     ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
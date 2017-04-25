<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = 'Absensi Verifikasi';
$conversi = new \app\controllers\GlobalFunction();

$script = <<<SKRIPT
        
    $(function() {
       $('.popupModal').click(function(e) {
         e.preventDefault();
         $('#modal').modal('show').find('.modal-content')
         .load($(this).attr('href'));
       });
    });

SKRIPT;
$this->registerJs($script);

?>
<div class="absensi-customer-index">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">Customer</td>
                            <td>: <b>(<?= $cus[0]['CustomerID']?>)</b> <?= $cus[0]['CustomerName']?> </td>
                        </tr>
                        <tr>
                            <td>Area</td>
                            <td>: <b>(<?= $cus[0]['AreaID']?>)</b> <?= $cus[0]['AreaName']?> </td>
                        </tr>
                        <tr>
                            <td>Periode Absen</td>
                            <td>: <?= $conversi->PeriodeToPeriodeString($tahun.$bulan) ?></td>
                        </tr>
                        <tr>
                            <td>Range Absen</td>
                            <td>: <?= $StartAbsen . ' s/d ' . $EndAbsen ?></td>
                        </tr>      
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List ManPower') ?></h1>
                </div>
                <div class="box-body">
                    <?php
                    
                    yii\bootstrap\Modal::begin(['id' =>'modal','size' => 'modal-lg',]);
                    yii\bootstrap\Modal::end();?>

                    <?= $this->render('_searchProd') ?>
                    <?=Html::beginForm(['absensi-customer/close-absen'],'post');?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax'=>false,
                        'columns' => [
                            [
                              'class' => 'kartik\grid\CheckboxColumn',
                              'rowSelectedClass' => GridView::TYPE_DANGER,
                              // 'contentOptions' => ['style' => 'width:50px;'],
                              'checkboxOptions' => function ($model) use($tahun,$bulan){
                                    if($model['IsCloseAbsen'] == '1') {
                                        return ['value' => '','disabled' =>true];
                                    } else {
                                        return ['value' => $model['SODID']."|".$model['SeqProduct']."|".$tahun.$bulan];
                                    }
                               }
                            ],
                            [
                               'label'=>'SODID',
                               'width'=>'150px',
                               'value'=>'SODID'
                            ],
                            [
                                'label'=>'SeqProductID',
                                'width'=>'100px',
                                'value'=>'SeqProduct',
                                'hAlign'=>'center',
                            ],
                            [
                                'label' => 'Product ID',
                                'width'=>'100px',
                                'value' => 'ProductID',
                                'hAlign'=>'center',
                            ],
                            [
                                'label' => 'Product Name',
                                'value' => 'Nama'
                            ],
                            [
                                'label' => 'Jumlah Absen',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'value' => function($data) use($StartAbsen, $EndAbsen){
                                    return  Html::a($data['jlh'], ['/lookup/lookjlh',
                                            'seqid' => $data['SeqProduct'],
                                            'sodid' => $data['SODID'],
                                            'start' => $StartAbsen,
                                            'end' => $EndAbsen],
                                            ['class' => 'btn btn-success', 'class' => 'popupModal']);                                
                                },
                                'hAlign'=>'right',
                            ],
                            [
                                'label' => 'View Jadwal',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'value' => function($data){
                                    return Html::a('<span class="glyphicon glyphicon-calendar"></span>',
                                    ['/lookup/lookupjadwal','seqid' => $data['SeqProduct'],'sodid' => $data['SODID']],
                                    [ 'class'=>'popupModal']);
                                }
                            ],
                            [
                                'label'=>'CloseAbsen Date',
                                'value'=>'CloseAbsenDate',
                                'width'=>'300px',
                                'hAlign'=>'center',
                                'format'=>['date', 'php:d M Y  H:i']
                            ],
                            [
                                'label'=>'IsClose Absen',
                                'width'=>'100px',
                                'hAlign'=>'center',
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'IsCloseAbsen',
                            ],
                            [
                                'label'=>'Absen (Jam)',
                                'format' => 'raw',
                                'width'=>'50px',
                                'hAlign'=>'center',
                                'value' => function($data) use ($tahun,$bulan){
                                    if($data['IsCloseAbsen'] == '1') {
                                        return '-';
                                    }else {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                            ['product',
                                                'sodid' => $data['SODID'],
                                                'sqid' => $data['SeqProduct'],
                                                'period'=>$tahun.$bulan,
                                                'Ceklist' => 0,
                                            ]);
                                        }
                                    }
                            ],
                            [
                                'label'=>'Absen (Ceklist)',
                                'format' => 'raw',
                                'width'=>'50px',
                                'hAlign'=>'center',
                                'value' => function($data) use ($tahun,$bulan){
                                    if($data['IsCloseAbsen'] == '1') {
                                        return '-';
                                    }else {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                            ['product',
                                                'sodid' => $data['SODID'],
                                                'sqid' => $data['SeqProduct'],
                                                'period'=>$tahun.$bulan,
                                                'Ceklist' => 1,
                                            ]);
                                        }
                                    }
                            ],
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
                <?php // Html::a('Print OT',['print-ot-all','idjadwal' => $idCus],['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>  
</div>

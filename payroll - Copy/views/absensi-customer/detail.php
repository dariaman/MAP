<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Absensi Verifikasi';


$conversi = new \app\controllers\GlobalFunction();


$startcus = $cus[0]['StartAbsen'];
$endcus = $cus[0]['EndAbsen'];

?>
<div class="absensi-customer-index">
    <?=Html::beginForm(['absensi-customer/close-per-product'],'post');?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_searchProd',['model'=> $searchModel]); ?>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">CustomerID</td>
                            <td>: <?= $cus[0]['CustomerID']?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= $cus[0]['CustomerName']?></td>
                        </tr>
                        <tr>
                            <td>AreaID</td>
                            <td>: <?= $cus[0]['AreaID']?></td>
                        </tr>
                        <tr>
                            <td>Area Name </td>
                            <td>: <?= $cus[0]['AreaName']?></td>
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
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax'=>false,
                        'columns' => [
                           [
                              'class' => 'yii\grid\CheckboxColumn',
                              'contentOptions' => ['style' => 'width:50px;'],
                              'checkboxOptions' => function ($model) {
                                   return ['value' => $model['SODID']."|".$model['SeqProduct']];
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
                                'value'=>'SeqProduct'
                            ],
                            [
                                'label' => 'Product ID',
                                'value' => 'ProductID'
                            ],
                            [
                                'label' => 'Product Name',
                                'value' => 'Nama'
                            ],
                            [
                                'label'=>'CloseAbsen Date',
                                'value'=>'CloseAbsenDate',
                                'width'=>'300px',
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
                                'label'=>'Edit',
                                'format' => 'raw',
                                'width'=>'50px',
                                'hAlign'=>'center',
                                'value' => function($data) use ($tahun,$bulan){
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['product',
                                            'sodid' => $data['SODID'],
                                            'sqid' => $data['SeqProduct'],
                                            'period'=>$tahun.$bulan,
                                        ]);
                                    },
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
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>  
</div>

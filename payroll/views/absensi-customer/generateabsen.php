<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

$absen = Yii::$app->request->get('productid', 'xxx');

$year = Yii::$app->request->get('tahun');
$month = Yii::$app->request->get('bulan');

$startabsen = $year . '-' . ($month - 1) . '-' . '16';
$endabsen = $year . '-' . $month . '-' . '15';

$this->title = 'Absensi Product GS';

$prod = Yii::$app->db->createCommand("select mp.ProductID, mp.Nama, ag.IsCloseAbsen,ag.CloseAbsenDate
        from MasterProduct mp
        left join AbsensiStatusGS ag on ag.ProductID=mp.ProductID and ag.Thn='$year' and ag.Bln='$month'
        where mp.ProductID='$absen'")->queryAll();

$conversi = new \app\controllers\GlobalFunction();

 ?>


<div class="absensi-customer-index">
    <?php ActiveForm::begin();?>
    <?= Html::hiddenInput('ProductID', $prod[0]['ProductID']) ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width: 200px;">ProductID</td>
                            <td><?= $prod[0]['ProductID'] ?></td>
                        </tr>
                        <tr>
                            <td>Product Name</td>
                            <td><?= $prod[0]['Nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Periode Absen</td>
                            <td><?= $conversi->PeriodeToPeriodeString($year.$month); ?></td>
                        </tr>
                        <tr>
                            <td>Start Absen</td>
                            <td><?= $startabsen ?></td>
                        </tr>
                        <tr>
                            <td>End Absen</td>
                            <td><?= $endabsen ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?php if($prod[0]['IsCloseAbsen']=='1'){ echo '<b>CLOSED</b>';} else{ echo '-'; } ?></td>
                        </tr>
                        <tr>
                            <td>Status Date</td>
                            <td><?= $prod[0]['CloseAbsenDate'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Hari') ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout'=>"{items}",
                        'pjax'=>false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions'=>['style'=>'width: 30px;']
                            ],
                            [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'rowSelectedClass' => GridView::TYPE_DANGER,
                                'checkboxOptions' => function($model){
                                    if($model['StatusAbsenGS'] == '1' || $model['StatusProductFix'] == '1' || $model['StatusBackupProduct'] == '1') {
                                        return ['value' => $model['tgl'],'disabled' =>true];
                                    }else{
                                        return ['value' => $model['tgl'] ];
                                    }
                                }
                            ],
                            [
                                'label'=>'Tanggal',
                                'attribute'=>'tgl',
                            ],
                            [
                                'label'=>'Hari',
                                'value' => function($data) use($conversi) {
                                    return $conversi->DayToHari($data['tgl']);
                                },
                            ],
                            [
                                'label'=>'Absen GS',
                                'hAlign'=>'center',
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'StatusAbsenGS',
                                'width'=>'150px'
                            ],
                            [
                                'label'=>'Absen ProductFix',
                                'hAlign'=>'center',
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'StatusProductFix',
                                'width'=>'150px'
                            ],
                            [
                                'label'=>'Absen Backup',
                                'hAlign'=>'center',
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'StatusBackupProduct',
                                'width'=>'150px'
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php            
                    if($prod[0]['IsCloseAbsen'] !='1'){ 
                        echo Html::a('Close', ['absensi-customer/close-absen-gs/',
                                                'ProductID'=>$prod[0]['ProductID'],
                                                'period'=>$year.$month,
                                            ], 
                                    ['class' => 'btn btn-success']);
                        echo Html::submitButton('Save', ['class' => 'btn btn-success',
                                                'onclick'=>"
                                                    var keys = $('#w1.grid-view').yiiGridView('getSelectedRows');
                                                    if(keys==''){ 
                                                        alert('Tidak ada data yang dipilih');
                                                        return false;
                                                    }
                                            "]); 
                    }


                    echo Html::a('Back', ['absensi-customer/absen-gs/'], ['class' => 'btn btn-success']);
                ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end();?>
</div>
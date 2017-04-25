<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

$this->title = 'Absensi Verifikasi';
$conversi = new \app\controllers\GlobalFunction();

?>
<div class="jadwal-kerja-index">
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
                            <td style="width:200px;">SODID</td>
                            <td>: <b>(<?= $sqid ?>)</b> <?= $sodid ?></td>
                        </tr>
                        <tr>
                            <td>Product</td>
                            <td>: <b>(<?= $cus[0]['ProductID']?>)</b> <?= $cus[0]['Nama']?></td>
                        </tr>
                        <tr>
                            <td>Periode Absen</td>
                            <td>: <?= $conversi->PeriodeToPeriodeString($period) ?></td>
                        </tr>
                        <tr>
                            <td>Range Absen</td>
                            <td>: <?= $StartAbsen . ' s/d ' . $EndAbsen ?></td>
                        </tr>      
                    </table>
                </div>
            </div>
        </div>
    </div>
    
<div style="width:600px;"> 
    <?php
    $form = ActiveForm::begin();

    echo Html::hiddenInput('SODID', $sodid);
    echo Html::hiddenInput('seqno', $sqid);

    echo GridView::widget([
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
                        if($model['IsHadir'] == '1' ) {
                            return ['value' => $model['tgl'],'checked' =>true];
                        }else{
                            return ['value' => $model['tgl']];
                        }
                    }
                ],
                [
                    'label'=>'Hari',
                    'hAlign'=>'center',
                    'value' => function($data) use($conversi) {
                        return $conversi->IndoHari($data['hari']);
                    },
                ],
                [
                    'label'=>'Tanggal',
                    'attribute'=>'tgl',
                    'hAlign'=>'center',
                ],
                [   // Ini tidak ditampilkan, hanya untuk bisa lempar nilai yaitu array tanggal dengan hari
                    'contentOptions'=>['style'=>'width: 1px;'],
                    'format' => 'raw',
                    'value' => function($model, $key, $index, $grid) {
                        return Html::hiddenInput("DataAbsen[$model[tgl]]",$model['hari']);
                    },
                ],
            ]
        ]); 
    ?>
    </div>
</div>
<?php
    echo Html::submitButton('Save', ['class' =>'btn btn-primary']); 
    ActiveForm::end(); 
    echo "  ";
    echo Html::a('Back', ['absensi-customer/dtl',
                        'idCus'=>$cus[0]['CustomerID'],
                        'area'=>$cus[0]['AreaID'],
                        'bulan'=>substr($period,4,2),
                        'tahun'=>substr($period,0,4),
                    ], ['class' => 'btn btn-success']); 
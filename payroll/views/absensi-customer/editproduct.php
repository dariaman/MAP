<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\checkbox\CheckboxX;

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
    
<div style="width:1200px;"> 
    <?php
    $form = ActiveForm::begin();

    echo Html::hiddenInput('SODID', $sodid);
    echo Html::hiddenInput('seqno', $sqid);

    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'form' => $form,
        'checkboxColumn' => false,
        'actionColumn' => false,
        'formName'=>'absensi',
        'gridSettings' => [
            'floatHeader' => false,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Data Absensi</h3>',
                'type' => GridView::TYPE_PRIMARY,
                'after' =>
                Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-success']) . ' ' .
                Html::a('Back', ['absensi-customer/dtl',
                                    'idCus'=>$cus[0]['CustomerID'],
                                    'area'=>$cus[0]['AreaID'],
                                    'bulan'=>substr($period,4,2),
                                    'tahun'=>substr($period,0,4),
                                ], ['class' => 'btn btn-success'])
            ]
        ],
        'attributes' => [
            'SODID' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['hidden' => true]
            ],
            'SeqProduct' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['hidden' => true]
            ],
            'tgl' => [
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true],
            ],
            'tanggal' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
                'value' => function($m) {
                    return $m['tgl'];
                }
            ],
            'hari' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['hAlign' => GridView::ALIGN_LEFT],
                'value' => function($m) use($conversi) {
                    return app\controllers\GlobalFunction::DayToHari($m['tgl']);
                }
            ],
            'TglMasuk' => [
               'label' => 'Tanggal Masuk',
               'type' => TabularForm::INPUT_WIDGET,
               'widgetClass' => \kartik\widgets\DatePicker::classname(),
               'format' => 'yyyy-mm-dd',
               'columnOptions' => ['hAlign' => GridView::ALIGN_RIGHT],
               'options' => [ 
                   'type' => \kartik\widgets\DatePicker::TYPE_INPUT,
                   'pluginOptions'=>[
                       'format'=>'yyyy-mm-dd',
                       'autoclose'=>true,
                   ]]
           ],
            'JamMasuk' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => MaskedInput::classname(),
                'options' => [
                    'mask' => '99:99',
                    'options' => [
                        'style' => 'width:50px;'
                    ]
                ],
                'columnOptions' => ['width' => '120px','hAlign' => GridView::ALIGN_CENTER],
            ],
           'TglKeluar' => [
               'label' => 'Tanggal Keluar',
               'type' => TabularForm::INPUT_WIDGET,
               'widgetClass' => \kartik\widgets\DatePicker::classname(),
               'format' => 'yyyy-mm-dd',
               'columnOptions' => ['hAlign' => GridView::ALIGN_RIGHT],
               'options' => [ 
                   'type' => \kartik\widgets\DatePicker::TYPE_INPUT,
                   'pluginOptions'=>[
                       'format'=>'yyyy-mm-dd',
                       'autoclose'=>true,
                   ]]
           ],
            'JamKeluar' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => MaskedInput::classname(),
                'options' => [
                    'mask' => '99:99',
                    'options' => [
                        'style' => 'width:50px;'
                    ]
                ],
                'columnOptions' => ['width' => '120px','hAlign' => GridView::ALIGN_CENTER],
            ],
            'InsRaya' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => CheckboxX::classname(),
                'label' => 'Insentif Hari Raya',
                'options' => [
                    'pluginOptions' => [
                        'threeState' => false,
                        'size' => 'sm'
                    ]
                ],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
            ],
            'spd' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => CheckboxX::classname(),
                'label' => 'Insentif Luar Kota',
                'options' => [
                    'pluginOptions' => [
                        'threeState' => false,
                        'size' => 'sm'
                    ]
                ],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
            ],
            'inap' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => CheckboxX::classname(),
                'label' => 'Insentif Inap',
                'options' => [
                    'pluginOptions' => [
                        'threeState' => false,
                        'size' => 'sm'
                    ]
                ],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
            ],
        ]
    ]);
    ActiveForm::end(); ?>
    </div>
</div>

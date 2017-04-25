<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

$conversi = new \app\controllers\GlobalFunction();
$upload = new \app\payroll\models\CsvUpload();

$this->title = 'Absensi Verifikasi';
?>
<div class="absensi-status-h-index">
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
    <?= $this->render('_search', ['model' => $searchModel,'bulan' => $bulan,'tahun' => $tahun]); ?>

<div class="box-header with-border">
    <h4 style="text-align: right;" ><b>Periode : <?= $conversi->PeriodeToPeriodeString($tahun.$bulan) ?></b></h4>
</div>
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
                    ]).'  '.
                    Html::a('<span class="glyphicon glyphicon-download"></span>',['absensi-customer/download-absen',
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
    </div></div></div></div>
    <?= Html::endForm();?>
<?php
    Modal::begin([
        'header'=>'Upload Data Absensi Periode <b>'.$conversi->PeriodeToPeriodeString($tahun.$bulan).'</b>',
        'size' => 'modal-lg',
        'toggleButton' => [
            'label'=>'Upload Absensi', 'class'=>'btn btn-success'
        ],
    ]);
        $form = ActiveForm::begin([
                'action'=>['absensi-customer/upload-absen'],
                'method'=>'post',
                'options'=>['enctype'=>'multipart/form-data']
            ]);

        echo $form->field($upload, 'periode')->hiddenInput(['value'=>$tahun.$bulan])->label(false);
        echo $form->field($upload, 'file')->widget(FileInput::classname(), [
            'options'=>['accept'=>'csv/*'],
            'pluginOptions'=>[
                                'allowedFileExtensions'=>['csv'],
                                'showPreview' => false, 
                            ]
        ]);
    ActiveForm::end();
    Modal::end();
?>    
</div>
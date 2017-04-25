<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

$this->title = 'Absensi Verifikasi';
$conversi = new \app\controllers\GlobalFunction();

// $sql = "SELECT sd.SODID,gl.SeqProduct,mc.CustomerID,mc.CustomerName
//         FROM dbo.SOD sd
//         LEFT JOIN dbo.OfferingD od ON od.OfferingDID = sd.OfferingDID
//         LEFT JOIN dbo.OfferingH oh ON oh.OfferingIDH = od.OfferingIDH
//         LEFT JOIN dbo.GoLiveProduct gl ON gl.SODID = sd.SODID AND gl.SeqProduct = '$seq'
//         LEFT JOIN dbo.MasterCustomer mc ON mc.CustomerID = oh.CustomerID
//         LEFT JOIN dbo.MasterArea ma ON ma.AreaID = od.AreaID
//         WHERE sd.SODID = '$sodid' AND oh.CustomerID = '$idCus' AND ma.AreaID = '$idarea'";

// $prod = Yii::$app->db->createCommand($sql)->queryAll();

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
                            <td style="width:200px;">SODID</td>
                            <td>: <?= '' ?></td>
                        </tr>
                        <tr>
                            <td>SeqProductID </td>
                            <td>: <?= '' ?></td>
                        </tr>
                        <tr>
                            <td style="width:200px;">CustomerID</td>
                            <td>: <?= '' ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= '' ?></td>
                        </tr>
                        <tr>
                            <td>Start Absen</td>
                            <td>: <?= '' ?></td>
                        </tr>
                        <tr>
                            <td>End Absen</td>
                            <td>: <?= '' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    

<!--<table class="table table-striped table-bordered">-->

    <?php $form = ActiveForm::begin(); ?>
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
                    // 'checkboxOptions' => function($model){
                    //     if($model['StatusAbsenGS'] == '1' || $model['StatusProductFix'] == '1' || $model['StatusBackupProduct'] == '1') {
                    //         return ['value' => $model['tgl'],'disabled' =>true];
                    //     }else{
                    //         return ['value' => $model['tgl'] ];
                    //     }
                    // }
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
                    // 'class' => 'kartik\grid\EditableColumn',
                    // 'label'=>'Jam Masuk',
                    // 'hAlign'=>'center',
                    'attribute' => 'JamMasuk',
                    'format' => 'raw',
                    'label' => 'JamMasuk',

                    // 'attribute'=>'JamMasuk',
                    'value'=> function($model)
                    {
                        return MaskedInput::widget([
                            // 'model' => $model,
                            // 'attribute' => 'JamMasuk',
                            // 'name' => 'ip_address',
                            'mask' => '99',
                        ]);
                    }
                ],
                [
                    'label'=>'Jam JamKeluar',
                    'hAlign'=>'center',
                    'format' => 'raw',
                    'value'=> function($model)
                    {
                        return Html::textInput('', substr($model['JamKeluar'], 11, 5));
                    }
                ],
            ]
        ]) ?>
        <?php ActiveForm::end();  ?>
</div>

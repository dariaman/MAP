<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use yii\widgets\MaskedInput;

//use yii\base\Model;

$this->title = 'Jadwal Kerja';
$conversi = new \app\controllers\GlobalFunction();
$sql = "select jd.IDJadwalAbsensiStatusH,
	jh.CustomerID,
        mc.CustomerName,
        jh.Thn,
	jh.Bln,
	mb.StartAbsen,jd.*,
	mb.EndAbsen,
        ma.Description as AreaDesc
    from JadwalAbsensiStatusD jd
    left join JadwalAbsensiStatusH jh on jh.IDJadwalAbsensiStatusH=jd.IDJadwalAbsensiStatusH
    left join MasterCustomer mc on mc.CustomerID=jh.CustomerID
    left join MasterAbsenType mb on mb.ID=mc.IDAbsenType
    left join MasterArea ma on ma.AreaID = jh.AreaID
    where jh.IDJadwalAbsensiStatusH='$idjadwal'
    and jd.SODID='$sodid'";
$prod = Yii::$app->db->createCommand($sql)->queryAll();
?>
<div class="jadwal-kerja-index">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>SODID </td>
                            <td>: <?= $prod[0]['SODID'] ?></td>
                        </tr>
                        <tr>
                            <td>SeqProductID </td>
                            <td>: <?= $prod[0]['SeqProductID'] ?></td>
                        </tr>
                        <tr>
                            <td style="width:200px;">CustomerID</td>
                            <td>: <?= $prod[0]['CustomerID'] ?></td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Customer Area</td>
                            <td>: <?= $prod[0]['AreaDesc'] ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= $prod[0]['CustomerName'] ?></td>
                        </tr>

                        <tr>
                            <td>Periode Absensi</td>
                            <td>: <?= $conversi->PeriodeToPeriodeString($prod[0]['Thn'] . $prod[0]['Bln']) ?></td>
                        </tr>
                        <tr>
                            <td>Start Absen</td>
                            <td>: <?= Yii::$app->request->get('start','xxx'); ?></td>
                        </tr>
                        <tr>
                            <td>End Absen</td>
                            <td>: <?= Yii::$app->request->get('end','xxx'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    

    <?php
    $form = ActiveForm::begin();
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'form' => $form,
        'checkboxColumn' => false,
        'actionColumn' => false,
        'gridSettings' => [
            'floatHeader' => false,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Data Jadwal Kerja</h3>',
                'type' => GridView::TYPE_PRIMARY,
                'after' =>
                Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-success']) . ' ' .
                Html::a('Back', '', ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "])
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
            'SODID' => [
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            'SeqProduct' => [
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            'Tgl' => [
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            'tanggal' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['width' => '180px', 'hAlign' => GridView::ALIGN_CENTER],
                'value' => function($m) {
            return $m['Tgl'];
        }
            ],
            'hari' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['width' => '150px', 'hAlign' => GridView::ALIGN_CENTER],
                'value' => function($m) use($conversi) {
            return app\controllers\GlobalFunction::IndoHari($m['hari']);
        }
            ],
            'JadwalMasuk' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => MaskedInput::classname(),
                'options' => [
                    'mask' => '99:99',
                    'options' => [
                        'style' => 'width:100px;',
                    ]
                ],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
            ],
            'JadwalKeluar' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => MaskedInput::classname(),
                'options' => [
                    'mask' => '99:99',
                    'options' => [
                        'style' => 'width:100px;'
                    ]
                ],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER],
            ],
        ]
    ]);
    ?>
    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Offering';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#offeringheaderPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="offering-h-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" style="overflow:auto;">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id' => 'offeringheaderPjax']); ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'label' => 'ID Offering Header',
                                'format' => 'raw',
                                'width' => '150px',
                                'value' => function($data) {
                //                    return Html::a($data['OfferingIDH'], ['offering-d/view', 'OIDH' => $data['OfferingIDH']]);
                                    return Html::a($data['OfferingIDH'], ['offering-d/viewofdet',
                                        'OIDH' => $data['OfferingIDH']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Check Offering Detail']);
                                }
                                    ],
                                    [
                                        'label' => 'ID SOH',
                                        'value' => 'SOIDH',
                                        'hAlign' => 'center'
                                    ],
                                    [
                                        'header' => 'Tanggal Offering',
                                        'width' => '150px',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'contentOptions' => ['style' => 'text-align:center'],
                                        'value' => 'OfferingDate'
                                    ],
                                    [
                                        'label' => 'JobDesc',
                                        'value' => 'JobDesc'
                                    ],
                                    [
                                        'header' => 'CustomerName',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'value' => 'CustomerName'
                                    ],
                                    [
                                        'header' => 'Nomor Surat',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'value' => 'NoSurat'
                                    ],
                                    [
                                        'header' => 'Status',
                                        'format' => 'raw',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'contentOptions' => ['style' => 'text-align:center'],
                                        'value' => function($data) {
                                    if ($data['Status'] == 'D') {
                                        return '<span class="label label-warning">Draft</span>';
                                    } else if ($data['Status'] == 'RFA') {
                                        return '<span class="label label-primary">Request for Approval</span>';
                                    } else if ($data['Status'] == 'A') {
                                        return '<span class="label label-success">Approved</span>';
                                    }
                                }
                                    ],
                                    [
                                        'header' => 'Detail',
                                        'format' => 'raw',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'contentOptions' => ['style' => 'text-align:center'],
                                        'value' => function($data) {
                                    return Html::a('<span class="glyphicon glyphicon-file"></span>', ['offering-d/create', 'OIDH' => $data['OfferingIDH']]);
                                    },
                                    ],
                                    [
                                        'header' => 'Delete',
                                        'format' => 'raw',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'contentOptions' => ['style' => 'text-align:center'],
                                        'value' => function($data) {
                                            if($data['Status'] != 'D')
                                            {
                                                return '-';
                                            } else {
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['offering-h/delete-off', 'OIDH' => $data['OfferingIDH']],['data-confirm' => 'Are you sure you want to delete this Offering ?']);
                                            }
                                        },
                                    ],
                                    [
                                        'label' => 'Print',
                                        'format' => 'raw',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'contentOptions' => ['style' => 'text-align:center'],
                                        'value' => function($data) {
                                    $fetchofd = \app\operational\models\OfferingD::find()->where(['OfferingIDh' => $data['OfferingIDH']])->one();
                                    if (count($fetchofd) == 0 OR $data['Status'] != 'A') {
                                        return '-';
                                    } else {
                                        return Html::a('<span class="glyphicon glyphicon-print"></span>', ['exportoff', 'ofidh' => $data['OfferingIDH']]);
                                    }
                                },
                                    ]
                                ],
                            ]);
                            ?>
                <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>          
</div>


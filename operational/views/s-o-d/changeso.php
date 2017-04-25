<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

//use yii\data\ActiveDataProvider;

$this->title = 'Change SO CostCal ';

$idsod = Yii::$app->request->get('id');
$yearnw = date('o');
$monthnw = date('m');
?>



<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin(['action' => ['change-so-cc','id'=>$idsod], 'method' => 'post']); ?>
    <input type="hidden" name="idsod" value="<?= Yii::$app->request->get('id') ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width: 200px">Efektif Periode Perubahan</td>
                            <td>
                                <?= Html::dropDownList('bulan', $monthnw, ['01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['prompt' => 'Select Month', 'class' => 'form-control', 'id' => 'month']);
                                ?>
                                <?= Html::dropDownList('tahun', $yearnw, [$yearnw - 1 => $yearnw - 1, $yearnw => $yearnw], ['prompt' => 'Select Year', 'class' => 'form-control', 'id' => 'year']); ?>
                            </td>
                        </tr>
                    </table>   
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode("List Cost Calc") ?></h1>
                </div>
                <div class="box-body">
                    <?php
                    $sql = new \yii\db\Query;
                    $sql->select('sc.BiayaID,mb.Description,sc.Amount,sc.Remark,sc.Time,sc.IsManagementFee,sc.TipeTagihan,mb.TipeBiaya')
                            ->from(['sc' => app\operational\models\SOCostCalc::tableName()])
                            ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'sc.BiayaID = mb.BiayaID')
                            ->where("sc.SODID='$idsod'")
                            ->orderBy('mb.SeqNo');

                    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                    $dataProvider->pagination->pageSize = 100;

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}",
                        'pjax' => false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                'contentOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center; width:500px;'],
                                'label' => 'Biaya Name',
                                'attribute' => 'Description',
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center; width:500px;'],
                                'contentOptions' => ['style' => 'text-align:right'],
                                'attribute' => 'Amount',
                                'format' => 'raw',
                                'value' => function($data) {
                            if ($data['TipeBiaya'] == 'MGM1' OR $data['TipeBiaya'] == 'MGM2' OR $data['TipeBiaya'] == 'BPJS') {
                                return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 5, 'style' => "width:85px;text-align:right"]) . " %";
                            } else if ($data['BiayaID'] == 'LMB00005') {
                                return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 1, 'style' => "width:35px;text-align:right"]) . " Jam";
                            } else if ($data['BiayaID'] == 'THR00001') {
                                return Html::hiddeninput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                            }  else {
                                return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                            }
                        }
                            ],
                            [
                                'format' => 'raw',
                                'header' => 'Management<br>Fee',
                                'contentOptions' => ['style' => 'text-align:center;width:100px;'],
                                'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                'value' => function($data) {
                            if ($data['BiayaID'] == 'UMP00001') {
                                return '';
                            } else if ($data['TipeBiaya'] == '3NFIX') {
                                return '';
                            } else if ($data['TipeBiaya'] == 'LMB') {
                                return '';
                            } else if ($data['BiayaID'] == 'M1000001') {
                                return '';
                            } else if ($data['BiayaID'] == 'M5000001') {
                                return '';
                            } else {
                                return Html::checkbox('coscal[' . $data['BiayaID'] . '][ismfee]', $data['IsManagementFee']);
                            }
                        }
                            ],
                            [
                                'header' => 'Time',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center; width:50px;'],
                                'value' => function($data) {
                            if ($data['TipeBiaya'] == 'LMB') {
                                return yii\widgets\MaskedInput::widget([
                                            'name' => 'coscal[' . $data['BiayaID'] . '][time]',
                                            'mask' => '99:99',
                                            'value' => $data['Time'],
                                            'options' => [
                                                'style' => 'width:80px;'
                                            ]
                                ]);
                            } else {
                                return '';
                            }
                        },
                            ],
                            [
                                'label' => 'Tipe Pembayaran',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center; width:150px;'],
                                'value' => function($data) {
                            if ($data['BiayaID'] == 'THR00001') {
                                return Html::radioList('coscal[' . $data['BiayaID'] . '][tipetagihan]', $data['TipeTagihan'], ['B' => 'Bulanan', 'T' => 'Tahunan']);
                            } else if ($data['BiayaID'] == 'SRG00001') {
                                return Html::radioList('coscal[' . $data['BiayaID'] . '][tipetagihan]', $data['TipeTagihan'], ['B' => 'Bulanan', 'T' => 'Tahunan']);
                            } else if ($data['BiayaID'] == 'TRN00001') {
                                return Html::radioList('coscal[' . $data['BiayaID'] . '][tipetagihan]', $data['TipeTagihan'], ['B' => 'Bulanan', 'T' => 'Tahunan']);
                            } else if ($data['BiayaID'] == 'CMC00001') {
                                return Html::radioList('coscal[' . $data['BiayaID'] . '][tipetagihan]', $data['TipeTagihan'], ['B' => 'Bulanan', 'T' => 'Tahunan']);
                            } else {
                                return '';
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'Remark',
                                'format' => 'raw',
                                'value' => function($data) {
                            return Html::textInput('coscal[' . $data['BiayaID'] . '][remark]', $data['Remark'], ['class' => 'form-control medbox display-block',
                                        'style' => 'text-align:left;width:300px']);
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
                <?= Html::submitButton('Request For Approval', ['class' => 'btn btn-success']); ?>
                <?php
        //        =Html::a('Cancel RFA', (['s-o-d/create', 'soidh' => Yii::$app->request->get('idsoh')]), ['class' => 'btn btn-success']) 
                ?>
                <?= Html::a('Back', ['s-o-d/create', 'soidh' => Yii::$app->request->get('idsoh')], ['class' => 'btn btn-success',]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

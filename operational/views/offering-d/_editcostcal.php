<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Edit Offering Detail';
$sql = 'select oh.OfferingIDH,
            oh.OfferingDate,
            oh.NoSurat,
            oh.IDJobDesc,
            oh.IsApprove,
            oh.SOIDH,
            mj.Description JobDesc,
            oh.Status,
            od.AreaID,
            od.Class
        from OfferingH oh
        left join OfferingD od on od.OfferingIDH = oh.OfferingIDH
        left join MasterJobDesc mj on oh.IDJobDesc=mj.IDJobDesc
        where oh.OfferingIDH=\'' . $OFIH . '\' and od.OfferingDID=\'' . $OFID . '\'';
$modelOFH = app\operational\models\OfferingH::findBySql($sql)->one();

//$masterjob = \app\master\models\MasterArea::find()->select('AreaID,Description')->all();
//$mjob = app\master\models\MasterJobDesc::find()->where(['IDJobDesc' => $model->IDJobDesc])->one();
//$mjd = $mjob['Description'];

$script = <<<SKRIPT
                
// ============================================== js Area ===========================================//      
     
$('#offeringh-areaid').change(function(){
    var area = $('#offeringh-areaid').val();
    var job='$modelOFH->IDJobDesc' ;
        
    $.get('index.php?r=operational/offering-h/get-gapok',{ idarea:area, jobid:job }, 
        function(data){
            var datax = $.parseJSON(data);
            var amount = datax.UMP;
              $('#ump-grid').attr('value',datax.UMP);

   });
});        

 // ============================================== js getValueUMP from Area combobox ===========================================//       
SKRIPT;

$this->registerJs($script);
//$modelarea = \app\master\models\MasterArea::findBySql($area)->all();

$masterareaaa = app\master\models\MasterArea::find()
        ->select('ma.AreaID,ma.Description')
        ->from('MasterArea ma')
        ->innerJoin('(select distinct(AreaID) AreaID from MasterGajiPokok 
            where IDJobDesc=\''. $modelOFH->IDJobDesc.'\') maa', 'maa.AreaID=ma.AreaID')
        ->all();

//echo var_dump($modelarea);
//die();
//$arrayarea = ArrayHelper::map($modelarea, 'AreaID', 'Description');

$form = ActiveForm::begin(['action' => ['offering-d/save-edit-coscal'], 'method' => 'post']);
?>


<div class="offering-d-form">
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">OfferingDID</td>
                            <td>: <label><?= $OFID ?> </label></td>
                        </tr>
                        <tr>
                            <td>OfferingIDH</td>
                            <td>: <label><?= $OFIH ?> </label></td>
                        </tr>
                        <tr>
                            <td>Offering Date </td>
                            <td>: <?= $modelOFH->OfferingDate ?></td>
                        </tr>
                        <tr>
                            <td>No Surat</td>
                            <td>: <?= $modelOFH->NoSurat ?></td>
                        </tr>
                        <tr>
                            <td>Job Description </td>
                            <td>: <?= $modelOFH->JobDesc ?></td>
                        </tr>
                        <tr>
                            <td>Status </td>
                            <td>: <?php
                                switch ($modelOFH->Status) {
                                    case 'D' : echo 'Draft';
                                        break;
                                    case 'RFA' : echo 'Request For Approval';
                                        break;
                                    case 'C' : echo 'Correction';
                                        break;
                                    case 'A' : echo 'Approve';
                                        break;
                                    default : echo 'xxx';
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td >Area</td>
                            <td>
                                <?=
                                $form->field($modelOFH, 'AreaID')->widget(Select2::classname(), ['data' => ArrayHelper::map($masterareaaa, 'AreaID', 'Description'),
                                    'options' => ['placeholder' => 'Select a state ...', 'style' => 'width:200px;'],])->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Class</td>
                            <td><?= Html::dropDownList('Class', $modelOFH->Class, ['A' => 'A', 'B' => 'B'], ['prompt' => 'Pilih Class', 'class' => 'form-control']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Cost Calc') ?></h1>
                </div>
                <div class="box-body">
                    <?php
                    $sql = new \yii\db\Query;
                    $sql->select('cc.OfferingDID,mb.Description,cc.Amount,cc.Remark,cc.Time,cc.IsManagementFee,cc.TipeTagihan,cc.BiayaID,mb.TipeBiaya,cc.Percentage')
                            ->from(['cc' => app\operational\models\CosCalc::tableName()])
                            ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'cc.BiayaID = mb.BiayaID')
                            ->where('cc.OfferingDID=\'' . $OFID . '\'')
                            ->orderBy('mb.SeqNo');

                    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                    $dataProvider->pagination->pageSize = 100;


                    echo Html::hiddenInput('OfferingIDH', $OFIH);
                    echo Html::hiddenInput('OfferingDID', $OFID);

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}",
                        'pjax' => false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width: 30px;'],
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 100px;'],
                                'label' => 'Biaya Name',
                                'attribute' => 'Description',
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                                'contentOptions' => ['style' => 'text-align:right'],
                                'attribute' => 'Amount',
                                'format' => 'raw',
                                'value' => function($data) {
                            if ($data['TipeBiaya'] == 'MGM1' OR $data['TipeBiaya'] == 'MGM2' OR $data['TipeBiaya'] == 'BPJS') {
                                return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', ($data['Percentage']  == NULL)? round($data['Amount'],2): round($data['Percentage'],2), ['class' => 'form-control', 'maxlength' => 5, 'style' => "width:85px;text-align:right"]) . " %";
                            } else if ($data['BiayaID'] == 'LMB00005') {
                                return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 1, 'style' => "width:35px;text-align:right"]). " Jam";
                            } else if ($data['BiayaID'] == 'UMP00001') {
                                return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'id' => 'ump-grid', 'readonly' => true, 'maxlength' => 10, 'style' => "text-align:right"]);
                            } else if ($data['BiayaID'] == 'THR00001' OR $data['BiayaID'] == 'PPH00001') {
                                return Html::hiddeninput('coscal[' . $data['BiayaID'] . '][amount]', '0', ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                            } else {
                                return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', round($data['Amount'],2), ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                            }
                        }
                            ],
                            [
                                'label' => 'IsManagementFee',
                                'format' => 'raw',
                                'width' => '100px',
                                'hAlign' => 'center',
                                'value' => function($data) {
                                    if ($data['BiayaID'] == 'UMP00001' OR $data['TipeBiaya'] == '3NFIX' OR $data['TipeBiaya'] == 'LMB' OR $data['BiayaID'] == 'M1000001' OR $data['BiayaID'] == 'M5000001' OR $data['TipeBiaya'] == 'LMP') {
                                        return '';
                                    } else {
                                        return Html::checkbox('coscal[' . $data['BiayaID'] . '][ismfee]', $data['IsManagementFee']);
                                    }
                                }
                            ],
                            [
                                'header' => 'Time',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center; width:10px;'],
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
                                'contentOptions' => ['style' => 'text-align:center;width:100px;'],
                            ],
                            [
                                'label' => 'Tipe Pembayaran',
                                'format' => 'raw',
                                'width' => '100px',
                                'value' => function($data) {
                                    if ($data['BiayaID'] == 'THR00001' OR $data['BiayaID'] == 'SRG00001' OR $data['BiayaID'] == 'TRN00001' OR $data['BiayaID'] == 'CMC00001') {
                                        return Html::radioList('coscal[' . $data['BiayaID'] . '][tipetagihan]', $data['TipeTagihan'], ['B' => 'Bulanan', 'T' => 'Tahunan']);
                                    } else {
                                        return '';
                                    }
                                }
                                    ],
                                    [
                                        'contentOptions' => ['style' => 'width: 120px;'],
                                        'label' => 'Remark',
                                        'format' => 'raw',
                                        'attribute' => 'Remark',
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
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>

                <?= Html::a('Back', ['create','OIDH' => $OFIH], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>    
</div>


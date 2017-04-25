<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\time\TimePicker;

$idOFH = $OIDH;
$sql = 'select oh.OfferingIDH,
            oh.OfferingDate,
            oh.NoSurat,
            oh.IDJobDesc,
            oh.IsApprove,
            oh.SOIDH,
            mj.Description JobDesc,
            oh.Status,
            sh.Status as StatusSO,
            mc.CustomerName,
            oh.CustomerID as CustomerID
        from OfferingH oh
        left join MasterJobDesc mj on oh.IDJobDesc=mj.IDJobDesc
        left join SOH sh on sh.SOIDH=oh.SOIDH
        inner join MasterCustomer mc on mc.CustomerID = oh.CustomerID
        where oh.OfferingIDH=\'' . $idOFH . '\'';
$modelOFH = app\operational\models\OfferingH::findBySql($sql)->one();

$area = "select ma.AreaID,ma.Description from MasterArea ma
        inner join (
            select distinct(AreaID) AreaID from MasterGajiPokok 
            where IDJobDesc='$modelOFH->IDJobDesc' 
        )maa on maa.AreaID=ma.AreaID
        ";
$modelarea = \app\master\models\MasterArea::findBySql($area)->all();
$arrayhelperarea = ArrayHelper::map($modelarea, 'AreaID', 'Description');

$modelAREA1 = new app\master\models\MasterArea();
$modelOfferingD = new app\operational\models\OfferingD();
$script = <<<SKRIPT
        
$("document").ready( function (){
});        
// ============================================== js Area ===========================================//      
$('#offeringd-areaid').change(function(){
    var area = $(this).val();
    var job='$modelOFH->IDJobDesc' ;

    $.get('index.php?r=operational/offering-h/get-gapok',{ idarea:area, jobid:job }, function(data){
        var datax = $.parseJSON(data);
        $('#gapokUMP').text(datax.UMP);
        $(':hidden#offeringd-gpid').attr('value',datax.GapokID);
        $(':hidden#offeringd-gpseqid').attr('value',datax.SeqID);
        $('#offeringd-gpid').trigger('change');
    });
});
     
$('#masterarea-areaid').change(function(){
    var area = $('#masterarea-areaid').val();
    var job='$modelOFH->IDJobDesc' ;
        
    $.get('index.php?r=operational/offering-h/get-gapok',{ idarea:area, jobid:job }, 
        function(data){
            var datax = $.parseJSON(data);
            var amount = datax.UMP;
              $('#ump-grid').attr('value',datax.UMP);

   });
});        

 // ============================================== js getValueUMP from Area combobox ===========================================//       
function getTotal(){
    var gid=$('#offeringd-gpid').val();
    var seq=$('#offeringd-gpseqid').val();
    var coscal=$('#offeringd-costcalidh').val();
    $.get('index.php?r=operational/offering-h/get-total',{ gapokid:gid, gapokseqid:seq, coscalidh:coscal }, 
        function(data){
            var datay = $.parseJSON(data);
            $('#offeringd-fixamount').val(datay[0].fix);
            $('#offeringd-tambahanamount').val(datay[0].tambahan);
            $('#offeringd-totalamount').val(datay[0].total);
   });
}

SKRIPT;

$this->registerJs($script);

$this->title = 'Offering Detail';

$modelCosCalc = new \app\operational\models\CosCalc();
$modelCosCalc->TipeTagihan = 'B';
$OFIH = $modelOFH->OfferingIDH;

$idsod = Yii::$app->request->get('SODID');
$idsoh = Yii::$app->request->get('SOIDH');
$ofd = Yii::$app->request->get('ofd');
$yearnw = date('o');
$monthnw = date('m');
?>

<?php

if(isset($_GET['IsSO']))
{
?>
<div class="offering-d-form">
    <?php $form = ActiveForm::begin(['action' => ['s-o-d/change-so-cc'], 'method' => 'post']); ?>
    <input type="hidden" name="idsod" value="<?= $idsod ?>">
    <input type="hidden" name="idsoh" value="<?= $idsoh ?>">
    <input type="hidden" name="ofd" value="<?= $ofd ?>">
    <div class="row">
        <div class="col-xs-12">
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
                        <tr>
                            <td colspan="2">
                                <?php
                                $sql = new yii\db\Query();
                                $sql->select('sc.BiayaID,mb.Description,sc.Amount,sc.Remark,sc.Time,sc.IsManagementFee,sc.TipeTagihan,mb.TipeBiaya,sc.Percentage')
                                ->from(['sc' => app\operational\models\CosCalc::tableName()])
                                ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'sc.BiayaID = mb.BiayaID')
                                ->where("sc.OfferingDID='$ofd'")
                                ->orderBy('mb.SeqNo');
                                
                                $exec = $sql->all();
                                $dataProvider = new ActiveDataProvider([
                                    'query' => $sql,
                                    'sort' => false
                                ]);
                                $dataProvider->pagination->pageSize = 100;
                                ?>      
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => '{items}',
                                    'pjax' => false,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                            'contentOptions' => ['style' => 'text-align:center']
                                        ],
                                        [
                                            'header' => 'Description',
                                            'headerOptions' => ['style' => 'text-align:center; width:300px;'],
                                            'attribute' => 'Description',
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                                            'contentOptions' => ['style' => 'text-align:right'],
                                            'attribute' => 'Amount',
                                            'format' => 'raw',
                                            'value' => function($data) {
                                        if ($data['TipeBiaya'] == 'MGM1' OR $data['TipeBiaya'] == 'MGM2' OR $data['TipeBiaya'] == 'BPJS') {
                                            return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Percentage'], ['class' => 'form-control', 'maxlength' => 13, 'style' => "width:105px;text-align:right"]) . " %";
                                        } 
//                                        if ($data['TipeBiaya'] == 'MGM1' ) {
//                                            return Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'maxlength' => 13, 'style' => "width:120px;text-align:right"]) . " %";
//                                        }
                                        else if ($data['BiayaID'] == 'LMB00005') {
                                            return Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 1, 'style' => "width:35px;text-align:right"]) . " Jam";
                                        } else if ($data['BiayaID'] == 'THR00001') {
                                            return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                        } else if ($data['BiayaID'] == 'UMP00001') {
                                            return "Rp. " . Html::textInput('model[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'id' => 'ump-grid', 'readonly' => true, 'maxlength' => 10, 'style' => "text-align:right"]).
                                                Html::hiddenInput('ump',$data['Amount']);
                                        }   else if ($data['BiayaID'] == 'PPH00001') {
                                            return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                        } else {
                                            return "Rp. " . Html::textInput('coscal[' . $data['BiayaID'] . '][amount]', $data['Amount'], ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                        }
                                    }
                                        ],
                                        [
                                            'header' => 'Management<br>Fee',
                                            'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                            'format' => 'raw',
                                            'value' => function($data) {
                                                if ($data['TipeBiaya'] == '1FX' OR $data['TipeBiaya'] == '2TMB' OR $data['TipeBiaya'] == 'GP' OR $data['TipeBiaya'] == 'BPJS') {
                                                    return Html::checkbox('coscal[' . $data['BiayaID'] . '][ismfee]', $data['IsManagementFee']);
                                                } else {
                                                    return '';
                                                }
                                            },
                                            'contentOptions' => ['style' => 'text-align:center;width:100px;'],
                                        ],
                                        [
                                            'header' => 'Time',
                                            'headerOptions' => ['style' => 'text-align:center; width:50px;'],
                                            'format' => 'raw',
                                            'value' => function($data) use ($modelCosCalc) {
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
                                            'headerOptions' => ['style' => 'text-align:center; width:150px;'],
                                            'contentOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'Tipe',
                                            'format' => 'raw',
                                            'value' => function($data) use ($form, $modelCosCalc) {
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
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Request For Approval', ['class' => 'btn btn-success']); ?>
                <?= Html::a('Back', ['offering-h/index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php } else { ?>
<div class="offering-d-form">
    <?php $form = ActiveForm::begin(['action' => ['offering-d/insert-coscal'], 'method' => 'post']); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID Offering Header</td>
                            <td>: <?= $idOFH ?> </td>
                            <input type="hidden" name="OfferingIDH" value="<?= $idOFH?>" >
                        </tr>
                        <tr>
                            <td>Offering Date </td>
                            <td>: <?= $modelOFH->OfferingDate ?></td>
                        </tr>
                        <tr>
                            <td>Customer ID </td>
                            <td>: <?= $modelOFH->CustomerID ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= $modelOFH->CustomerName ?></td>
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
                                    default : echo '-';
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td>ID SO </td>
                            <td>: <?php
                                if ($modelOFH->SOIDH == NULL) {
                                    echo '-';
                                } else {
                                    echo $modelOFH->SOIDH;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td>Status SO </td>
                            <td>: <?php
                                if ($modelOFH->StatusSO == NULL) {
                                    echo '-';
                                } else {
                                    switch ($modelOFH->StatusSO) {
                                        case 'D' : echo 'Draft';
                                            break;
                                        case 'RFA' : echo 'Request For Approval';
                                            break;
                                        case 'C' : echo 'Correction';
                                            break;
                                        case 'A' : echo 'Approve';
                                            break;
                                        default : echo '-';
                                    }
                                }
                                ?></td>
                        </tr>
                        <?php if ($modelOFH->IsApprove == 0 && $modelOFH->SOIDH == '' && $modelOFH->Status == 'D' || $modelOFH->Status == 'C') { ?>
                            <tr>
                                <td >Area</td>
                                <td><?=
                                    $form->field($modelAREA1, 'AreaID')->widget(Select2::classname(), [
                                        'data' => $arrayhelperarea,
                                        'options' => [
                                            'placeholder' => 'Pilih Area...',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '300px'
                                        ],
                                    ])->label(false);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Class</td>
                                <td><?=
                                    $form->field($modelOfferingD, 'Class')->widget(Select2::classname(), [
                                        'data' => ['A' => 'A', 'B' => 'B'],
                                        'options' => [
                                            'placeholder' => 'Pilih Class...',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '300px'
                                        ],
                                    ])->label(false);
                                    ?>
                                    </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    $sql = new yii\db\Query();
                                    if($modelOFH->CustomerID == 'CUS1603054')
                                    {
                                        $sql->select('mb.SeqNo,mb.BiayaID,mb.Description as biayadesc,mb.TipeBiaya')
                                            ->from('MasterBiaya mb')
                                            ->where(['mb.IsActive' => '1'])                                            
                                            ->orderBy(['SeqNo' => SORT_ASC]);
                                    } else {
                                        $sql->select('mb.SeqNo,mb.BiayaID,mb.Description as biayadesc,mb.TipeBiaya')
                                            ->from('MasterBiaya mb')
                                            ->where(['mb.IsActive' => '1'])
                                            ->andWhere(['not in','BiayaID','PPH00001'])
                                            ->orderBy(['SeqNo' => SORT_ASC]);
                                    }
                                    $exec = $sql->all();
                                    $dataProvider = new ActiveDataProvider([
                                        'query' => $sql,
                                        'sort' => false
                                    ]);
                                    $dataProvider->pagination->pageSize = 100;
                                    ?>      
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'layout' => '{items}',
                                        'pjax' => false,
                                        'columns' => [
                                            [
                                                'class' => 'yii\grid\SerialColumn',
                                                'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                                'contentOptions' => ['style' => 'text-align:center']
                                            ],
                                            [
                                                'header' => 'Description',
                                                'headerOptions' => ['style' => 'text-align:center; width:300px;'],
                                                'attribute' => 'biayadesc',
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                                                'contentOptions' => ['style' => 'text-align:right'],
                                                'attribute' => 'Amount',
                                                'format' => 'raw',
                                                'value' => function($data) {
//                                            if ($data['TipeBiaya'] == 'MGM1' OR $data['TipeBiaya'] == 'MGM2' OR $data['TipeBiaya'] == 'BPJS') {
//                                                return Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'maxlength' => 13, 'style' => "width:85px;text-align:right"]) . " %";
//                                            } else 
                                                if ($data['TipeBiaya'] == 'MGM1' ) {
                                                return Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'maxlength' => 13, 'style' => "width:120px;text-align:right"]) . " %";
                                            } else if ($data['BiayaID'] == 'LMB00005') {
                                                return Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'maxlength' => 1, 'style' => "width:35px;text-align:right"]). " Jam";
                                            } else if ($data['BiayaID'] == 'THR00001') {
                                                return Html::hiddeninput('model[' . $data['BiayaID'] . '][amount]', '0', ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                            } else if ($data['BiayaID'] == 'UMP00001') {
                                                return "Rp. " . Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'id' => 'ump-grid', 'readonly' => true, 'maxlength' => 10, 'style' => "text-align:right"]);
                                            } else if ($data['BiayaID'] == 'PPH00001') {
                                                return Html::hiddeninput('model[' . $data['BiayaID'] . '][amount]', '0', ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                            } else {
                                                return "Rp. " . Html::textInput('model[' . $data['BiayaID'] . '][amount]', NULL, ['class' => 'form-control', 'maxlength' => 10, 'style' => "text-align:right"]);
                                            }
                                        }
                                            ],
                                            [
                                                'header' => 'Management<br>Fee',
                                                'headerOptions' => ['style' => 'text-align:center; width:10px;'],
                                                'format' => 'raw',
                                                'value' => function($data) {
                                                    if ($data['TipeBiaya'] == '1FX' OR $data['TipeBiaya'] == '2TMB' OR $data['TipeBiaya'] == 'GP' OR $data['TipeBiaya'] == 'BPJS') {
                                                        return Html::checkbox('model[' . $data['BiayaID'] . '][ismanagementfee]', FALSE);
                                                    } else {
                                                        return '';
                                                    }
                                                },
                                                'contentOptions' => ['style' => 'text-align:center;width:100px;'],
                                            ],
                                            [
                                                'header' => 'Time',
                                                'headerOptions' => ['style' => 'text-align:center; width:50px;'],
                                                'format' => 'raw',
                                                'value' => function($data) use ($modelCosCalc) {
                                                    if ($data['TipeBiaya'] == 'LMB') {
                                                        return TimePicker::widget([
                                                                    'attribute' => 'model[' . $data['BiayaID'] . '][time]',
                                                                    'name' => 'model[' . $data['BiayaID'] . '][time]',
                                                                    'addon' => '',
                                                                    'size'=>'sm',
                                                                    'options' => ['style'=>'width:70px'],
                                                                    'pluginOptions' => [

                                                                        'showMeridian' => false,
                                                                        'showSeconds' => false,
                                                                        'template' => false
                                                        ]]);
                                                    } else {
                                                        return '';
                                                    }
                                                },
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center; width:150px;'],
                                                'contentOptions' => ['style' => 'text-align:center'],
                                                'attribute' => 'Tipe',
                                                'format' => 'raw',
                                                'value' => function($data) use ($form, $modelCosCalc) {

                                            if ($data['BiayaID'] == 'CMC00001'
                                                    OR $data['BiayaID'] == 'SRG00001'
                                                    OR $data['BiayaID'] == 'THR00001'
                                                    OR $data['BiayaID'] == 'TRN00001'
                                                    OR $data['BiayaID'] == '00000014'
                                                    OR $data['BiayaID'] == '00000012') {
                                                return Html::radioList('model[' . $data['BiayaID'] . '][tipetagihan]', 'B', ['B' => 'Bulanan', 'T' => 'Tahunan']);
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
                                            return Html::textInput('model[' . $data['BiayaID'] . '][remark]', '', ['class' => 'form-control']);
                                        }
                                            ],
                                        ],
                                    ]);
                                    ?>   
                                </td>
                            </tr>
                    </table>
                        <?php } else { echo '</table>'; } ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?php if ($modelOFH->IsApprove == 0 && $modelOFH->SOIDH == '' && $modelOFH->Status == 'D' || $modelOFH->Status == 'C') { ?>
                <div class="box-body">
                    <?= Html::a('Request For Approval', ['/operational/offering-h/rfa', 'ofidh' => $idOFH], ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Back', ['offering-h/index'], ['class' => 'btn btn-success']) ?>
                </div>
                
            <?php } else { ?>
                <div class="box-body">
                    <?= Html::a('Back', ['offering-h/index'], ['class' => 'btn btn-success']) ?>
                </div>
            <?php } ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Offering Detail') ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_index', ['ODH' => $idOFH, 'status' => $modelOFH->Status, 'statusso' => $modelOFH->StatusSO, 'SOIDH' => $modelOFH->SOIDH]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

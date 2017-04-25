<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;


$script = <<<SKRIPT

    $("#coscald-biayaid").change(function(){
        var selecttext = $("#coscald-biayaid option:selected").val().substring(0,3);
        var selectitem = $("#coscald-biayaid option:selected").val();

        if(selecttext == 'LMB'){
            $("#jam").show('slow');
        } else if(selecttext == 'THR') {
            $("#amt").hide('slow');
            $("#tipebyr").show('slow');
            $("#coscald-amount").val("0");
        } else if(selecttext == 'SRG' || selecttext == 'TRN' || selecttext == 'CMC'){
            $("#tipebyr").show('slow');
            $("#amt").show('slow');
        } else {
            $("#jam").hide('slow');
            $("#tipebyr").hide('slow');
            $("#amt").show('slow');
        }
        
        if(selectitem == 'BPJS0001' || selectitem == 'M1000001' || selectitem == 'M5000001'){
            $("#coscald-amount").attr('maxlength','5');
        }else{
            $("#coscald-amount").attr('maxlength','12');
        }
    })
        
SKRIPT;
$this->registerJs($script);


$this->title = 'CostCalc Detail';

$flag = Yii::$app->request->get('flag','xxx');

$idCoscalH = Yii::$app->request->get('CostcalIDH','xxx');

$sql = 'select ch.CostcalIDH,
            ch.CostcalDate,
            ch.JobDescID,
            mj.Description JobDescription,
            ch.IsActive,
            ch.OfferingDID,
            oh.Status statusOffering,
            ch.SODID,
            sh.Status statusSO
        from CosCalH ch
        left join MasterJobDesc mj on mj.IDJobDesc=ch.JobDescID
        left join OfferingD od on od.CostcalIDH=ch.CostcalIDH
        left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
        left join SOH sh on sh.OfferingIDH=oh.OfferingIDH
        where ch.CostcalIDH=\''.$idCoscalH.'\'';

$modelCosCalH = app\operational\models\CosCalH::findBySql($sql)->one();

//// Cek Jika Model Kosong, 
//// artinya data tidak ada (indikasi Error)

$biaya = Yii::$app->db->createCommand("select mb.BiayaID,mb.Description from MasterBiaya mb
                    left join CosCalD cd on cd.BiayaID=mb.BiayaID and CostcalIDH = '".$idCoscalH."'
                    where cd.CostcalDID is null
                            and mb.Tipe IN ('1FX','MGM1')")->queryAll();
$arraybiaya = ArrayHelper::map($biaya,'BiayaID','Description');
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="cos-cal-d-form">
<div class="se-pre-con" style="display:none;" id="loadingDiv">
</div>
<?php $form = ActiveForm::begin(); ?>
    
     <table class="table table-striped table-bordered">
        <tr>
            <td style="width:170px;">ID Costcal Header</td>
            <td>: <label id="CostcalH"><?= $idCoscalH ?> </label></td>
        <input type="hidden" value="<?= $idCoscalH ?>" name="idcostcalh">
        </tr>
        <tr>
            <td>Job Description</td>
            <td>: <?= $modelCosCalH->JobDescription ?></td>
        </tr>
        <tr>
            <td>CostCalc Date</td>
            <td>: <?= $modelCosCalH->CostcalDate ?></td>
        </tr>
        <tr>
            <td>OfferingDID</td>
            <td>: <?= $modelCosCalH->OfferingDID ?></td>
        </tr>
        <tr>
            <td>Status Offering</td>
            <td>: <?php switch($modelCosCalH->statusOffering){
                    case 'D' : echo 'Draft'; break;
                    case 'RFA' : echo 'Request For Approval'; break;
                    case 'C' : echo 'Correction'; break;
                    case 'A' : echo 'Approve'; break; 
                    default : echo '-';
            } ?></td>
        </tr>
        <tr>
            <td>SODID</td>
            <td>: <?= $modelCosCalH->SODID ?></td>
        </tr>
        <tr>
            <td>Status SO</td>
            <td>: <?php switch($modelCosCalH->statusSO){
                    case 'D' : echo 'Draft'; break;
                    case 'RFA' : echo 'Request For Approval'; break;
                    case 'C' : echo 'Correction'; break;
                    case 'A' : echo 'Approve'; break; 
                    default : echo '-';
            } ?></td>
        </tr>
    <?php if($modelCosCalH->SODID == ''){ ?>
    <tr>
        <td>Tipe Biaya</td>
        <td>
            <?= Html::radioList('tipebiaya', '1FX', ['1FX'=> 'Fix','2TMB' => 'Tambahan','3NFIX'=>'Non Fix'], 
                ['encode'=>false,
                'onchange'=>'
                    $(document)
                        .ajaxStart(function () {
                        loading.show();
                    })
                    .ajaxStop(function () {
                        loading.hide();
                        window.close();
                    });

                    var $slect2 = $("select#coscald-biayaid");

                    var loading = $("#loadingDiv");
                    var id = $("input:radio[name=tipebiaya]:checked").val();
                    var idcch = $("input:hidden[name=idcostcalh]").val();
                    $.get("index.php?r=operational/cos-cal-d/lists",{idtype : id , idcch : idcch}, function( data ) {
                    $slect2.html(data);
                });
            ']) ?>
        </td>
    </tr>
    <tr>
        <td>Jenis Biaya</td>
        <td><?= $form->field($model, 'BiayaID')
                ->dropDownList($arraybiaya,['prompt' => 'Pilih Biaya','style'=> 'width:300px;'])
                ->label('Jenis Biaya');?>            
        </td>
    </tr>
    <tr id="jam" style="display:none;">
        <td>Jam</td>
        <td>
            <?= 
            TimePicker::widget([
                    'name' => 'start_time', 
                    'pluginOptions' => [
                        'showMeridian' => false,
                        'showSeconds' => false
                    ]
                ])
            ?>
        </td>
    </tr>
    <tr id="tipebyr" style="display:none;">
        <td>Tipe Pembayaran Billing</td>
        <td><?= $form->field($model,'Tipe')->radioList(['B' => 'Bulan','T' => 'Tahun']);?></td>
        
    </tr>
    <tr id="amt">
        <td>Amount</td>
        <td><?= $form->field($model, 'Amount')->textInput(['maxlength'=>12]) ?></td>
    </tr>
    <tr>
        <td>Remark</td>
        <td><?= $form->field($model, 'Remark')->textarea(array('rows'=>1,'cols'=>50)) ?></td>
    </tr>
    <?php } ?>
</table>
    <div class="form-group">
        <?php
        if($modelCosCalH->OfferingDID == NULL AND $modelCosCalH->SODID == NULL)
        {echo Html::submitButton('Save', ['class' =>'btn btn-success']);}
            ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>
    <?php ActiveForm::end(); ?>    
    <?= $this->render('_index', ['CDH' => $idCoscalH,'SODID'=>$modelCosCalH->SODID]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$idOFH = Yii::$app->request->get('OIDH','xxx');

$sql = 'select oh.OfferingIDH,
            oh.OfferingDate,
            oh.NoSurat,
            oh.IDJobDesc,
            oh.IsApprove,
            oh.SOIDH,
            mj.Description JobDesc,
            oh.Status
        from OfferingH oh
        left join MasterJobDesc mj on oh.IDJobDesc=mj.IDJobDesc
        left join SOH sh on sh.SOIDH=oh.SOIDH
        where oh.OfferingIDH=\''.$idOFH.'\'';
$modelOFH = app\operational\models\OfferingH::findBySql($sql)->one();

$area ="select ma.AreaID,ma.Description from MasterArea ma
        inner join (
            select distinct(AreaID) AreaID from MasterGajiPokok 
            where IDJobDesc='$modelOFH->IDJobDesc' 
        )maa on maa.AreaID=ma.AreaID
        ";
$modelarea = \app\master\models\MasterArea::findBySql($area)->all();
$arrayhelperarea = ArrayHelper::map($modelarea,'AreaID','Description');
$modelAREA1 = new app\master\models\MasterArea();

$script = <<<SKRIPT
        
$("document").ready( function (){
        $('#offeringd-areaid').change(function(){
        var area = $(this).val();
        var job='$modelOFH->IDJobDesc' ;

        $.get('index.php?r=operational/offering-h/get-gapok',{ idarea:area, jobid:job }, function(data){
            var datax = $.parseJSON(data);
            $('#gapokAmount').text(datax.Amount);
            $(':hidden#offeringd-gpid').attr('value',datax.GapokID);
            $(':hidden#offeringd-gpseqid').attr('value',datax.SeqID);
            $('#offeringd-gpid').trigger('change');
        });
    });

    $('#btnlookupcoscal').click(function(){
        $('#modalcostcalculationlookup').modal('show')
            .find('#modalcostcalcontent')
            .load($(this).attr('value'));        
    });


    $('#offeringd-gpid').change(function(){
        var ogpid = $("#offeringd-gpid").val();
        var ocostcalidh = $("#offeringd-costcalidh").val();
        if(($.trim(ogpid).length > 0) && (jQuery.trim(ocostcalidh).length > 0))
        {
            getTotal();
        }
    });

    $('#offeringd-costcalidh').change(function(){
        var ogpid = $('#offeringd-gpid').val();
        var ocostcalidh = $('#offeringd-costcalidh').val();
        if(($.trim(ogpid).length > 0) && (jQuery.trim(ocostcalidh).length > 0)){
            getTotal();
        }
    });   

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
});

SKRIPT;

$this->registerJs($script);

$this->title = 'Offering Detail';

?>
<h1><center><?= Html::encode($this->title) ?></center></h1>

<div class="offering-d-form">
 <?php $form = ActiveForm::begin(['action'=>['offering-d/insert-coscal'],'method' => 'post']); ?>
<table class="table table-striped table-bordered">
    <tr>
        <td style="width:200px;">ID Offering Header</td>
        <td>: <label><?= Html::textInput('OfferingIDH',$idOFH,['readonly' => true]) ?> </label></td>
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
        <td>: <?php switch ($modelOFH->Status){
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
        <td>ID SO </td>
        <td>: <?php if($modelOFH->SOIDH == NULL){echo 'Belum Terpakai SO';}else{echo $modelOFH->SOIDH;} ?></td>
    </tr>
    <tr>
        <td>Status SO </td>
        <td>: <?php if($modelOFH->StatusSO == NULL){echo 'Belum Terpakai SO';}else{switch ($modelOFH->StatusSO){
            case 'D' : echo 'Draft';
                    break;
            case 'RFA' : echo 'Request For Approval';
                    break;
            case 'C' : echo 'Correction';
                    break;
            case 'A' : echo 'Approve';
                    break;
            default : echo 'xxx';
        }} ?></td>
    </tr>
<?php if($modelOFH->IsApprove==0 && $modelOFH->SOIDH == '' && $modelOFH->Status == 'D' || $modelOFH->Status == 'C'){ ?>
</table>
    <div class="form-group">
        <?= Html::a('Request For Approval',['/operational/offering-h/rfa','ofidh'=>$idOFH],['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
<?php } 
else { ?>
</table>
    <div class="form-group">
<?php } ?>        
        <?= Html::a('Back', ['offering-h/index'], ['class' =>'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?= $this->render('_index', ['ODH' => $idOFH,'status'=>$modelOFH->Status,'statusso' => $modelOFH->StatusSO,'SOIDH' => $modelOFH->SOIDH]) ?>
    </div>
</div>


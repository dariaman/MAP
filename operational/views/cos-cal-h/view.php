<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\time\TimePicker;

$this->title = 'CostCalc Detail';

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
    
</table>
    <div class="form-group">
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>
    <?php ActiveForm::end(); ?>    
    <?= $this->render('_index', ['CDH' => $idCoscalH,'SODID'=>$modelCosCalH->SODID]) ?>

</div>

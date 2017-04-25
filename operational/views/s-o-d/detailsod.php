<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\time\TimePicker;
use kartik\checkbox\CheckboxX;
use app\operational\models\GoLiveProduct;
use app\operational\models\JadwalGolive;

//$idSOH = Yii::$app->request->get('soidh','xxx');
$idSOH = $model->SOIDH;

$modelGoLive = new GoLiveProduct();
$modelJadwal = new JadwalGolive();

$this->title = 'Go Live Product';

$sql = "select
    mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,
    oh.IDJobDesc,ma.AreaID,sd.PeriodFrom,sd.PeriodTo,sd.StatusGoLive
    from SOD sd
    left join SOH sh on sh.SOIDH = sd.SOIDH
    left join OfferingD od on od.OfferingDID = sd.OfferingDID
    left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc = oh.IDJobDesc
    left join MasterArea ma on ma.AreaID = od.AreaID
where sd.SODID = '$model->SODID'  and sd.SOIDH = '$model->SOIDH'";

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

//$statusGolive = GoLiveProduct::find()->select('Status')->where(['SODID' => $model->SODID])->one();

$countgl = GoLiveProduct::find()
                ->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama')
                ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
                ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID=gl.ProductID ')
                ->where(['SODID' => $model->SODID])->all();

$script1 = <<<SKRIPT
        
  $('#buttongs').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });

SKRIPT;

$this->registerJs($script1);
?>

<div class="sod-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::hiddenInput('idsoh', $idSOH); ?>
    <?= Html::hiddenInput('idsodid', $model->SODID); ?>
    <?= Html::hiddenInput('ofdid', $SODOutstanding[0]['OfferingDID']); ?>
    <?= Html::hiddenInput('job', $SODOutstanding[0]['IDJobDesc']); ?>
    <?= Html::hiddenInput('area', $SODOutstanding[0]['AreaID']); ?>
    <?= Html::hiddenInput('qty', $SODOutstanding[0]['Qty']); ?>
    <?= Html::hiddenInput('periodfrom', $SODOutstanding[0]['PeriodFrom']); ?>
    <?= Html::hiddenInput('periodto', $SODOutstanding[0]['PeriodTo']); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID SO Header</td>
                            <td>: <?= $idSOH ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID SO Detail</td>
                            <td>: <?= $model->SODID ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID Offering Detail</td>
                            <td>: <?= $SODOutstanding[0]['OfferingDID'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Job Description</td>
                            <td>: <?= $SODOutstanding[0]['JobDescName'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Area Description</td>
                            <td>: <?= $SODOutstanding[0]['AreaName'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Jumlah</td>
                            <td>: <?= $SODOutstanding[0]['Qty'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Period From</td>
                            <td>: <?= $SODOutstanding[0]['PeriodFrom'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Period To</td>
                            <td>: <?= $SODOutstanding[0]['PeriodTo'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Status SO</td>
                            <td>: <?php
                                switch ($SODOutstanding[0]['StatusGoLive']) {
                                    case 'D' : echo 'Draft';
                                        break;
                                    case 'RFA' : echo 'Request For Approval';
                                        break;
                                    case 'C' : echo 'Correction';
                                        break;
                                    case 'A' : echo 'Approve';
                                        break;
                                    case 'REC' : echo 'Request End Contract';
                                        break;
                                    case 'EC' : echo 'End Contract';
                                        break;
                                    default : echo 'xxx';
                                }
                                ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', ['s-o-d/create', 'soidh' => $idSOH], ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_indexgolive', ['soidh' => $idSOH, 'sodid' => $model->SODID, 'statusgolive' => $SODOutstanding[0]['StatusGoLive'],'qty' => $SODOutstanding[0]['Qty']]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<<SKRIPT
        
$('#btnlookuprod').click(function(){
    $('#modalprodlookup').modal('show')
        .find('#modalprodcontent')
        .load($(this).attr('value'));        
});
        
SKRIPT;
$this->registerJs($script);
?>

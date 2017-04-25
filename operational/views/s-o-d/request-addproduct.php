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
use app\operational\models\GoLiveProductHistory;

//$idSOH = Yii::$app->request->get('soidh','xxx');
$idSOH = $model->SOIDH;
$seqid = Yii::$app->request->get('seqid', 'xx');
$so_id = Yii::$app->request->get('sodid', 'xx');
//$idgl = Yii::$app->request->get('id', 'xx');
$modelGoLive = new GoLiveProduct();
$modelJadwal = new JadwalGolive();

$this->title = 'Add Manpower';

$sql = "select
    mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,oh.IDJobDesc,ma.AreaID,sd.PeriodFrom,sd.PeriodTo
    from SOD sd
    left join SOH sh on sh.SOIDH = sd.SOIDH
    left join OfferingD od on od.OfferingDID = sd.OfferingDID
    left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc = oh.IDJobDesc
    left join MasterArea ma on ma.AreaID = od.AreaID
where sd.SODID = '$model->SODID'  and sd.SOIDH = '$model->SOIDH'";

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

$statusGolive = GoLiveProduct::find()->select('Status')->where(['SODID' => $model->SODID])->one();

$golive = GoLiveProduct::find()->where(['SODID' => $model->SODID,'SeqProduct' => $seqid])->one();
$golivehistory = GoLiveProductHistory::find()->where(['ProductID' => $golive['ProductID'],'Status' => 'ET'])->andWhere(['not',['DateUpdate' => NULL]])->orderBy('DateUpdate DESC')->one();
$golive1 = GoLiveProduct::find()->where(['ProductID' => $golive['ProductID'],'Status' => 'ET'])->andWhere(['not',['DateUpdate' => NULL]])->orderBy('DateUpdate DESC')->one();

if($golive1 == NULL)
{
    $golive2 = $golivehistory['PeriodTo'];
} else if ($golivehistory == NULL) {
    $golive2 = '-';
} else {
    $golive2 = $golive1['PeriodTo'];
}

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
    <?= Html::hiddenInput('SeqProduct', $seqid); ?>
    <?= Html::hiddenInput('idsodid', $model->SODID); ?>
    <?= Html::hiddenInput('ofdid', $SODOutstanding[0]['OfferingDID']); ?>
    <?= Html::hiddenInput('job', $SODOutstanding[0]['IDJobDesc']); ?>
    <?= Html::hiddenInput('area', $SODOutstanding[0]['AreaID']); ?>
    <?= Html::hiddenInput('qty', $SODOutstanding[0]['Qty']); ?>
    <?= Html::hiddenInput('periodfromsod', $SODOutstanding[0]['PeriodFrom']); ?>
    <?= Html::hiddenInput('periodtosod', $SODOutstanding[0]['PeriodTo']); ?>
    <?= Html::hiddenInput('periodtogl', $golivehistory['PeriodTo']); ?>
    <?= Html::hiddenInput('product-id-gs'); ?>
    <div class="row">
        <div class="col-xs-12">
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
                            <td style="width:200px;">SeqProduct</td>
                            <td>: <?= $seqid ?> </td>
                        </tr>
                <!--        <tr>
                            <td style="width:200px;">Qty</td>
                            <td>: <?php // echo count($countgl)  ?> ---- <?php //$SODOutstanding[0]['Qty']  ?></td>
                        </tr>-->
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
                            <td style="width:200px;">ET Date</td>
                            <td>: <?= $golive2; ?>  </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">SO Period From </td>
                            <td>: <?= $SODOutstanding[0]['PeriodFrom'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">SO Period To </td>
                            <td>: <?= $SODOutstanding[0]['PeriodTo'] ?> </td>
                        </tr>
                        <?php // if (count($countgl) < $SODOutstanding[0]['Qty']) { ?>
                        <tr> 
                            <td style="width:200px"> Product ID </td>
                            <td> 
                                <?= $form->field($modelGoLive, 'ProductID')->textInput(['readonly' => true, 'style' => 'width:260px', 'name' => 'prod-id-gs'])->label(false) ?>
                                <?= Html::a('', ['/lookup/lookupproductgs', 'idjob' => $SODOutstanding[0]['IDJobDesc']], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongs']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Product Name </td>
                            <td>
                                <?= $form->field($modelGoLive, 'prodname')->textInput(['readonly' => true, 'id' => 'nameprod', 'style' => "width:260px", 'name' => 'prod-name-gs'])->label(false) ?> 
                            </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Effective Date</td>
                            <td><?php
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'PeriodFrom',
                                    'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px'],
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true]]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Area Detail</td>
                            <td><?= $form->field($modelGoLive, 'AreaDetailDesc')->textInput(['class' => 'form-control medbox'])->label(false) ?></td>
                        </tr>
                        <tr>
                            <td>License Plate</td>
                            <td><?= $form->field($modelGoLive, 'LicensePlate')->textInput(['class' => 'form-control medbox'])->label(false) ?></td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td>
                                <?= $form->field($modelGoLive, 'IsShift')->widget(CheckboxX::classname(), ['pluginOptions' => ['threeState' => false, 'size' => 'sm']])->label(false); ?>
                            </td>
                        </tr>
                        <tr id="kerja">
                            <td>Hari Kerja</td>
                            <td>
                                <table class="table table-striped table-bordered" style="width:450px;">
                                    <tr>
                                        <td style="width:200px;", bgcolor="#6495ed", align="center">Hari</td>
                                        <td style="width:50px;", bgcolor="#6495ed", align="center">Jam Masuk</td>
                                        <td style="width:50px;", bgcolor="#6495ed", align="center">Jam Keluar</td>
                                    </tr>
                                    <tr>
                                        <td style="width:200px;">
                                            <?= CheckboxX::widget(['name' => 'H1', 'autoLabel' => true, 'labelSettings' => ['label' => 'Senin', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H1'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Monday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Monday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?= CheckboxX::widget(['name' => 'H2', 'autoLabel' => true, 'labelSettings' => ['label' => 'Selasa', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H2'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Tuesday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Tuesday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= CheckboxX::widget(['name' => 'H3', 'autoLabel' => true, 'labelSettings' => ['label' => 'Rabu', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H3'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?></td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Wednesday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Wednesday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= CheckboxX::widget(['name' => 'H4', 'autoLabel' => true, 'labelSettings' => ['label' => 'Kamis', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H4'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Thursday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Thursday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= CheckboxX::widget(['name' => 'H5', 'autoLabel' => true, 'labelSettings' => ['label' => "Jum'at", 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H5'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Friday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Friday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= CheckboxX::widget(['name' => 'H6', 'autoLabel' => true, 'labelSettings' => ['label' => 'Sabtu', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H6'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Saturday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false]
                                                ])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Saturday2',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= CheckboxX::widget(['name' => 'H7', 'autoLabel' => true, 'labelSettings' => ['label' => 'Minggu', 'position' => CheckboxX::LABEL_RIGHT], 'options' => ['id' => 'H7'], 'pluginOptions' => ['size' => 'sm', 'threeState' => false]]); ?>           </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Sunday1',
                                                'pluginOptions' => [
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                        <td> <?=
                                            TimePicker::widget(['model' => $modelJadwal,
                                                'attribute' => 'Sunday2',
                                                'pluginOptions' => [
                                                    'minuteStep' => 30,
                                                    'showMeridian' => false,
                                                    'showSeconds' => false
                                        ]])
                                            ?>
                                        </td>
                                    </tr>                        
                                </table>
                            </td>
                        </tr>
                        <?php // } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php // if (count($countgl) < $SODOutstanding[0]['Qty']) { ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?php // } ?>
                <?= Html::a('Back', ['s-o-d/detailsod', 'did' => $so_id, 'soh' => $idSOH], ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>
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

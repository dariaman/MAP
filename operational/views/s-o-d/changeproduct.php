<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\time\TimePicker;
use kartik\checkbox\CheckboxX;
use app\operational\models\JadwalGolive;


$script = <<<SKRIPT
  
  $('#buttongs').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });
        
SKRIPT;

$this->registerJs($script);
$modelJadwal = new JadwalGolive();
$this->title = 'Change Product';
$id = Yii::$app->request->get('id', 'xxx');

//
//$sql = Yii::$app->db->createCommand("Select Status from GoLiveProduct where GoLiveID ='" . $id . "'");
//$excute = $sql->queryScalar();
//
$queryid = Yii::$app->db->createCommand("select mp.IDJobDesc from GoLiveProduct gl left join MasterProduct mp on mp.ProductID = gl.ProductID")->queryScalar();
//$sqli = "select
//    mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,oh.IDJobDesc,ma.AreaID,sd.PeriodFrom,sd.PeriodTo
//    from SOD sd
//    left join SOH sh on sh.SOIDH = sd.SOIDH
//    left join OfferingD od on od.OfferingDID = sd.OfferingDID
//    left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
//    left join MasterJobDesc mj on mj.IDJobDesc = oh.IDJobDesc
//    left join MasterArea ma on ma.AreaID = od.AreaID
//where sd.SODID = '$model->SODID'";
//
//$SODOutstanding = Yii::$app->db->createCommand($sqli)->queryAll();

$sqliar = "select
    gl.ProductID ,gl.SODID,gl.SeqProduct, mp.Nama ,gl.PeriodTo ,sod.PeriodTo as sod ,sod.SOIDH, gl.PeriodFrom, sod.PeriodFrom as tglkontrakmulai
    from GoLiveProduct gl
    left join MasterProduct mp on gl.ProductID = mp.ProductID
    left join SOD sod on gl.SODID = sod.SODID
    where gl.GoLiveID = '$id'";

$productold = Yii::$app->db->createCommand($sqliar)->queryAll();

//$todaynih = new \yii\db\Expression('getdate()');
//echo $todaynih;
//$statusGolive = app\operational\models\GoLiveProduct::find()->select('Status')->where(['SODID' => $model->SODID])->one();
//
//$countgl = app\operational\models\GoLiveProduct::find()
//                ->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama')
//                ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
//                ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID=gl.ProductID ')
//                ->where(['SODID' => $model->SODID])->all();

?>
<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin(['method' => 'post']); ?>
    <?= Html::hiddenInput('productold', $productold[0]['ProductID']); ?>
    <?= Html::hiddenInput('sodid', $productold[0]['SODID']); ?>
    <?= Html::hiddenInput('soidh', $productold[0]['SOIDH']); ?>
    <?= Html::hiddenInput('seq', $productold[0]['SeqProduct']); ?>
    <?= Html::hiddenInput('sod', $productold[0]['sod']); ?>
    <?= Html::hiddenInput('fromold', $productold[0]['PeriodFrom']); ?>
    <?= Html::hiddenInput('tglkontraksod', $productold[0]['tglkontrakmulai']); ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered"> 
                        <tr> 
                        <tr>
                            <td style="width:200px;">ID SO Detail</td>
                            <td>: <?= $productold[0]['SODID'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">SeqProduct</td>
                            <td>: <?= $productold[0]['SeqProduct'] ?> </td>
                        </tr>
                        <tr>
                        <tr>
                            <td style="width:200px;">Product Old</td>
                            <td>: <?= $productold[0]['ProductID'] ?> - <?= $productold[0]['Nama'] ?></td>
                        </tr>
                            <td style="width:200px;">Tanggal Tugas</td>
                            <td>: <?= $productold[0]['PeriodFrom'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Period To</td>
                            <td>: <?= $productold[0]['sod'] ?> </td>
                        </tr>
                        <tr> 
                            <td style="width:200px">New Product ID </td>
                            <td> 
                                <?= $form->field($model, 'Product_Baru')->textInput(['readonly' => true, 'style' => 'width:260px', 'name' => 'prod-id-gs'])->label(false); ?>
                                <?= Html::a('', ['/lookup/lookupproductgs', 'idjob' => $queryid], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongs']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Product Name </td>
                            <td>
                                <?= $form->field($model, 'prodname')->textInput(['readonly' => true, 'id' => 'nameprod', 'style' => "width:260px", 'name' => 'prod-name-gs'])->label(false); ?> 
                            </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Tanggal Tugas Pengganti</td>
                            <td> <?php
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
                            <td><?= $form->field($model, 'AreaDetailDesc')->textInput(['class' => 'form-control medbox'])->label(false); ?></td>
                        </tr>
                        <tr>
                            <td>License Plate</td>
                            <td><?= $form->field($model, 'LicensePlate')->textInput(['class' => 'form-control medbox'])->label(false); ?></td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td>
                                <?= $form->field($model, 'IsShift')->widget(CheckboxX::classname(), ['pluginOptions' => ['threeState' => false, 'size' => 'sm']])->label(false); ?>
                            </td>
                        </tr>
                    <!--    <tr id="kerja">
                            <td>Hari Kerja</td>
                            <td>
                                <table class="table table-striped table-bordered" style="width:450px;">
                                    <tr>
                                        <td style="width:200px;">Hari</td>
                                        <td style="width:50px;">Jam Masuk</td>
                                        <td style="width:50px;">Jam Keluar</td>
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
                                                    'showSeconds' => false
                                        ]])
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
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Back', (['s-o-d/detailsod', 'soh' =>$productold[0]['SOIDH'], 'did' => $productold[0]['SODID']]), ['class' => 'btn btn-success']) ?>  
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
//    $form = ActiveForm::begin(['action' => $act, 'method' => 'post']);
    ?>
     
    <!--<input type="hidden" name="idapd" value="<?php //Yii::$app->request->get('id', 'xxx'); ?>">-->
</div>
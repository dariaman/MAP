<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\grid\GridView;
//use kartik\grid\GridView;
//use yii\data\ActiveDataProvider;
use kartik\date\DatePicker;

$this->title = 'Request ET';

$id = Yii::$app->request->get('id');
$sodid = Yii::$app->request->get('sodid');
$seqid = Yii::$app->request->get('seqid');

$modelPeriodTo = new app\operational\models\GoLiveProduct();

$sql = "select
    mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,oh.IDJobDesc,ma.AreaID,gp.PeriodFrom,sd.PeriodTo
    from SOD sd
    left join SOH sh on sh.SOIDH = sd.SOIDH
    LEFT JOIN dbo.GoLiveProduct gp ON gp.SODID = sd.SODID
    left join OfferingD od on od.OfferingDID = sd.OfferingDID
    left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc = oh.IDJobDesc
    left join MasterArea ma on ma.AreaID = od.AreaID
    where sd.SODID = '$sodid' and gp.SeqProduct= $seqid";

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

?>


<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin();?>
    <?= Html::hiddenInput('periodto', $SODOutstanding[0]['PeriodTo']); ?>
    <?= Html::hiddenInput('periodfrom', $SODOutstanding[0]['PeriodFrom']); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID SO Header</td>
                            <td>: <?= $sohid ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID SO Detail</td>
                            <td>: <?= $sodid ?> </td>
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
                            <td style="width:200px;">Effective Date</td>
                            <td> <?= $form->field($modelPeriodTo, 'PeriodTo')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                ])->label(false); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Cancel', (['s-o-d/detailsod','soh' => Yii::$app->request->get('sohid'),'did' => Yii::$app->request->get('sodid')]), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

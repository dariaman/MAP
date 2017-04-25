<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\widgets\Select2;

$script = <<<SKRIPT


$('#button').click(function(event) {
  event.preventDefault();
  window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
        
SKRIPT;

$this->registerJs($script);


$job = \app\master\models\MasterJobDesc::find()
            ->select('Description,IDJobDesc')
            ->from('MasterJobDesc')
            ->all();

$arrayhelperjob = ArrayHelper::map($job,'IDJobDesc','Description');

?>

<div class="offering-h-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID Offering Header</td>
                            <td><span class="label label-default" style="font-size:12px;">Auto Generate</span></td>
                        </tr>
                        <tr>
                            <td>No Surat</td>
                            <td><span class="label label-default" style="font-size:12px;">Auto Generate</span></td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td>
                                <?= $form->field($model, 'CustomerID')->textInput(['readonly' => true, 'id' => 'soh-customerid', 'style' => 'width:260px'])->label(false); ?>
                                <?= Html::a('', ['/lookup/lookupcustomer'], ['class' => 'glyphicon glyphicon-search', 'id' => 'button']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td><?= Html::textInput('cusname',NULL,['id'=>'customername','readonly'=>true,'class'=>'form-control display-block lgbox', 'style' => 'width:360px']) ?></td>
                        </tr>
                        <tr>
                            <td>Offering Date</td>
                            <td><?= $form->field($model, 'OfferingDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                ])->label(false);
                            ?></td>
                        </tr>
                        <tr>
                            <td>Job Desc</td>
                            <td><?=
                                    $form->field($model, 'IDJobDesc')->widget(Select2::classname(), [
                                        'data' => $arrayhelperjob,
                                        'options' => [
                                            'placeholder' => 'Pilih Job Description',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '300px'
                                        ],
                                    ])->label(false);
                                    ?>
                            </td>
                        </tr> 
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' =>'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

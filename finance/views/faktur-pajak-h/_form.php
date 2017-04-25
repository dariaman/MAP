<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="faktur-pajak-h-form">
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
                             <td style="width:200px;">3 Digit No Pertama (Seri Faktur)</td>
                             <td><?= $form->field($model,'EntityID')->textInput(['maxlength' => 3,'class' => 'form-control smbox'])?></td>
                         </tr>
                         <tr>
                             <td>2 Digit Tahun Pajak</td>
                             <td><?= $form->field($model,'TahunPajak')->textInput(['maxlength' => 2,'class' => 'form-control smbox'])?></td>
                         </tr>
                         <tr>
                             <td>TR Date</td>
                             <td><?= $form->field($model,'TrDate')->textInput(['readonly' => true,'class' => 'form-control smbox', 'value' => date('d-M-Y'),'style'=>'width:200px'])?></td>
                         </tr>
                         <tr>
                             <td>Nomor Awal</td>
                             <td><?= $form->field($model,'NoAwal')->textInput(['maxlength' => 8,'class' => 'form-control smbox','style'=>'width:100px'])?></td>
                         </tr>
                         <tr>
                             <td>Nomor Akhir</td>
                             <td><?= $form->field($model,'NoAkhir')->textInput(['maxlength' => 8,'class' => 'form-control smbox','style'=>'width:100px'])?></td>
                         </tr>
                         <tr>
                             <td>Start Period</td>
                             <td><?= $form->field($model, 'StartPeriod')->widget(DatePicker::classname(), [
                                     'options' => ['placeholder' => 'Enter Date ...'],
                                     'pluginOptions' => ['autoclose'=>true,
                                                    'format' => 'yyyy-mm-dd',
                                                                'todayHighlight' => true]
                                 ]); ?></td>
                         </tr
                         <tr>
                             <td>End Period</td>
                             <td><?= $form->field($model, 'EndPeriod')->widget(DatePicker::classname(), [
                                     'options' => ['placeholder' => 'Enter Date ...'],
                                     'pluginOptions' => ['autoclose'=>true,
                                                    'format' => 'yyyy-mm-dd',
                                                                'todayHighlight' => true]
                                 ]); ?></td>
                         </tr>
                     </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\operational\models\GoodsReceive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-receive-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:150px;">Goods Receive ID</td>
            <td>: Auto Generate</td>
        </tr>
        <tr>
            <td>Item</td>
            <td>: <?= $form->field($model, 'ItemID')->dropDownList(['SRG00001' => 'Seragam','CMC00001' => 'Chemical', 'TRN00001' => 'Training'],['prompt' => 'Select Item','class' => 'form-control', 'style' => 'width:150px']) ?></td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>: <?= $form->field($model, 'Qty')->textInput() ?></td>
        </tr>
        <tr>
            <td>Harga Satuan</td>
            <td>: <?= $form->field($model, 'HargaSatuan')->textInput() ?></td>
        </tr>
        <tr>
            <td>Nomor PV</td>
            <td>: <?= $form->field($model, 'NoPV')->textInput() ?></td>
        </tr>
        <tr>
            <td>Reference No</td>
            <td>: <?= $form->field($model, 'ReferenceNo')->textInput() ?></td>
        </tr>
        <tr>
            <td>Supplier Name</td>
            <td>: <?= $form->field($model, 'SupplierName')->textInput() ?></td>
        </tr>
        <tr>
            <td>No Faktur Pajak</td>
            <td>: <?= $form->field($model, 'SupplierName')->textInput() ?></td>
        </tr>
        <tr>
            <td>Receive Date</td>
            <td><?= $form->field($model, 'ReceiveDate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true]
                ]); ?></td>
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

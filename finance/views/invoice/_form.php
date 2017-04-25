<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'InvoiceNo')->textInput() ?>

    <?= $form->field($model, 'InvoiceDate')->textInput() ?>

    <?= $form->field($model, 'CustomerID')->textInput() ?>

    <?= $form->field($model, 'TotalDPP')->textInput() ?>

    <?= $form->field($model, 'TotalMFee')->textInput() ?>

    <?= $form->field($model, 'TotalPPN')->textInput() ?>

    <?= $form->field($model, 'TotalPPH23')->textInput() ?>

    <?= $form->field($model, 'TotalInvoice')->textInput() ?>

    <?= $form->field($model, 'KodeFaktur')->textInput() ?>

    <?= $form->field($model, 'NoFakturPajak')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'CancelDate')->textInput() ?>

    <?= $form->field($model, 'CancelReason')->textInput() ?>

    <?= $form->field($model, 'UserCrt')->textInput() ?>

    <?= $form->field($model, 'DateCrt')->textInput() ?>

    <?= $form->field($model, 'UserUpdate')->textInput() ?>

    <?= $form->field($model, 'DateUpdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\BillingHSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-h-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'InvoiceNo') ?>

    <?= $form->field($model, 'InvoiceDate') ?>

    <?= $form->field($model, 'SOIDH') ?>

    <?= $form->field($model, 'CustomerID') ?>

    <?= $form->field($model, 'TotalDPP') ?>

    <?php // echo $form->field($model, 'TotalMFee') ?>

    <?php // echo $form->field($model, 'TotalPPN') ?>

    <?php // echo $form->field($model, 'TotalPPH23') ?>

    <?php // echo $form->field($model, 'TotalInvoice') ?>

    <?php // echo $form->field($model, 'NoFakturPajak') ?>

    <?php // echo $form->field($model, 'Period') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'CancelDate') ?>

    <?php // echo $form->field($model, 'CancelReason') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

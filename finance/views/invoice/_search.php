<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\InvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'InvoiceNo') ?>

    <?= $form->field($model, 'InvoiceDate') ?>

    <?= $form->field($model, 'CustomerID') ?>

    <?= $form->field($model, 'TotalDPP') ?>

    <?= $form->field($model, 'TotalMFee') ?>

    <?php // echo $form->field($model, 'TotalPPN') ?>

    <?php // echo $form->field($model, 'TotalPPH23') ?>

    <?php // echo $form->field($model, 'TotalInvoice') ?>

    <?php // echo $form->field($model, 'KodeFaktur') ?>

    <?php // echo $form->field($model, 'NoFakturPajak') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'CancelDate') ?>

    <?php // echo $form->field($model, 'CancelReason') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <?php // echo $form->field($model, 'UserUpdate') ?>

    <?php // echo $form->field($model, 'DateUpdate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

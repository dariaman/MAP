<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\FakturPajakDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faktur-pajak-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NoFakturPajak') ?>

    <?= $form->field($model, 'KodeFaktur') ?>

    <?= $form->field($model, 'TRNo') ?>

    <?= $form->field($model, 'InvoiceNo') ?>

    <?= $form->field($model, 'InvoiceDate') ?>

    <?php // echo $form->field($model, 'IsCancel') ?>

    <?php // echo $form->field($model, 'InvoiceCancel') ?>

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

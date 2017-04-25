<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountReceivableSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-receivable-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ARNo') ?>

    <?= $form->field($model, 'InvoiceNo') ?>

    <?= $form->field($model, 'RefNo') ?>

    <?= $form->field($model, 'PaymentDate') ?>

    <?= $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'APNO') ?>

    <?= $form->field($model, 'APDate') ?>

    <?= $form->field($model, 'PayrollGajiIDH') ?>

    <?= $form->field($model, 'AmountPayment') ?>

    <?= $form->field($model, 'BiayaAdmin') ?>

    <?php // echo $form->field($model, 'IDBankMAP') ?>

    <?php // echo $form->field($model, 'BankGroupProduct') ?>

    <?php // echo $form->field($model, 'RekBankProduct') ?>

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

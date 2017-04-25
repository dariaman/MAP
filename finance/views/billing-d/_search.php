<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\BillingDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'BillingNo') ?>

    <?= $form->field($model, 'InvoiceNo') ?>

    <?= $form->field($model, 'TipeBilling') ?>

    <?= $form->field($model, 'AreaID') ?>

    <?= $form->field($model, 'SODID') ?>

    <?php // echo $form->field($model, 'ProductID') ?>

    <?php // echo $form->field($model, 'Periode') ?>

    <?php // echo $form->field($model, 'DPP') ?>

    <?php // echo $form->field($model, 'MgmFee') ?>

    <?php // echo $form->field($model, 'PPN') ?>

    <?php // echo $form->field($model, 'PPH23') ?>

    <?php // echo $form->field($model, 'Total') ?>

    <?php // echo $form->field($model, 'Usercrt') ?>

    <?php // echo $form->field($model, 'Datecrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

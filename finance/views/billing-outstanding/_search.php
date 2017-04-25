<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\BillingOutstandingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-outstanding-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'BillingNo') ?>

    <?= $form->field($model, 'TipeBilling') ?>

    <?= $form->field($model, 'SOIDH') ?>

    <?= $form->field($model, 'SODID') ?>

    <?= $form->field($model, 'CustomerID') ?>

    <?php // echo $form->field($model, 'AreaID') ?>

    <?php // echo $form->field($model, 'ProductID') ?>

    <?php // echo $form->field($model, 'Periode') ?>

    <?php // echo $form->field($model, 'DPP') ?>

    <?php // echo $form->field($model, 'MgmFee') ?>

    <?php // echo $form->field($model, 'PPN') ?>

    <?php // echo $form->field($model, 'PPH23') ?>

    <?php // echo $form->field($model, 'TotalInvoice') ?>

    <?php // echo $form->field($model, 'IsBilling') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

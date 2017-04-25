<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allocation-product-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'AllocationProductDID') ?>

    <?= $form->field($model, 'AllocationProductIDH') ?>

    <?= $form->field($model, 'SODID') ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'AreaDetailDesc') ?>

    <?php // echo $form->field($model, 'LicensePlate') ?>

    <?php // echo $form->field($model, 'TglTugas') ?>

    <?php // echo $form->field($model, 'IsActive') ?>

    <?php // echo $form->field($model, 'IsShift') ?>

    <?php // echo $form->field($model, 'HariKerja') ?>

    <?php // echo $form->field($model, 'NoPKWT') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

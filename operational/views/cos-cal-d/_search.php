<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\CosCalDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cos-cal-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CostcalDID') ?>

    <?= $form->field($model, 'CostcalIDH') ?>

    <?= $form->field($model, 'TipeBiaya') ?>

    <?= $form->field($model, 'BiayaID') ?>

    <?= $form->field($model, 'Amount') ?>

    <?php // echo $form->field($model, 'IsPercentage') ?>

    <?php // echo $form->field($model, 'Remark') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

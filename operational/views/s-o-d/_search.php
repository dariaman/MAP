<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="sod-searchsearch">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SODID') ?>

    <?= $form->field($model, 'SOIDH') ?>

    <?= $form->field($model, 'OfferingDID') ?>

    <?= $form->field($model, 'Qty') ?>

    <?= $form->field($model, 'PeriodFrom') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

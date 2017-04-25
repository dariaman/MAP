<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\DeliveryOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'DONo') ?>

    <?= $form->field($model, 'Qty') ?>

    <?= $form->field($model, 'SODID') ?>

    <?= $form->field($model, 'GRID') ?>

    <?= $form->field($model, 'DODate') ?>

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

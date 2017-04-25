<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jadwal-absensi-status-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IDJadwalAbsensiStatusH') ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'CloseJadwalStatus') ?>

    <?= $form->field($model, 'CloseJadwalDate') ?>

    <?= $form->field($model, 'CloseAbsenStatus') ?>

    <?php // echo $form->field($model, 'CloseAbsenDate') ?>

    <?php // echo $form->field($model, 'CloseOTStatus') ?>

    <?php // echo $form->field($model, 'CloseOTDate') ?>

    <?php // echo $form->field($model, 'IsActive') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

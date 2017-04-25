<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusD */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jadwal-absensi-status-d-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IDJadwalAbsensiStatusH')->textInput() ?>

    <?= $form->field($model, 'ProductID')->textInput() ?>

    <?= $form->field($model, 'CloseJadwalStatus')->textInput() ?>

    <?= $form->field($model, 'CloseJadwalDate')->textInput() ?>

    <?= $form->field($model, 'CloseAbsenStatus')->textInput() ?>

    <?= $form->field($model, 'CloseAbsenDate')->textInput() ?>

    <?= $form->field($model, 'CloseOTStatus')->textInput() ?>

    <?= $form->field($model, 'CloseOTDate')->textInput() ?>

    <?= $form->field($model, 'IsActive')->textInput() ?>

    <?= $form->field($model, 'UserCrt')->textInput() ?>

    <?= $form->field($model, 'DateCrt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

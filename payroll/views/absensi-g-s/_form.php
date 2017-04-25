<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\AbsensiGS */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-gs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProductID')->textInput() ?>

    <?= $form->field($model, 'tgl')->textInput() ?>

    <?= $form->field($model, 'UserCrt')->textInput() ?>

    <?= $form->field($model, 'DateCrt')->textInput() ?>

    <?= $form->field($model, 'UserUpdate')->textInput() ?>

    <?= $form->field($model, 'DateUpdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\AbsensiGSSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-gs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'tgl') ?>

    <?= $form->field($model, 'UserCrt') ?>

    <?= $form->field($model, 'DateCrt') ?>

    <?= $form->field($model, 'UserUpdate') ?>

    <?php // echo $form->field($model, 'DateUpdate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

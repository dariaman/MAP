<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\BPJSRegistrasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bpjsregistrasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'JKK') ?>

    <?= $form->field($model, 'JKM') ?>

    <?= $form->field($model, 'JHT') ?>

    <?= $form->field($model, 'JP') ?>

    <?php // echo $form->field($model, 'BPJS') ?>

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

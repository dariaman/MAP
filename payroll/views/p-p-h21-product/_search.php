<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PPH21ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pph21-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'Periode') ?>

    <?= $form->field($model, 'Gapok') ?>

    <?= $form->field($model, 'Tunjangan') ?>

    <?= $form->field($model, 'Potongan') ?>

    <?php // echo $form->field($model, 'BiayaJabatan') ?>

    <?php // echo $form->field($model, 'PTKP') ?>

    <?php // echo $form->field($model, 'PKP') ?>

    <?php // echo $form->field($model, 'PPH21Amount') ?>

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

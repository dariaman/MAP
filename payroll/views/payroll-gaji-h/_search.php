<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiHSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-gaji-h-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PayrollGajiIDH') ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'bln') ?>

    <?= $form->field($model, 'thn') ?>

    <?= $form->field($model, 'CustomerID') ?>

    <?php // echo $form->field($model, 'AreaID') ?>

    <?php // echo $form->field($model, 'FixAmount') ?>

    <?php // echo $form->field($model, 'TunjanganAmount') ?>

    <?php // echo $form->field($model, 'PotonganAmount') ?>

    <?php // echo $form->field($model, 'PPH21') ?>

    <?php // echo $form->field($model, 'Total') ?>

    <?php // echo $form->field($model, 'Status') ?>

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

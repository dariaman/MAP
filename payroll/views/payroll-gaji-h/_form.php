<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-gaji-h-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PayrollGajiIDH')->textInput() ?>

    <?= $form->field($model, 'ProductID')->textInput() ?>

    <?= $form->field($model, 'bln')->textInput() ?>

    <?= $form->field($model, 'thn')->textInput() ?>

    <?= $form->field($model, 'CustomerID')->textInput() ?>

    <?= $form->field($model, 'AreaID')->textInput() ?>

    <?= $form->field($model, 'FixAmount')->textInput() ?>

    <?= $form->field($model, 'TunjanganAmount')->textInput() ?>

    <?= $form->field($model, 'PotonganAmount')->textInput() ?>

    <?= $form->field($model, 'PPH21')->textInput() ?>

    <?= $form->field($model, 'Total')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'UserCrt')->textInput() ?>

    <?= $form->field($model, 'DateCrt')->textInput() ?>

    <?= $form->field($model, 'UserUpdate')->textInput() ?>

    <?= $form->field($model, 'DateUpdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

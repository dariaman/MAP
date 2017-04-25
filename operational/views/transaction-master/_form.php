<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\TransactionMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TransID')->textInput() ?>

    <?= $form->field($model, 'Transtype')->textInput() ?>

    <?= $form->field($model, 'PIC')->textInput() ?>

    <?= $form->field($model, 'NextPIC')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'Reason')->textInput() ?>

    <?= $form->field($model, 'usercrt')->textInput() ?>

    <?= $form->field($model, 'datecrt')->textInput() ?>

    <?= $form->field($model, 'LastUpdateBy')->textInput() ?>

    <?= $form->field($model, 'LastUpdateOn')->textInput() ?>

    <?= $form->field($model, 'ApproveBy')->textInput() ?>

    <?= $form->field($model, 'ApproveDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

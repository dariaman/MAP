<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\TransactionMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'TransID') ?>

    <?= $form->field($model, 'Transtype') ?>

    <?= $form->field($model, 'PIC') ?>

    <?= $form->field($model, 'NextPIC') ?>

    <?= $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Reason') ?>

    <?php // echo $form->field($model, 'usercrt') ?>

    <?php // echo $form->field($model, 'datecrt') ?>

    <?php // echo $form->field($model, 'LastUpdateBy') ?>

    <?php // echo $form->field($model, 'LastUpdateOn') ?>

    <?php // echo $form->field($model, 'ApproveBy') ?>

    <?php // echo $form->field($model, 'ApproveDate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

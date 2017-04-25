<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\OfferingDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offering-d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'OfferingDID') ?>

    <?= $form->field($model, 'OfferingIDH') ?>

    <?= $form->field($model, 'CostcalIDH') ?>

    <?= $form->field($model, 'GPID') ?>

    <?= $form->field($model, 'GPSeqID') ?>

    <?php // echo $form->field($model, 'AreaID') ?>

    <?php // echo $form->field($model, 'ClassID') ?>

    <?php // echo $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

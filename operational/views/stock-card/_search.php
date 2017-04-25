<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\StockCardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'StockID') ?>

    <?= $form->field($model, 'ItemID') ?>

    <?= $form->field($model, 'Qty') ?>

    <?= $form->field($model, 'TanggalTransaksi') ?>

    <?= $form->field($model, 'UserCrt') ?>

    <?php // echo $form->field($model, 'DateCrt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

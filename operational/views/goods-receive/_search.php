<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\GoodsReceiveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-receive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'GRID') ?>

    <?= $form->field($model, 'ItemID') ?>

    <?= $form->field($model, 'Qty') ?>

    <?= $form->field($model, 'HargaSatuan') ?>

    <?= $form->field($model, 'NoPV') ?>

    <?php // echo $form->field($model, 'ReferenceNo') ?>

    <?php // echo $form->field($model, 'SupplierName') ?>

    <?php // echo $form->field($model, 'NoFakturPajak') ?>

    <?php // echo $form->field($model, 'ReceiveDate') ?>

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

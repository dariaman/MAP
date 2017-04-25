<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\operational\models\StockCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-card-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">
        <tr >
            <td style="width:150px;">Stock ID</td>
            <td>: Auto Generate</td>
        </tr>
        <tr>
            <td>Item</td>
            <td>: <?= $form->field($model, 'ItemID')->dropDownList(['SRG00001' => 'Seragam','CMC00001' => 'Chemical'],['prompt' => 'Select Item','class' => 'form-control', 'style' => 'width:150px']) ?></td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>: <?= $form->field($model, 'Qty')->textInput() ?></td>
        </tr>
        <tr>
            <td>Tanggal Transaksi</td>
            <td><?= $form->field($model, 'TanggalTransaksi')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true]
                ]); ?></td>
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

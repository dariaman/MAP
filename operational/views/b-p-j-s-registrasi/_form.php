<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\BPJSRegistrasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bpjsregistrasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-striped table-bordered">
        <tr> 
            <td style="width: 200px;">ProductID</td>
            <td><?= $model->ProductID ?>
                <?= $form->field($model, 'ProductID')->hiddenInput()->label(false) ?>
            </td> 
        </tr>
        <tr> 
            <td style="width: 200px;">Jaminan Kecelakaa Kerja</td>
            <td><?= $form->field($model, 'JKK')->checkbox(['label'=>false]) ?></td> 
        </tr>
        <tr> 
            <td style="width: 200px;">Jaminan Kematian</td>
            <td><?= $form->field($model, 'JKM')->checkbox(['label'=>false]) ?></td> 
        </tr>
        <tr> 
            <td style="width: 200px;">Jaminan Hari Tua</td>
            <td><?= $form->field($model, 'JHT')->checkbox(['label'=>false]) ?></td> 
        </tr>
        <tr> 
            <td style="width: 200px;">Jaminan Pensiun</td>
            <td><?= $form->field($model, 'JP')->checkbox(['label'=>false]) ?></td> 
        </tr>
        <tr> 
            <td style="width: 200px;">BPJS Kesehatan</td>
            <td><?= $form->field($model, 'BPJS')->checkbox(['label'=>false]) ?></td> 
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save' , ['class' => 'btn btn-success' ]) ?>
        <?=Html::a('Back', ['b-p-j-s-registrasi/'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

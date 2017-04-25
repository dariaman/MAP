<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="absensi-customer-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td>Import File</td>
            <td><?= $form->field($model, 'file')->fileInput()?></td>
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Import' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaAmount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-formula-amount-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width: 200px">Jenis Formula Amount</td>
            <td>
        <tr>
            <td></td>
            <td>
                <?php
                if (Yii::$app->controller->action->id == 'update') {
                    echo $form->field($model, 'JenisFormulaAmount')->textInput(['style' => 'width:400px;', 'disabled' => true]);
                } else {
                    echo $form->field($model, 'JenisFormulaAmount')->textInput(['style' => 'width:400px;']);
                }
                ?>
            </td>
        </tr>

        </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <?= $form->field($model, 'Description')->textarea(['rows' => 10, 'style' => 'width:400px;']) ?>
            </td>
        </tr>
    </table>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?php echo Html::a('Back', ['list-formula-amount/'], ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

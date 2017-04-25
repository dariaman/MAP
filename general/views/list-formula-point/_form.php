<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaPoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-formula-point-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table  table-bordered" border="3">
        <tr>
            <td style="width: 200px">Jenis Formula Point</td>
            <td>
                <?php
                if (Yii::$app->controller->action->id == 'update') {
                    echo $form->field($model, 'JenisFormulaPoint')->textInput(['style' => 'width:400px;', 'disabled' => true]);
                } else {
                    echo $form->field($model, 'JenisFormulaPoint')->textInput(['style' => 'width:400px;']);
                }
                ?>
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
        <?php echo Html::a('Back', ['list-formula-point/'], ['class' => 'btn btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

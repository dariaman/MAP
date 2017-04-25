<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

$masterjobdesc = app\master\models\MasterJobdesc::find()->select('IDJobDesc,Description')->all();
$masterarea = app\master\models\MasterArea::find()->select('AreaID,Description')->all();

$readonly = (Yii::$app->controller->action->id == 'update') ? true : false;
?>
<div class="master-gaji-pokok-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;"> Gapok ID</td>
                            <td><?= (Yii::$app->controller->action->id == 'update') ? $model->GapokID : 'Auto Generate' ?></td>
                        </tr>
                        <tr>
                            <td> Job Desc</td>
                            <td><?= $form->field($model, 'IDJobDesc')->dropDownList(ArrayHelper::map($masterjobdesc, 'IDJobDesc', 'Description'), ['prompt' => 'Select Job Desc', 'style' => 'width:220px;', 'disabled' => $readonly])->label(false);
                    ?></td>
                        </tr>
                        <tr>
                            <td>Area</td>
                            <td><?=
                    $form->field($model, 'AreaID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($masterarea, 'AreaID', 'Description'),
                        'disabled' => $readonly,
                        'options' => [
                            'placeholder' => 'Pilih Area...',

                        ],
                    ])->label(false);
                    ?></td>
                        </tr>
                        <tr>
                            <td>UMP</td>
                            <td>Rp. <?= $form->field($model, 'UMP')->textInput(['maxlength' => 7, 'style' => 'width:120px;'])->label(false) ?></td>
                        </tr>
                        <tr>
                            <td>GSFee</td>
                            <td>Rp. <?= $form->field($model, 'GSFee')->textInput(['maxlength' => 7, 'style' => 'width:120px;'])->label(false) ?></td>
                        </tr>
                        <tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

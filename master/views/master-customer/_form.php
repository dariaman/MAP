<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\checkbox\CheckboxX;

$absentes = Yii::$app->db->createCommand("select ID,StartAbsen=CAST(StartAbsen AS VARCHAR(2)) + '-' + CAST(EndAbsen AS VARCHAR(2)) from MasterAbsenType")->queryAll();
$comp = $model->IsCompany;
?>

<div class="master-customer-form">
    <?php $form = ActiveForm::begin(); $model->IsCompany = 1;?>
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>
                                CustomerID
                            </td>
                            <td><b><?=(!$model->isNewRecord) ? $model->CustomerID :'Auto Generate' ?></b></td>
                        </tr>
                        <tr>
                            <td>Is Company</td>
                            <td>
                                <?php
                                if (!$model->isNewRecord) {
                                    echo $form->field($model, 'IsCompany')->checkbox(['value' => $comp]);
                                } else {
                                    echo $form->field($model, 'IsCompany')->checkbox();
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Customer Name
                            </td>
                            <td>
                                <?= $form->field($model, 'CustomerName')->textInput(['maxlength' => 255, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address
                            </td>
                            <td>
                                <?= $form->field($model, 'Address')->textarea(['maxlength' => 255, 'style' => 'width:400px;', 'rows' => 2])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City
                            </td>
                            <td>
                                <?= $form->field($model, 'City')->textInput(['maxlength' => 100, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Zip
                            </td>
                            <td>
                                <?= $form->field($model, 'Zip')->textInput(['maxlength' => 5, 'style' => 'width:200px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone
                            </td>
                            <td>
                                <?= $form->field($model, 'Phone')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Fax
                            </td>
                            <td>
                                <?= $form->field($model, 'Fax')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false)?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Name
                            </td>
                            <td>
                                <?= $form->field($model, 'ContactName')->textInput(['maxlength' => 50, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Phone
                            </td>
                            <td>
                                <?= $form->field($model, 'ContactPhone')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Email
                            </td>
                            <td>
                                <?= $form->field($model, 'ContactEmail')->textInput(['maxlength' => 50, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                NPWP
                            </td>
                            <td>
                                <?= $form->field($model, 'NPWP')->textInput(['maxlength' => 20, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Cut Off Absen
                            </td>
                            <td>
                                <?= $form->field($model, 'IDAbsenType')->dropDownList(ArrayHelper::map($absentes, 'ID', 'StartAbsen'), ['prompt' => 'Pilih Type Absen...', 'style' => 'width:200px;'])->label(false) ?>
                            </td>
                        </tr> 
                        <?php
                        if (!$model->isNewRecord) {
                            ?>
                            <tr>
                                <td>Status</td>
                                <td><?php
                                    ($model->IsActive == 1 ? TRUE : FALSE);
                                    echo $form->field($model, 'IsActive')->checkbox();
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
               <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'btn']) ?>
               <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

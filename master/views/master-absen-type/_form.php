<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAbsenType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-absen-type-form">
    <?php $form = ActiveForm::begin();?>
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td> ID</td>
                            <td>Auto Generate</td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td><?= $form->field($model, 'StartAbsen')->textInput(['maxlength' => 2 ,'style'=> 'width:200px;'])->label(false) ; ?></td>
                        </tr>
                        <tr>
                           <td>End Date</td>
                           <td><?= $form->field($model, 'EndAbsen')->textInput(['maxlength' => 2, 'style'=> 'width:200px;'])->label(false) ;?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

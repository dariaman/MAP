<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$readonly=(Yii::$app->controller->action->id == 'update') ? true : false;

?>

<div class="master-bankgroup-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered" >
                        <tr>
                            <td style="width:200px;">BankGroupID</td>
                            <td><b><?=(!$model->isNewRecord) ? $model->BankGroupID :'[Auto Generate]' ?></b></td>
                        </tr>
                    <tr><td style="padding-right:10px;">Bank Group Name</td>
                        <td><?= $form->field($model, 'BankGroupName')
                                    ->textInput(['maxlength' => 10,'style'=> 'width:400px;','readonly' => $readonly])
                                    ->label(false);?>
                        </td>
                    </tr>
                    <tr><td style="padding-right:10px;">Biaya Admin</td>
                        <td>Rp.<?= $form->field($model, 'BiayaAdm')
                                    ->textInput(['maxlength' => 100,'style'=> 'width:100px;'])
                                    ->label(false);?>
                        </td>
                    </tr>
                <?php if(Yii::$app->controller->action->id == 'update') {?>
                        <tr>
                            <td></td>
                            <td><?= $form->field($model, 'IsActive')->checkbox() ?> </td>
                        </tr>
                <?php }?>
                    </table>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>    

     
    

    



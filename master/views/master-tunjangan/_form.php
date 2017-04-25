<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$readonly=(Yii::$app->controller->action->id == 'update') ? true : false;

?>

<div class="master-tunjangan-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px; ">ID Insentive</td>  
                            <td><?=(Yii::$app->controller->action->id == 'update') ? $model->IDTunjangan :'[Auto Generate]' ?></td>
                        </tr>
                        <tr>
                             <td>Insentive Description </td>
                             <td> <?= $form->field($model, 'Description')->textInput(['maxlength' => 200,'style'=> 'width:300px;','readonly' => $readonly])->label(false) ?> </td>  
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
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

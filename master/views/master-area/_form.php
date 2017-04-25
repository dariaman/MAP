<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<div class="master-area-form">
    <?php $form = ActiveForm::begin(); ?>   
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Area ID</td>
                        <td><?= (Yii::$app->controller->action->id == 'update') ? $model->AreaID : '[Auto Generate]' ?></td>
                    </tr>
                    <tr>
                        <td>Area Name</td>
                        <td><?=
                                    $form->field($model, 'Description')->textInput(['maxlength' => 255, 'style' => 'width:400px'])->label(false)
                            ?> 
                        </td>
                    </tr>
                    <?php if (Yii::$app->controller->action->id == 'update') { ?>
                        <tr>
                            <td></td>
                            <td><?= $form->field($model, 'IsActive')->checkbox() ?> </td>
                        </tr>
                    <?php } ?>
                </table>    
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?> 
</div>

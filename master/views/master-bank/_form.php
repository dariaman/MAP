<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\master\models\MasterBankGroup;
use kartik\widgets\Select2;
 
$readonly=(Yii::$app->controller->action->id == 'update') ? true : false;

?>
    
<div class="master-bank-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">BankID</td>
                            <td><b><?=(Yii::$app->controller->action->id == 'update') ? $model->BankID :'[Auto Generate]' ?></b></td>
                        </tr>
                        <tr>
                             <td style="width: 200px;">Bank Nama </td>
                             <td><?= $form->field($model,'BankName')->textInput(['maxlength'=>255,'style'=> 'width:250px;','readonly' => $readonly])->label(false); ?></td>
                        </tr>
                        <tr>
                            <td>Bank Group Nama </td>
                            <td><?= $form->field($model, 'BankGroupID')->widget(Select2::classname(),[
                                            'data' => ArrayHelper::map(MasterBankgroup::find()->all(),'BankGroupID','BankGroupName'),
                                            'options' => [
                                                'placeholder' => 'Pilih Bank Group...',
                                                'style' => 'width:350px;',
                                            ],
                                        ])->label(false); ?></td>
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

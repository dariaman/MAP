<?php

use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\Select2;
$this->title = 'Buat Cost Calc Baru';
?>

<div class="cos-cal-h-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    
    $job = \app\master\models\MasterJobDesc::find()
            ->select('Description,IDJobDesc')
            ->from('MasterJobDesc ')
            ->orderBy('Description')
            ->all();

    $arrayhelperjob = ArrayHelper::map($job,'IDJobDesc','Description');
    
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:200px;">CostCalcID</td>
            <td><b>[Auto Generate]</b></td>
        </tr>
        
        <tr>
            <td>Cost Calc Date</td>
            <td><?php 
                echo  $form->field($model, 'CostcalDate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                   'format' => 'yyyy-mm-dd',
                                               'todayHighlight' => true]
                ]); ?>            
            </td>
        </tr>
        <tr>
            <td>Job Description</td>
            <td><?= $form->field($model, 'JobDescID')->dropDownList($arrayhelperjob,['prompt'=>'Pilih JobDescription']) ?></td>
        </tr>
        <?php if(!$model->isNewRecord){ ?>
        <tr>
            <td>Is Active</td>
            <td><?= $form->field($model, 'IsActive')->checkbox() ?></td>
        </tr>
        <?php }?>
    </table>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
        <?php if(Yii::$app->request->referrer == null){
                echo Html::a('Back', ['cos-cal-h/index'], ['class' => 'btn btn-success']);
            }else{
                echo Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-success']);
            }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\HariLibur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hari-libur-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tr>    
                        <td> Tanggal Libur</td>
                        <td>
                 <?= DatePicker::widget([
                    'model' => $model, 
                    'attribute' => 'Tgl',
                    'options' => ['placeholder' => 'Enter Tgl ...'],
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                    ]); ?>
                        </td>
                    </tr>

                    <tr>    
                        <td> Keterangan </td>
                        <td>
                    <?= $form->field($model, 'Ket')->textInput() ?>
                             </td>
                    </tr>

                    <tr>    
                        <td> IsActive </td>
                        <td>
                    <?= $form->field($model, 'IsActive')->checkbox() ?>
                        </td>
                    </tr>
                </table>    
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>    
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

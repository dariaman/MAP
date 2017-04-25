<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bootui\datetimepicker\Datepicker;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\SuratPeringatan */
/* @var $form yii\widgets\ActiveForm */
$url='index.php?r=payroll/surat-peringatan/product'
?>
<?php
$script = <<<SKRIPT

//$(function(){
//$('#modalp').click(function() {
//	$('#modal').modal('show')
//		.find('#modalall')
//		.load($(this).attr('value'));
//
//	})
//        });
        
    $('#modalp').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=1024,height=600,scrollbars=yes,location=no");
});

SKRIPT;

$this->registerJs($script);
?>
<div class="surat-peringatan-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">

     <!--$form->field($model, 'SpNo')->textInput()-->
      <tr>    
        <td> Sp Date</td>
        <td>

    <?= Datepicker::widget([
                'name' => 'SPdate',
                'options' => ['class' => 'form-control','style'=> 'width:200px;'],
                'addon' => ['prepend' => 'SP Date'],
                'format' => 'YYYY-MM-DD',
            ]); ?>
        </td>
      </tr>
      
    <?= '<input type=hidden name=sp id=cp>'?>
       <tr>    
        <td> Product ID</td>
        <td>
    <?= $form->field($model, 'ProductID')->textInput(['disabled'=>TRUE,'id'=>'cu','style'=> 'width:400px;']) ?>
     <?= Html::a('...',$url,['class'=>'btn btn-success','id'=>'modalp']);?>
        </td>
      </tr>
    <tr>
        <td> Remark </td>
        <td>
    <?= $form->field($model, 'Remark')->textInput(['style'=> 'width:400px;']) ?>
            </tr>
    </td>
<!--    $form->field($model, 'ApproveBy')->textInput() -->

<tr>
    <td> Approve Date</td>
    <td>
     <?= DatePicker::widget([
    'model' => $model, 
    'attribute' => 'ApproveDate',
    'options' => ['placeholder' => 'Enter Approve date ...','style'=> 'width:200px;'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);
      ?>
    <td>
</tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

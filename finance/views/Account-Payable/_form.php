<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountPayable */
/* @var $form yii\widgets\ActiveForm */
$script = <<<SKRIPT

 $('#btnn').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=1024,height=600,scrollbars=yes,location=no");
}); 
SKRIPT;

$this->registerJs($script);
?>

<div class="account-payable-form">

    <?php $form = ActiveForm::begin(); ?>
  <table class="table table-striped table-bordered">
    <tr>
        <td> AP Date </td>
        <td>
    <?=DatePicker::widget([
    'model' => $model, 
    'attribute' => 'APDate',
    'options' => ['placeholder' => 'Enter AP date ...','style'=> 'width:200px;'],
    'pluginOptions' => [
        'autoclose'=>true,
         
    ]
]);
      ?>
        </td>
    </tr>
    <tr>
        <td> Total Amount </td>
        <td>
    <?= $form->field($model, 'TotalAmount')->textInput( ['style'=> 'width:400px;']) ?>
             </td>
    </tr>
      <tr>
        <td> PPN </td>
        <td>
    <?= $form->field($model, 'PPN')->textInput(['style'=> 'width:400px;']) ?>
            </td>
    </tr>
         <tr>
        <td> PaidNo </td>
        <td>
    <?= $form->field($model, 'PaidNo')->textInput(['style'=> 'width:400px;']) ?>
</td>
    </tr>
  
       <tr>
        <td> Paid Date </td>
        <td>
    <?=DatePicker::widget([
    'model' => $model, 
    'attribute' => 'PaidDate',
    'options' => ['placeholder' => 'Enter Paid date ...','style'=> 'width:200px;'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);
      ?>
        </td>
       </tr>
         <tr>
        <td> Remark </td>
        <td>
    <?= $form->field($model, 'PaidRemark')->textInput(['style'=> 'width:400px;']) ?>
              </td>
       </tr>
  </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

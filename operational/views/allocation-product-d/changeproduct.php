<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
//use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ChangeAllocationProduct */
/* @var $form yii\widgets\ActiveForm */

$script = <<<SKRIPT
  
$('#prbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=600,height=600,scrollbars=yes,location=no");
});
        
SKRIPT;

$this->registerJs($script);



if (isset($_GET['id'])){
    $id = preg_replace('/[^A-Za-z0-9\-]/', '', $_GET['id']);
}else {  
    $id ='xxx'; 
}

$sql    = Yii::$app->db->createCommand("Select Status from AllocationProductD where AllocationProductDID ='".$id."'");
$excute = $sql->queryScalar();

if($excute == 'RFA')
{
    $btn    =  Html::a('Approve',['/operational/allocation-product-d/changeapprove','id'=>$id],['class' => 'btn btn-success']);
    $button = Html::submitButton('Corection',['class' => 'btn btn-success']);
    $act    = './index.php?r=operational/allocation-product-d/correctionchange';
}
else{
    $btn    = '';
    $button = Html::submitButton('Request For Approval',['class' => 'btn btn-success']);
    $act    = './index.php?r=operational/allocation-product-d/rfa';
  
}


?>
<div class="change-allocation-product-form">

    <?php $form = ActiveForm::begin(['action'=>$act,'method' => 'post']); 
        
    $styletd = '150px;';
    ?>
    <input type="hidden" name="idaph" value="<?= $_GET['idaph']; ?>">
    <input type="hidden" name="idapd" value="<?= $_GET['id']; ?>">
   
 <table class="table table-striped table-bordered"> 
    <tr> 
        <td>Product ID </td>
        <td>
            <?= $form->field($model, 'ProductID')->textInput(['readonly'=>false,'style'=>'width:400px','class' => 'form-control medbox display-block','id'=>'prodhid']) ?>
            <?= Html::a('...',['/lookup/prod','idaph' => $_GET['idaph']],['class'=>'btn btn-success','id'=>'prbutton']); ?>
       </td>
    </tr>
        <tr> 
        <td>Reason </td>
        <td>
            <?= Html::textarea('reason') ?>
       </td>
    </tr>
<!--    <tr>
        <td>To Date</td>
           
        <td>
    <?php 
                echo  $form->field($model, 'PeriodTo')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                   'format' => 'yyyy-mm-dd',
                                               'todayHighlight' => true]
                ]); ?>
        </td>
    </tr>-->
 </table>

    <div class="form-group">
       
        <?= $button ?>
        <?= $btn ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>
     
 
    <?php ActiveForm::end(); ?>
 
</div>

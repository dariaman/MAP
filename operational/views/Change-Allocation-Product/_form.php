<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ChangeAllocationProduct */
/* @var $form yii\widgets\ActiveForm */
$url=Url::to('index.php?r=operational/change-allocation-product/allocation');

?>
<?php Modal::begin(['header'=>'<h4>Vlookup</h4>',
             'id'=> 'modal',
             'size'=>'modal-lg',
         ]);
echo"<div id='modalall'></div>";
modal::end();
?>
<div class="change-allocation-product-form">

    <?php $form = ActiveForm::begin(); 
        
    $styletd = '150px;';
    ?>

     <!--$form->field($model, 'ChangeAllocationProductID')->textInput()-->
 <table class="table table-striped table-bordered"> 
    <tr> 
        <td style="width:<?= $styletd ?>"> Allocation Product ID </td>
        <td> <?= $form->field($model,'AllocationProductID') ?>
    <?php $form->field($model, 'AllocationProductID')->textInput(['disabled'=>true,'id'=>'a','style'=>'width:400px']) ?>
      <?php Html::button('...', ['value'=>$url,'class' => 'btn btn-success','id'=>'modala']);?>
        </td>
    </tr>
      <?='<input type=hidden name=allocation id=aa value= >'; ?>
     <tr> 
        <td> SO ID </td>
        <td>
    <?= $form->field($model, 'SOID')->textInput(['disabled'=>true,'id'=>'b','style'=>"width:400px"]) ?>
          </td>
    </tr>
      <?='<input type=hidden name=soid id=bb value= >'; ?>
     <tr> 
        <td>Reff ID </td>
        <td>
    <?= $form->field($model, 'RefID')->textInput(['disabled'=>true,'id'=>'c','style'=>'width:400px']) ?>
        </td>
     </tr>
         <?='<input type=hidden name=refid id=cc value= >'; ?>
      <tr> 
        <td>Job Desc ID </td>
        <td>
    <?= $form->field($model, 'JobDescID')->textInput(['disabled'=>true,'id'=>'d','style'=>'width:400px']) ?>
          </td>
     </tr>
         <?='<input type=hidden name=jobdescid id=dd value= >'; ?>
       <tr> 
        <td>Area ID </td>
        <td>
    <?= $form->field($model, 'AreaID')->textInput(['disabled'=>true,'id'=>'e','style'=>'width:400px']) ?>
          </td>
     </tr>
         <?='<input type=hidden name=areaid id=ee value= >'; ?>
     <tr> 
        <td>Product ID </td>
        <td>
    <?= $form->field($model, 'ProductID')->textInput(['disabled'=>true,'id'=>'f','style'=>'width:400px']) ?>
       </td>
     </tr>
         <?='<input type=hidden name=productid id=ff value= >'; ?>
      <tr> 
        <td>To Product ID</td>
        <td>
    <?= $form->field($model, 'ToProductID')->textInput(['disabled'=>true,'id'=>'g','style'=>'width:400px']) ?>
             </td>
     </tr>
      <?='<input type=hidden name=toproduct id=gg value= >'; ?>
      <tr> 
        <td> Product Freelance</td>
        <td>
    <?= $form->field($model, 'ProductFreelance')->textInput(['maxlength'=>100,'style'=>'width:400px']) ?>
         </td>
     </tr>
      <tr> 
        <td> Tipe </td>
        <td>
    <?= $form->field($model, 'Tipe')->dropDownList(['sakit'=>'sakit','alpha'=>'alpha','izin'=>'izin','cuti'=>'cuti'],['prompt'=>'Pilih Tipe','style'=>'width:200px']) ?>
       </td>
     </tr>
      <tr> 
        <td> Remark </td>
        <td>
    <?= $form->field($model, 'Remark')->textarea(['maxlength'=>200,'style'=>'width:400px','rows'=>2]) ?>
             </td>
     </tr>
    
  <tr>
         <td> From Date  </td>
         <td>
    <?=DatePicker::widget([
    'model' => $model, 
    'attribute' => 'FromDate',
    'options' => ['placeholder' => 'Enter From Date  ...','style'=>'width:200px'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);       
      ?>
         </td>
     </tr>
          <tr>
            <td>To Date</td>
           
              <td>
    <?=DatePicker::widget([
    'model' => $model, 
    'attribute' =>  'ToDate',
    'options' => ['placeholder' => 'Enter ToDate ...','style'=>'width:200px'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);       
      ?>
         </td>
        </tr>
 </table>

    <div class="form-group">
       
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>
     
 
    <?php ActiveForm::end(); ?>
 
</div>




<?php
$script = <<<SKRIPT

$(function(){
$('#modala').click(function() {
	$('#modal').modal('show')
		.find('#modalall')
		.load($(this).attr('value'));

	})
        });

SKRIPT;

$this->registerJs($script);
?>

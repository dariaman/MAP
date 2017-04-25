<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    $form->field($model, 'ItemID')->textInput() -->
 <table class="table table-striped table-bordered">
<tr>
    <td> Item Description </td>
    <td>
    <?= $form->field($model, 'ItemDescription')->textarea(['maxlength'=>50,'style'=> 'width:400px;','rows'=>2]) ?>
    </td>
</tr>
<?php if(!$model->isNewRecord)
    {
    ?>
    <tr>
        <td>
            Is Active
        </td>
        <td>
        <?php  echo $form->field($model, 'IsActive')->checkbox() ?>
        </td>
    </tr>
    <?php 
    
    }?>
 </table>
<!--     $form->field($model, 'UserCrt')->textInput() 

     $form->field($model, 'DateCrt')->textInput() -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>

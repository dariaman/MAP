<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollInsentiveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options'=> ['data-pjax' => true],
    ]); 

        if(isset($_POST['typeSearch']))
        {
            $type = $_POST['typeSearch'];
        } else {
            $type = NULL;
        }

        if(isset($_POST['textsearch']))
        {
            $text = $_POST['textsearch'];
        } else {
            $text = NULL;
        }
    
    ?>


    <div class="box-body">
        <div class="form-group">
            <?= Html::dropDownList('typeSearch',$type,['ProductID'=>'ProductID', 'IDTunjangan'=>'Description'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']); ?>
            <?= Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']); ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary','id'=>'searchbtn']) ?>
          
         </div>
     </div>
    <?php ActiveForm::end(); ?>

</div>

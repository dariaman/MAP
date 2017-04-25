<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\NilaiTesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nilai-tes-search">

    <?php $form = ActiveForm::begin([
//        'id'=>['PtlCommentsPjax'],
        'action' => ['index'],
        'method' => 'post',
         'options' => ['data-pjax' => true ],
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
       
   
        echo Html::dropDownList('typeSearch',$type,
                        ['1'=>'ChangeAllocationProductID', '2'=>'AllocationProductID'],
                        ['prompt'=>'ALL','class'=>'form-control','id' => 'searchdrop']) ;
        echo Html::textInput('textsearch',$text,['id' => 'searchbox', 'class' => 'form-control']);

            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
//            echo Html::resetButton('Reset', ['class' => 'btn btn-default']) 

     ActiveForm::end(); ?>
   

</div>

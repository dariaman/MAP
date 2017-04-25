<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="offering-h-search">

    
    <?php 
        if (isset($_GET['jobID'])){
            $idjo = '&jobID=' . $_GET['jobID'];
            $form = ActiveForm::begin([
                'action' => ['lookup-costcal','jobID'=>$_GET['jobID']],
                'method' => 'post',
                'options' => ['data-pjax' => true],
            ]);
        }else{
            $form = ActiveForm::begin([
                'action' => ['lookup-costcal'],
                'method' => 'post',
                'options' => ['data-pjax' => true],
            ]);
        }
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
    
        echo Html::dropDownList('typeSearch',$type,['1'=>'Coscal ID',],
                                            ['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>
    <div class="form-group">
        <?php 
            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
//            echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); 
        ?>

</div>

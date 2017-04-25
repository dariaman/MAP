<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['data-pjax'=>true],
    ]); ?>
    
    <?php 
    
    $type = Yii::$app->request->post('typeSearch','');
    $text = Yii::$app->request->post('textsearch','');
            
        echo Html::dropDownList('typeSearch',$type,
                    ['ProductID'=>'Product ID'],
                    ['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

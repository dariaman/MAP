<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="master-customer-search">

     <?php $form = ActiveForm::begin([
        'action' => ['lookupcustomer'],
        'method' => 'post',
        'options' => ['data-pjax' => true],
    ]); ?>

    <?php
    
    $type = Yii::$app->request->post('typeSearch');
    $text = Yii::$app->request->post('textsearch');
    
        echo Html::dropDownList('typeSearch',$type,
                                ['CustomerID'=>'Customer ID',
                                 'CustomerName'=>'Customer Name',
                                 'NPWP'=>'NPWP',]
                ,['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

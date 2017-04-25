<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\operational\models\SOSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="so-search">

    <?php $form = ActiveForm::begin([
        'action' => ['cus'],
        'method' => 'post',
         'options' => ['data-pjax' => true ],
        
    ]); 

    $type = Yii::$app->request->post('typeSearch');
    $text = Yii::$app->request->post('textsearch');
       
   
echo Html::dropDownList('typeSearch',$type,['1'=>'Customer ID', '2'=>'Parent ID','3'=>'Customer Name'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
echo Html::textInput('textsearch',$text,['id' => 'searchbox', 'class' => 'form-control']);
echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);

     ActiveForm::end(); ?>

</div>



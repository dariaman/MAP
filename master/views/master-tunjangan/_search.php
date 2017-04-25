<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options'=> ['data-pjax'=>true],
        
    ]);
    
    $type = Yii::$app->request->post('typeSearch','');
    $text = Yii::$app->request->post('textsearch','');
    
    echo Html::dropDownList('typeSearch',$type,
                       ['IDTunjangan'=>'ID Tunjangan', 'Description'=>'Description'],
                       ['prompt'=>'ALL','class'=>'form-control', 'id'=> 'searchdrop']) ;
    echo Html::textInput('textsearch',$text,['class' => 'form-control','id' => 'searchbox']);

    echo Html::submitButton('Search', ['class' => 'btn btn-primary','id' => 'searchbtn']);

   ActiveForm::end(); 
   ?>

</div>
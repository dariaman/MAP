<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterPegawaiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => ['data-pjax' => true],
    ]); ?>
    <?php 
    
        $type = Yii::$app->request->post('typeSearch','');
        $text = Yii::$app->request->post('textsearch','');
    
        echo Html::dropDownList('typeSearch',$type,
        [
            'mc.CalonProductID'=>'CalonProductID',
            'mc.Nama'=>'Nama',
            'mjd.Description'=>'Job Desc',
            'KTP'=>'KTP',
            'SIM'=>'SIM',
            'NPWP'=>'NPWP'
        ],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>
    <div class="form-group">
        <?php 
            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
    ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

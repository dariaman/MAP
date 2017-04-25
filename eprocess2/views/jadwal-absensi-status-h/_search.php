<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\helpers\Enum;
?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>

    <?php 
        
        $type = Yii::$app->request->post('typeSearch','');
        $text = Yii::$app->request->post('textsearch','');

        $yearnw = Yii::$app->request->post('tahun',date('o'));
        $monthnw = Yii::$app->request->post('bulan',date('m'));
    ?>
    
        <table style="width:100%;" class="kv-grid-table table table-bordered table-striped">
            <tr>
                <td style="width:150px;"><b>Bulan</b></td>
                <td><?=Html::dropDownList('bulan',$monthnw,Enum::monthList(),['class' => 'form-control','id' => 'month', 'style' => 'display:block;'])?></td>
            </tr>
            <tr>
                <td><b>Tahun</b></td>
                <td><?=Html::dropDownList('tahun',$yearnw,Enum::yearList(date('o')-1, date('o'), true, false),['class' => 'form-control display-block','id' => 'year'])?></td>
            </tr>
            <tr>
                <td><?=Html::dropDownList('typeSearch',$type,['1'=>'Customer Name','2'=>'Area Name','3'=>'Max Absensi'],['prompt'=>'ALL','class' => 'form-control'])?></td>
                <td><?php 
                echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']); 
                echo Html::submitButton('Search', ['class' => 'btn btn-primary','id'=>'searchbtn']); ?></td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>

</div>

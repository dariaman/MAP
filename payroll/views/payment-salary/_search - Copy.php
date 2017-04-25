<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\helpers\Enum;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-salary-search">

   <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>

    <?php 
        
        $type = Yii::$app->request->post('typeSearch','');
        $text = Yii::$app->request->post('textsearch','');

        $yearnw = Yii::$app->request->post('tahun',date('o'));
        $monthnw = Yii::$app->request->post('bulan',date('m'));
        
        $arrnew = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    ?>
    
        <table style="width:100%;" class="kv-grid-table table table-bordered table-striped">
            <tr>
                <td style="width:200px;"><b>Bulan</b></td>
                <td><?=Html::dropDownList('bulan',$monthnw,$arrnew,['class' => 'form-control','id' => 'month', 'style' => 'display:block;'])?></td>
            </tr>
            <tr>
                <td><b>Tahun</b></td>
                <td><?=Html::dropDownList('tahun',$yearnw,Enum::yearList(date('o')-1, date('o'), true, false),['class' => 'form-control display-block','id' => 'year'])?></td>
            </tr>
            <tr>
                <td><?=Html::dropDownList('typeSearch',$type,['ph.ProductID'=>'Product ID','mp.Nama'=> 'Nama', 'mj.Description'=> 'JobDesc'],['prompt'=>'ALL','class' => 'form-control','style' => 'display:block; margin-bottom:1%; float:left;'])?></td>
                <td><?php 
                echo Html::textInput('textsearch',$text,['class' => 'form-control display-block','id'=> 'searchbox']); 
                echo Html::submitButton('Search', ['class' => 'btn btn-primary','id'=>'searchbtn']); ?></td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\helpers\Enum;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-salary-search">

   <?php $form = ActiveForm::begin([
        'action' => ['rpt-slip'],
        'method' => 'post',
    ]); ?>

    <?php 
        
        $type = Yii::$app->request->post('typeSearch','');
        $text = Yii::$app->request->post('textsearch','');

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
                <td><?=Html::dropDownList('bulan',$bulan,$arrnew,['class' => 'form-control','id' => 'month', 'style' => 'display:block;'])?></td>
            </tr>
            <tr>
                <td><b>Tahun</b></td>
                <td><?=Html::dropDownList('tahun',$tahun,Enum::yearList(date('o')-1, date('o'), true, false),['class' => 'form-control display-block','id' => 'year'])?>
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary','id'=>'searchbtn']); ?>
                </td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\helpers\Enum;

$script = <<<SKRIPT

$('#buttonpro').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "_blank", "width=1000,height=600,scrollbars=yes,location=no");
    });
    

function _(x)
{
   return document.getElementById(x);
}
        
$(document).ready(function() {
    if( _('payrollpotongan-isreguler').checked )
    {
        $('#year').hide();
        $('#bln').hide();
        $('#period').hide();
    }
    
    $('#payrollpotongan-isreguler').change(function(){     
        if( _('payrollpotongan-isreguler').checked )
        {
            $('#year').hide();
            $('#bln').hide();
            $('#period').hide();
        }
        else
        {
            $('#year').show();
            $('#bln').show();
            $('#period').show();
        } 
        
    });
        
 });
       
SKRIPT;

$this->registerJs($script);



$JenisTunjangan = app\master\models\MasterPotongan::find()->select(['IDPotongan','Description'])
                                                           ->from('MasterPotongan')
                                                           ->all();
$a = date('Y');
$year = (Yii::$app->request->get('tahun') ?? $a);

for($i = $a ;$i<=$a+1; $i++) {
    $array[$i] = $i;
}

?>

<div class="payroll-potongan-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tr> 
                         <td style="width: 200px;"> Product ID</td>
                         <td><?= $form->field($model, 'ProductID')->textInput(['readonly' => true, 'id' => 'id-prod-fix', 'style' => "width:260px", 'name' => 'prod-id-payroll'])->label(false); ?> 
                             <?= Html::a('', ['/lookup/pro'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonpro']) ?>
                         </td> 
                     </tr>  
                     <tr>
                         <td>Product Name</td>
                         <td><label id="prod-name-payroll"> <?= $model->Nama ?? '...'?> </label> </td>
                     </tr>
                     <tr>
                         <td>Job Description</td>
                         <td><label id="prod-jobdesk-payroll"> <?= $model->jobdesk ?? '...'?> </label> </td>
                     </tr>
                    <tr>
                        <td>Tanggal Potongan</td>
                        <td><?= $form->field($model, 'tgl')->widget(DatePicker::classname(), [
                                 'options' => [
                                     'placeholder' => 'Enter Date ...'
                                     ],
                                     'pluginOptions' => ['autoclose'=>true,
                                         'format' => 'yyyy-mm-dd',
                                         'todayHighlight' => true]
                             ])->label(false); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Potongan</td>
                        <td><?= $form->field($model, 'ItemID')->dropDownList(ArrayHelper::map($JenisTunjangan,'IDPotongan','Description'),['prompt' => 'Pilih Jenis Potongan'])->label(false) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td> <?= $form->field($model, 'Amount')->textInput()->label(false); ?></td>
                   </tr>
                    <tr>
                        <td>Status</td> 
                        <td> <?= $form->field($model, 'IsReguler')->checkbox()->label(false); ?></td>
                    </tr> 
                    <tr id="period">
                        <td>Periode Pemotongan</td>
                        <td><?= Html::dropDownList('Thn',substr($model->PeriodePayroll,0,4),$array,['prompt'=>'Tahun','class' => 'form-control','id' => 'year']); ?>
                          <?= Html::dropDownList('Bulan',substr($model->PeriodePayroll,-2),
                                                                ['01' => 'Januari', 
                                                                 '02' => 'Febuari', 
                                                                 '03' => 'Maret', 
                                                                 '04' => 'april',
                                                                 '05' => 'Mei',
                                                                 '06' => 'Juni',
                                                                 '07' => 'Juli',
                                                                 '08' => 'agustus',
                                                                 '09' => 'September',
                                                                 '10' => 'November',
                                                                 '11' => 'Oktober',
                                                                 '12' => 'Desember'],
                                ['prompt'=>'Bulan','class' => 'form-control','id' => 'bulan']); ?>
                        </td>
                     <tr>
                            <td>Remark</td>
                            <td> <?= $form->field($model, 'Remark')->textInput(['style'=>'width:200px'])->label(false); ?> </td> 
                        </tr>
                            <?php
                            if(!$model->isNewRecord){
                                 echo '<tr><td>IsActive</td><td>';
                                         echo $form->field($model, 'IsActive')->checkbox();
                                 echo '</td></tr>';
                            }
                            ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save' , ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' =>'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
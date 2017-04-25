<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\helpers\Enum;

// $type = Yii::$app->request->post('typeSearch','');
// $text = Yii::$app->request->post('textsearch','');

$yearnw = Yii::$app->request->post('tahun',date('o'));
$monthnw = Yii::$app->request->post('bulan',date('m'));


// $year = date('Y');  
// $yearf = $year+3;
// $array = array();
//     for($i = $year;$i<=$yearf;$i++)
//     {
//         $array[$i] = $i;

//     }
    
//     if(isset($_GET['tahun']))
//     {
//         $year = $_GET['tahun'];
//     } else {
//         $year = date('Y');
//     }
$JenisPotongan = app\master\models\MasterPotongan::find()->select(['IDPotongan','Description'])
                                                           ->from('MasterPotongan')
                                                           ->all();

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
                    <!--<input type="hidden" name="pID" id="pid"/>-->
                    <tr>
                        <td style="width: 200px">ProductID</td>
                         <td><?= $form->field($model, 'ProductID')->textInput(['Readonly'=>'true']) ?>

 <?= Html::a('', ['/lookup/pro'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonpro']) ?>

                             
                         </td> 
                    </tr>
                 <!--   <tr>
                        <td>Status Overtime</td> 
                        <td> <?php //$form->field($model, 'IsOT')->checkbox() ?></td>
                    </tr> -->
                    <tr>
                        <td>Tanggal Reimburse</td>
                        <td><?= $form->field($model, 'tgl')->widget(DatePicker::classname(), [
                                 'options' => [
                                     'placeholder' => 'Enter Date ...'
                                     ],
                                     'pluginOptions' => ['autoclose'=>true,
                                         'format' => 'yyyy-mm-dd',
                                         'todayHighlight' => true]
                             ]); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Potongan</td>
                        <td><?=$form->field($model, 'ItemID')->widget(Select2::classname(),
                                         [ 
                                            'options' => ['placeholder' => 'Select Jenis Potongan ...','style'=>'width:200px;'],                  
                                            'data'=> ArrayHelper::map($JenisPotongan,'IDPotongan','Description'),
                                            'pluginOptions' => ['allowClear' => true ],

                                         ]
                                  );
                              ?>
                         </td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td> <?= $form->field($model, 'Amount')->textInput() ?></td>
                   </tr>
                    <tr>
                        <td>Status</td> 
                        <td> <?= $form->field($model, 'IsReguler')->checkbox(['id'=>'regu']) ?></td>
                    </tr> 
                    <tr id="period">
                        <td >Periode Pembayaran</td>
                        <td> <?=Html::dropDownList('Thn',$yearnw,Enum::yearList(date('o'), date('o')+2, true, false),['class' => 'form-control display-block','id' => 'year'])?>

                                <?=Html::dropDownList('bulan',$monthnw,Enum::monthList(),['class' => 'form-control','id' => 'month'])?></td>
                     <tr>
                        <td>Remark</td>
                        <td> <?= $form->field($model, 'Remark')->textInput(['style'=>'width:200px']) ?></td>
                     </tr>
                    </tr>
                        <?php 
                                 if(!$model->isNewRecord)
                                 {
                                     echo'<tr>';
                                             echo '<td>IsActive</td>';  
                                             echo '<td>';
                                             echo $form->field($model, 'IsActive')->checkbox();
                                             echo '<td>';
                                     echo '</tr>';
                                 }
                               ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
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
    $('#regu').change(function(){     
        if( _('regu').checked )
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
        
    $('#btnlookupprod').click(function(){
        $('#modalprodlookup').modal('show')
            .find('#modalprodcontent')
            .load($(this).attr('value'));        
    });
                
       
SKRIPT;

$this->registerJs($script);
?>
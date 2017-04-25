<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollInsentive */
/* @var $form yii\widgets\ActiveForm */


//    data MasterTunjangan
$JenisPotongan = app\master\models\MasterPotongan::find()->select(['IDPotongan','Description'])
                                                           ->from('MasterPotongan')
                                                           ->all();
    //tahun
$year = date('Y');  
$yearf = $year+3;
$array = array();
    for($i = $year;$i<=$yearf;$i++)
    {
        $array[$i] = $i;

    }
    
    if(isset($_GET['tahun']))
    {
        $year = $_GET['tahun'];
    } else {
        $year = date('Y');
    }
    
//    Bulan
//$arraybln = array();
//    for ($b = 1; $b <=12; $b++)
//    {
//        if($b<10)
//        {
//            $arraybln[$b] = '0'.$b;
//        }
//        else{
//            $arraybln[$b] = $b;
//        }
//         
//    }

  

?>

<div class="payroll-insentive-form">

    <?php $form = ActiveForm::begin(); ?>
   <table class="table table-striped table-bordered">
       <input type="hidden" name="PID" id="pid"/>
       <tr>
           <td style="width: 200px">ProductID</td>
            <td><?= $form->field($model, 'ProductID')->textInput(['readonly'=>'true']) ?>
                <?= Html::button('',
                                ['value'=> Url::to('?r=payroll/payroll-insentive/pro'),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookupprod']);
                        Modal::begin([
                                'header'=>'Product Detail',
                                'id' => 'modalprodlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalprodcontent></div>";
                        Modal::end();
                    ?>
            </td> 
       </tr>
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
            <td>Jenis Insentive</td>
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
            <td> <?= $form->field($model, 'Amount')->textInput() ?> </td> 
      </tr>
       <tr>
           <?php
           
           if($model->isNewRecord)
           {
               $tahun = NULL;
               $bulan = NULL;
           } else {
               $tahun = substr($model->PeriodeBayar,0,4);
               $bln = substr($model->PeriodeBayar, 4,2);
           }
           
           ?> 
            <td>Periode Pembayaran</td>
            <td><?= Html::dropDownList('Thn',$tahun,$array,['prompt'=>'Tahun','class' => 'form-control','id' => 'year']); ?>
                 <?= Html::dropDownList('Bulan',$bln,['01' => 'Januari', 
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
                                                                    '12' => 'Desember'],['prompt'=>'Bulan','class' => 'form-control','id' => 'bulan']); ?>
            </td>
        <tr>
            <td>Remark</td>
            <td> <?= $form->field($model, 'Remark')->textInput(['style'=>'width:200px']) ?> </td> 
        </tr>
       </tr>
           <?php
           if(!$model->isNewRecord)
           {
                echo '<tr>';
                        echo '<td>IsActive</td>';
                        echo '<td>';
                        echo $form->field($model, 'IsActive')->checkbox();
                        echo '</td>';
                echo '</tr>';
           }
           ?>       
   </table>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

$('#btnlookupprod').click(function(){
    $('#modalprodlookup').modal('show')
        .find('#modalprodcontent')
        .load($(this).attr('value'));        
});
SKRIPT;

$this->registerJs($script);
?>

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
$JenisTunjangan = app\master\models\MasterTunjangan::find()->select(['IDTunjangan','Description'])
                                                           ->from('MasterTunjangan')
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
  $script = <<<SKRIPT
        
  $('#buttonfix').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });

SKRIPT;

$this->registerJs($script);
?>

<div class="payroll-insentive-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <input type="hidden" name="PID" id="pid"/>
                        <tr> 
                             <td> Product ID</td>
                             <td><?= $form->field($model, 'ProductID')->textInput(['readonly' => true, 'id' => 'id-prod-fix', 'style' => "width:260px", 'name' => 'prod-id-payroll']) ?> 
                                 <?= Html::a('', ['/lookup/lookupproductpayroll'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonfix']) ?>
                             </td> 
                         </tr>  
                         <tr>
                             <td>Product Name</td>
                             <td><?= $form->field($model, 'namaprod')->textInput(['readonly' => true, 'id' => 'productfixname', 'style' => "width:260px", 'name' => 'prod-name-payroll']) ?> </td>
                         </tr>
                                 <tr>
                             <td>Job Description</td>
                             <td><?= $form->field($model, 'jobdesk')->textInput(['readonly' => true, 'id' => 'productfixjobdesk', 'style' => "width:260px", 'name' => 'prod-jobdesk-payroll']) ?> </td>
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
                                                'options' => ['placeholder' => 'Select Jenis Insentive ...','style'=>'width:200px;'],                  
                                                'data'=> ArrayHelper::map($JenisTunjangan,'IDTunjangan','Description'),
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
                             <td>Periode Pembayaran</td>
                             <td><?= Html::dropDownList('Thn',NULL,$array,['prompt'=>'Tahun','class' => 'form-control','id' => 'year']); ?>
                                  <?= Html::dropDownList('Bulan',NULL,['01' => 'Januari', 
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
                        </tr>
                        <tr>
                            <td>Remark</td>
                            <td> <?= $form->field($model, 'Remark')->textInput(['style'=>'width:200px']) ?> </td> 
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
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;

$this->title = 'Add Sales Order';

$script = <<<SKRIPT
        
    $('#buttonOFD').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "_blank", "width=1000,height=600,scrollbars=yes,location=no");
    });
    
    $('#buttonCusID').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "_blank", "width=1000,height=600,scrollbars=yes,location=no");
    });
        
    $()
   
        
    $("input[name='SOH[IsDirect]']").on('change', function() {
        if ($(this).val() == '0') {
            $('.subcus').show();
        }
        if ($(this).val() == '1') {
            $('.subcus').hide();
        }
        
    });
  
        
SKRIPT;

$this->registerJs($script);
?>
<div class="soh-form">
    <?php $form = ActiveForm::begin(); ?>
    <input type=hidden name=dohh id="ofhr" value="">
    <input type=hidden name=cuss id="cuss" value="">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr> 
                            <td style="width:200px"> Offering ID</td>
                            <td> 
                                <?= $form->field($model, 'OfferingIDH')->textInput(['readonly' => true, 'id' => 'id-prod-gs', 'style' => 'width:260px', 'name' => 'of-id'])->label(false) ?>
                                <?= Html::a('', ['/lookup/lookupso-offeringh'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonOFD']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Job Description</td>
                            <td><?= $form->field($model, 'jobdesc')->textInput(['readonly' => true, 'id' => 'jobdescription', 'style' => "width:260px", 'name' => 'of-jobdes'])->label(false) ?> </td>
                        </tr>
                        <tr>
                            <td>Offering Date</td>
                            <td><?= $form->field($model, 'ofdate')->textInput(['readonly' => true, 'id' => 'offeringdate', 'style' => "width:260px", 'name' => 'of-ofdate'])->label(false) ?> </td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td><?= $form->field($model, 'null')->textInput(['readonly' => true, 'id' => 'custname', 'style' => "width:80%", 'name' => 'of-custname'])->label(false) ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Tipe Customer</td>
                            <td>
                                <?=
                                        $form->field($model, 'IsDirect')
                                        ->radioList(['1' => 'Direct', '0' => 'Indirect'], ['style' => 'display:inline', 'labelSpan' => '0px'])->label(false)
                                ?>

                            </td>
                        </tr>
                        <tr class="subcus" style="display:none;"> 
                            <td style="width:200px"> Sub Customer ID</td>
                            <td> 
                                <?= $form->field($model, 'SubCustomerID')->textInput(['readonly' => true, 'id' => 'id-sub-cus', 'style' => 'width:260px', 'name' => 'sub-cus-id','value' => 'CUS00000SS']) ?>
                                <?php //Html::a('', ['/lookup/lookupcustomer'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonCusID']) ?>
                            </td>
                        </tr>
                        <tr class="subcus" style="display:none;">
                            <td>Customer Name</td>
                            <td><?= $form->field($model, 'null')->textInput(['readonly' => true, 'id' => 'subcustomername', 'style' => "width:80%",'value' => 'PT. SURYA SUDECO'])->label(false) ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Tipe Kontrak</td>
                            <td>
                                <?=
                                        $form->field($model, 'TipeKontrak')
                                        ->radioList(['LT' => 'Long Term', 'ST' => 'Short Term'], ['style' => 'display:inline', 'labelSpan' => '0px'])->label(false)
                                ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Tipe Bayar</td>
                            <td>
                                <?=
                                        $form->field($model, 'TipeBayar')
                                        ->radioList(['ADV' => 'Advanced', 'ARR' => 'Arrear'], ['style' => 'display:inline', 'labelSpan' => '0px'])->label(false)
                                ?>

                            </td>
                        </tr>
                        <tr>
                            <td>SO Date</td>
                            <td><?php
                                echo $form->field($model, 'SODate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true]
                                ])->label(false);
                                ?>
                            </td>
                        </tr>        

                        <tr>
                            <td>PO No</td>
                            <td><?= $form->field($model, 'PONo')->textInput(['maxlength' => 50, 'class' => 'form-control medbox'])->label(false) ?></td>
                        </tr>
                        <tr>
                            <td>PO Date</td>
                            <td><?php
                                echo $form->field($model, 'POdate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true]
                                ])->label(false);
                                ?></td>
                        </tr>
                    </table>
                </div>
            </div> 
        </div>
        <div class="col-xs-12">
            <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Back', ['index'], ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<<SKRIPT
        
$('#btnlookupoffering').click(function(){
    $('#modalofferinglookup').modal('show')
        .find('#modalofferingcontent')
        .load($(this).attr('value'));        
});        


SKRIPT;

$this->registerJs($script);


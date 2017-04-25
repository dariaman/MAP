<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\date\DatePicker;
use kartik\widgets\DatePicker;

$script = <<<SKRIPT
        
  $('#buttongs').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });
     
  $('#buttonfix').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });

SKRIPT;

$this->registerJs($script);
?>

<div class="backup-product-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr> 
                            <td>Product ID FIX</td>
                            <td><?= $form->field($model, 'ProductIDFix')->textInput(['readonly' => true, 'id' => 'id-prod-fix', 'style' => "width:260px", 'name' => 'prod-id-fix'])->label(false); ?> 
                                <?= Html::a('', ['/lookup/lookupproductfix'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonfix']) ?>
                            </td> 
                        </tr>  
                        <tr>
                            <td>Product Name FIX</td>
                            <td><?= $form->field($model, 'ProductNameFix')->textInput(['readonly' => true, 'id' => 'productfixname', 'style' => "width:260px", 'name' => 'prod-name-fix'])->label(false); ?> </td>
                        </tr>
                        <tr>
                            <td>SODID</td>
                            <td><?= $form->field($model, 'SODID')->textInput(['readonly' => true, 'id' => 'productfixsodid', 'style' => "width:260px", 'name' => 'prod-sodid-fix'])->label(false); ?> </td>
                        </tr>
                        <tr>
                            <td>SeqProduct</td>
                            <td><?= $form->field($model, 'SeqProduct')->textInput(['readonly' => true, 'id' => 'productfixseq', 'style' => "width:260px", 'name' => 'prod-seqprod-fix'])->label(false); ?> </td>
                        </tr>
                        <tr>
                            <td>Customer Id</td>
                            <td><?= $form->field($model, 'CustomerID')->textInput(['readonly' => true, 'id' => 'productfixcusid', 'style' => "width:260px", 'name' => 'prod-cusid-fix'])->label(false); ?> </td>
                        </tr>
                        <tr> 
                            <td style="width:200px"> Product ID GS</td>
                            <td> 
                                <?= $form->field($model, 'ProductIDGS')->textInput(['readonly' => true, 'id' => 'id-prod-gs', 'style' => 'width:260px', 'name' => 'prod-id-gs'])->label(false); ?>
                                <?= Html::a('', ['/lookup/lookupproductgs', 'idjob' => 'kosong'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongs']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Product Name GS</td>
                            <td><?= $form->field($model, 'ProductNameGs')->textInput(['readonly' => true, 'id' => 'productgsname', 'style' => "width:260px", 'name' => 'prod-name-gs'])->label(false); ?> </td>
                        </tr>
                        <tr>
                            <td> Tgl Tugas </td>
                            <td>
                                <?php
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'TglTugas',
                                    'attribute2' => 'PeriodTo',
                                    'options' => ['placeholder' => 'Start date'],
                                    'options2' => ['placeholder' => 'End date'],
                                    'type' => DatePicker::TYPE_RANGE,
                                    'form' => $form,
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'autoclose' => true,
                                    ]
                                ]);
                                ?>     
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Status Absen </td>
                            <td>    
                                <?php
                                echo $form->field($model, 'StatusAbsen')->dropDownList(['A' => 'Alpha', 'C' => 'Cuti', 'S' => 'Sakit'], ['prompt' => 'Pilih Status Absensi..', 'style' => 'width:260px;'])->label(false);
                                ?> 
                            </td>
                        </tr>  
                        <tr>
                            <td> Reason </td>
                            <td>
                                <?php
                                echo $form->field($model, 'Reason')->textarea(['maxlength' => 255, 'style' => 'width:260px;', 'rows' => 3])->label(false);
                                ?>                 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?php
            echo Html::a('Back', ['backup-product/'], ['class' => 'btn btn-success']);
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
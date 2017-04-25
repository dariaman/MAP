<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$script = <<<SKRIPT
        
  $('#buttongs').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
    });
       
SKRIPT;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ProductPKWT */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs($script);
?>

<div class="product-pkwt-form">
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
                            <td style="width:200px"> Product ID GS</td>
                            <td> 
                                <?= $form->field($model, 'ProductID')->textInput(['readonly' => true, 'style' => 'width:260px', 'name' => 'prod-id-gs'])->label(false); ?>
                                <?= Html::a('', ['/lookup/lookupproductgs', 'idjob' => 'kosong'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongs']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Product Name GS</td>
                            <td><?= $form->field($model, 'Nama')->textInput(['readonly' => true, 'id' => 'namaproductgs', 'style' => "width:260px", 'name' => 'prod-name-gs'])->label(false); ?> </td>
                        </tr>
                        <tr>
                            <td>Period From </td>
                            <td> <?=
                                    $form->field($model, 'PeriodFrom')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Enter Date ...'],
                                        'pluginOptions' => ['autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true]
                                    ])->label(false);
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Period To </td>
                            <td> <?=
                                    $form->field($model, 'PeriodTo')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Enter Date ...'],
                                        'pluginOptions' => ['autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true]
                                    ])->label(false);
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Gaji Pokok</td>
                            <td><?= $form->field($model, 'GajiPokok')->textInput(['maxlength' => 15,'style' => "width:260px", 'style' => "text-align:right"])->label(false); ?> </td>
                        </tr>
                    <tr> 
                        <td style="width:200px"> Product ID GS</td>
                        <td> 
                            <?= $form->field($model, 'ProductID')->textInput(['readonly' => true, 'style' => 'width:260px'])->label(false) ?>
                            <?= Html::a('', ['/lookup/lookupproductgs', 'idjob' => 'kosong'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongs']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Product Name GS</td>
                        <td><label name="nama"></label> </td>
                    </tr>
                    <tr>
                        <td>Period From </td>
                        <td> <?=
                                $form->field($model, 'PeriodFrom')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true]])->label(false);
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Period To </td>
                        <td> <?=
                                $form->field($model, 'PeriodTo')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true]
                                ])->label(false);
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td><?= $form->field($model, 'GajiPokok')->textInput(['maxlength' => 15,'style' => "width:260px", 'style' => "text-align:right"])->label(false) ?> </td>
                    </tr>
                    </table>
            </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>    

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductH */
/* @var $form yii\widgets\ActiveForm */

$script = <<<SKRIPT
        
$('#sobutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});        

$('#btnlookupsoh').click(function(){
    $('#modalsohlookup').modal('show')
        .find('#modalsohcontent')
        .load($(this).attr('value'));        
});     
SKRIPT;

$this->registerJs($script);
?>

<div class="allocation-product-h-form">

    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" name="so" id="sohid">
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:100px;">SO ID</td>
            <td><?= $form->field($model, 'SOIDH')->textInput(['readonly'=>true,'class'=>'form-control medbox']) ?>
                <?php //Html::a('...','index.php?r=operational/allocation-product-h/soh',['class'=>'btn btn-success','id'=>'sobutton']); ?>
                <?= Html::button('',
                                ['value'=> Url::to('?r=lookup/lookupmodalsoh'),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookupsoh']);
                        Modal::begin([
                                'header'=>'SO Header',
                                'id' => 'modalsohlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalsohcontent></div>";
                        Modal::end();
                    ?>
            </td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td><?= $form->field($model, 'Description')->textarea(['class'=>'form-control medbox','rows'=>'2']) ?></td>
        </tr>
        <tr>
            <td>PIC Customer</td>
            <td><?= $form->field($model, 'PicCustomer')->textInput(['class'=>'form-control medbox']) ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat</td>
            <td><?= $form->field($model, 'TanggalSurat')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                   'format' => 'yyyy-mm-dd',
                                               'todayHighlight' => true]
                ]); ?></td>
        </tr>
    </table>    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Kembali','index.php?r=operational/allocation-product-h/index',['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

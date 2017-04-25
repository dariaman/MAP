<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

$CalonProductID = Yii::$app->request->get('CalonProductID');
$tesabsen = app\master\models\JenisTes::find()
        ->select('jt.IDJenisTes,jt.Description')
        ->from('JenisTes jt')
        ->Join('LEFT JOIN', 'NilaiTes nt', "nt.IDJenisTes=jt.IDJenisTes and nt.CalonProductID='$CalonProductID'")
        ->where('nt.CalonProductID is null')->all();

$calonproduct = app\master\models\NilaiTes::find()
        ->select('nt.CalonProductID, cp.Nama')
        ->from('NilaiTes nt')
        ->leftJoin('MasterCalonProduct cp', 'cp.CalonProductID = nt.CalonProductID')
        ->where('nt.CalonProductID is not null')->all();
//        
$script = <<<SKRIPT
        
 $('#buttonOFD').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "_blank", "width=1000,height=600,scrollbars=yes,location=no");
    });
        
        
        
$('#Nilai').keyup(function(event) {
       // skip for arrow keys
       if(event.which >= 37 && event.which <= 40) return;
       // format number
       $(this).val(function(index, value) {
             return value
            .replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
       });
        
});

SKRIPT;

$this->registerJs($script);
/* @var $this yii\web\View */
/* @var $model app\master\models\NilaiTes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nilai-tes-form">
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= 'Tambah Nilai Tes' ?></h1>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width: 150px">Calon Produk</td>
                            <td>
                                <?= $form->field($model, 'CalonProductID')->textInput(['readonly' => true, 'id' => 'id-prod-gs', 'style' => 'width:260px', 'name' => 'of-nilai'])->label(false) ?>
                                <?= Html::a('Click', ['/lookup/lookupso-offeringh'], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttonOFD']) ?>
                                <?= $form->field($model, 'CalonProductID')->dropDownList(ArrayHelper::map($calonproduct, 'CalonProductID', 'Nama'), ['prompt' => 'Pilih Jenis Tes...', 'style' => 'width:200px;'])->label(false);?>
                            </td>
                        </tr>
                        <tr>
                            <td>Status </td>
                            <td>
                                    <?= $form->field($model, 'IDJenisTes')->radioList(['Approved' => 'Approved','Draft' => 'Draft'],['name'=>'of-status'])->label(false);?>
                                <?= $form->field($model, 'IDJenisTes')->textInput(['readonly' => true, 'id' => 'id-prod-gs', 'style' => 'width:260px','name'=>'of-status'])->label(false);?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Test</td>
                            <td>    
                                <?php
                                    echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'TglTes',
                                    'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px'],
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Tes</td>
                            <td>
                                    <?= $form->field($model, 'IDJenisTes')->dropDownList(ArrayHelper::map($tesabsen, 'IDJenisTes', 'Description'), ['prompt' => 'Pilih Jenis Tes...', 'style' => 'width:200px;'])->label(false);?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai</td>
                            <td><?= $form->field($model, 'Nilai')->textInput(['maxlength' => 3 ,'style'=> 'width:200px;'])->label(false) ?></td>
                        </tr>
                        
                    </table>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            
        </div>
    </div>
</div>
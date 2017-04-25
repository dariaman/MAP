<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->title = 'Tanda Terima Billing';

$idInv = Yii::$app->request->get('invno','xxx');
$formatter = \Yii::$app->formatter;

$sql="select inv.InvoiceNo,
            inv.InvoiceDate 
        from Invoice inv 
        where inv.InvoiceNo='$idInv'
        ";
$modelInv = Yii::$app->db->createCommand($sql)->queryAll();
//echo var_dump($modelInv);
//die();
        
//if($modelInv[0]['Status'] != 'N') { $new = 'none';
//} 
//else { $new = 'in-line'; }
//
//if($modelInv[0]['Status'] != 'C') { $cancel = 'none' ; }
//else { $cancel = 'in-line'; }
?>

<div class="cos-cal-d-form">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">Invoice No</td>
                            <td>: <label id="CostcalH"><?= $idInv ?> </label></td>
                        <input type="hidden" value="<?= $idInv ?>" name="idInvNo">
                        </tr>
                        <tr>
                            <td>Invoice Date</td>
                            <td>: <?= date('j M Y',strtotime($modelInv[0]['InvoiceDate'])); ?></td>
                        </tr>
                        <tr>
                            <td>Pengirim</td>
                            <td>: <?= $form->field($model,'SendBy')->textInput(); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Kirim</td>
                            <td>: <?php 
                                echo  $form->field($model, 'SendDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                ]); ?> </td>
                        </tr>
                        <tr>
                            <td>Penerima</td>
                            <td>: <?= $form->field($model,'ReceivedBy')->textInput(); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Terima</td>
                            <td>: <?php 
                                echo  $form->field($model, 'ReceivedDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                ]); ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
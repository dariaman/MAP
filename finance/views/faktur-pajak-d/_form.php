<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\finance\models\FakturPajakD */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Edit Faktur Pajak Detail';

$id = Yii::$app->request->get('id');

?>

<div class="faktur-pajak-d-form">
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
                            <td style="width:200px;">Nomor Faktur pajak</td>
                            <td>: <?= $model->NoFakturPajak ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Kode Faktur pajak</td>
                            <td>: <?= $model->KodeFaktur ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Invoice Number</td>
                            <td>: <?= $model->InvoiceNo ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Invoice Date</td>
                            <td>: <?= $model->InvoiceDate ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Active</td>
                            <td>
                                <?=
                                        $form->field($model, 'IsActive')
                                        ->radioList(['1' => 'Active', '0' => 'No Active'], ['style' => 'display:inline', 'labelSpan' => '0px'])->label(false)
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', '', ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>  
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

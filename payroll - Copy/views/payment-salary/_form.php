<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalary */
/* @var $form yii\widgets\ActiveForm */

    $modelProduct = \app\master\models\MasterProduct::find()
            ->select('mp.Nama,mp.BankID, mp.BankAccNumber, mb.BankName,mbg.BankGroupName,mb.BankGroupID')
            ->from(['mp' => \app\master\models\MasterProduct::tableName()])
            ->leftJoin(['pgh' => \app\payroll\models\PayrollGajiH::tableName()],'pgh.ProductID = mp.ProductID')
            ->leftJoin(['mb' => \app\master\models\MasterBank::tableName()],'mb.BankID = mp.BankID')
            ->leftJoin(['mbg' => app\master\models\MasterBankGroup::tableName()],'mbg.BankGroupID = mb.BankGroupID')
            ->where(['pgh.PayrollGajiIDH' => $_GET['pgidh']])
            ->one();
    
    ?>
<div class="payment-salary-form">
    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" value="<?= $_GET['pgidh'] ?>" name="pgidh">
    <input type="hidden" value="<?= $modelProduct['BankGroupID'] ?>" name="bankgroupid">
    <input type="hidden" value="<?= $modelProduct['BankAccNumber'] ?>" name="bankaccnum">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>
                                Nama
                            </td>
                            <td>
                                : <?= $modelProduct['Nama']?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Bank Group
                            </td>
                            <td>
                                : <?= $modelProduct['BankGroupName']?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rekening Bank
                            </td>
                            <td>
                                : <?= $modelProduct['BankAccNumber']?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">
                                Nomor AP
                            </td>
                            <td>
                                : Auto Generate
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal AP </td><td> <?= $form->field($model, 'APDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                ]);
                            ?></td>
                        </tr>
                        <tr>
                            <td>
                                Amount
                            </td>
                            <td>
                                : <?= $form->field($model, 'AmountPayment')->textInput() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Biaya Admin
                            </td>
                            <td>
                                : <?= $form->field($model, 'BiayaAdmin')->textInput() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Bank MAP
                            </td>
                            <td>
                                : <?= $form->field($model, 'IDBankMAP')->dropDownList(['1' => 'Bank Permata', '2' => 'Bank CIMB', '3' => 'Bank BCA'],['prompt' => 'Select Bank']) ?>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton( 'Save' , ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

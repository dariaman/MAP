<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Detail Customer';

$sql = "select
        ma.StartAbsen , ma.EndAbsen
	from MasterCustomer mc , MasterAbsenType ma
    where ma.ID = mc.IDAbsenType and ma.ID='$model->IDAbsenType'";
$prod = Yii::$app->db->createCommand($sql)->queryAll();
?>

<div class="master-customer-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width: 200px">
                                CustomerID
                            </td>
                            <td><?= $model->CustomerID ?></td>
                        </tr>
                        <tr>
                            <td>Is Company</td>
                            <td>
                                <?php
                                if ($model->IsCompany == 1) {
                                    echo 'Company';
                                } else {
                                    echo 'Personal';
                                }
                                ?> 

                            </td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td><?= $model->CustomerName ?></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><?= $model->Address ?></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td><?= $model->City ?></td>
                        </tr>
                        <tr>
                            <td>Zip</td>
                            <td><?= $model->Zip ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td><?= $model->Phone ?></td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td><?= $model->Fax ?></td>
                        </tr>
                        <tr>
                            <td>Contact Name</td>
                            <td><?= $model->ContactName ?></td>
                        </tr>
                        <tr>
                            <td>Contact Phone</td>
                            <td><?= $model->ContactPhone ?></td>
                        </tr>
                        <tr>
                            <td>Contact Email</td>
                            <td><?= $model->ContactEmail ?></td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td><?= $model->NPWP ?></td>
                        </tr>
                        <tr>
                            <td>Input Absen </td>
                            <td><?= $model->StartAbsen .' - '. $model->EndAbsen ?></td>
                        </tr> 
                        <tr id="parentgroup">
                            <td>Formula Amount</td>
                            <td><?= $model->FormulaAmount ?></td>
                        </tr>
                        <tr id="parentgroup">
                            <td>FormulaJam</td>
                            <td><?= $model->FormulaJam ?></td>
                        </tr>
                        <tr id="parentgroup">
                            <td>FormulaPoint</td>
                            <td><?= $model->FormulaPoint ?></td>
                        </tr>
                        <tr>
                            <td> IsActive </td>
                            <td> 
                                <?php
                                if ($model->IsActive = 1) {
                                    echo 'Active';
                                } else {
                                    echo 'Deactive';
                                }
                                ?> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::a('Back', ['master-customer/'], ['class' => 'btn btn-success', 'style' => 'width:110px;']);?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

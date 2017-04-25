<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiD */
/* @var $form yii\widgets\ActiveForm */

    
$sql = "select mp.Nama as Name, mc.CustomerName as CusName, ma.Description as AreaDesc,pgh.Status as Stat,*
from PayrollGajiH pgh
left join MasterProduct mp on mp.ProductID = pgh.ProductID
left join MasterCustomer mc on mc.CustomerID = pgh.CustomerID
left join MasterArea ma on ma.AreaID = pgh.AreaID
where pgh.PayrollGajiIDH = '".$_GET['pgidh']."'";

$modelpayrollgaji = \app\payroll\models\PayrollGajiH::findBySql($sql)->one();
    
?>

<div class="payroll-gaji-d-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:150px;">
                                ID Payroll Gaji
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->PayrollGajiIDH?>
                            </td>
                            <td style="width:150px;">
                                Product Name
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->Name?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Customer Name
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->CusName?>
                            </td>
                            <td>
                                Area
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->AreaDesc?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Fix Amount
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->FixAmount?>
                            </td>
                            <td>
                                Tunjangan Amount
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->TunjanganAmount?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Potongan Amount
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->PotonganAmount?>
                            </td>
                            <td>
                                PPH21
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->PPH21?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Total
                            </td>
                            <td>
                                : <?= $modelpayrollgaji->Total?>
                            </td>
                            <td>
                                Status
                            </td>
                            <td>
                                : <?php 

                                if($modelpayrollgaji->Stat == 'P')
                                {
                                    echo 'Paid';
                                } else if ($modelpayrollgaji->Stat == 'C')
                                {
                                    echo 'Cancel';
                                } else {
                                    echo 'New';
                                }

                                        ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>   
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode("List Item") ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_index', ['SD' => $_GET['pgidh'] ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

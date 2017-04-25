<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Billing Detail';

$idInv = Yii::$app->request->get('invno','xxx');
$formatter = \Yii::$app->formatter;

$sql="select inv.InvoiceNo,
            inv.InvoiceDate,
            inv.CustomerID,
            mc.CustomerName,
            inv.NoFakturPajak,
            inv.Status,
            inv.TotalDPP,
            inv.TotalMFee,
            inv.TotalPPN,
            inv.TotalPPH23,
            inv.TotalInvoice,
            inv.CancelReason,
            db.ReceivedBy
        from Invoice inv 
        left join MasterCustomer mc on mc.CustomerID = inv.CustomerID
        left join DocBilling db on db.InvoiceNo = inv.InvoiceNo
        where inv.InvoiceNo='$idInv'
        ";
$modelInv = Yii::$app->db->createCommand($sql)->queryAll();
//echo var_dump($modelInv);
//die();
        
if($modelInv[0]['ReceivedBy'] != NULL) { $new = 'none';
} 
else { $new = 'in-line'; }

if($modelInv[0]['ReceivedBy'] != NULL) { $cancel = 'none' ; }
else { $cancel = 'in-line'; }
?>

<div class="cos-cal-d-form">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <div class="row">
        <?php $form = ActiveForm::begin(['action' => ['billing-d/cancel-billing']]); ?>
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
                            <td>: <?= $modelInv[0]['InvoiceDate'] ?></td>
                        </tr>
                        <tr>
                            <td>CustomerID</td>
                            <td>: <?= $modelInv[0]['CustomerID'] ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td>: <?= $modelInv[0]['CustomerName'] ?></td>
                        </tr>
                        <tr>
                            <td>No Faktur</td>
                            <td>: <?= $modelInv[0]['NoFakturPajak'] ?></td>
                        </tr>        
                        <tr>
                            <td>Total DPP</td>
                            <td>: <?= $formatter->asCurrency($modelInv[0]['TotalDPP'])?></td>
                        </tr>
                        <tr>
                            <td>Total ManagementFee</td>
                            <td>: <?= $formatter->asCurrency($modelInv[0]['TotalMFee'])?></td>
                        </tr>
                        <tr>
                            <td>Total PPN</td>
                            <td>: <?= $formatter->asCurrency($modelInv[0]['TotalPPN'])?> </td>
                        </tr>
                        <tr>
                            <td>Total PPH23</td>
                            <td>: <?= $formatter->asCurrency($modelInv[0]['TotalPPH23'])?> </td>
                        </tr>
                        <tr>
                            <td>Total Invoice</td>
                            <td>: <?= $formatter->asCurrency($modelInv[0]['TotalInvoice'])?> </td>
                        </tr>        
                    <!--    <tr>
                            <td>Status</td>
                            <td>: <?php
                //                    if($modelInv[0]['Status'] == 'C') { echo "Cancel";
                //                    } else if ($modelInv[0]['Status'] == 'P')  { echo 'Paid';
                //                    } else if ($modelInv[0]['Status'] == 'N')  { echo 'New';
                //                    } else { echo '-'; } 
                                    ?></td>
                        </tr> -->

                <?php if($modelInv[0]['ReceivedBy'] == NULL) { ?>  
                        <tr>
                            <td>Cancel No Faktur Pajak</td>
                            <td>: <?= Html::checkbox('CancelFP', false) ?></td>
                        </tr>
                        <tr>
                            <td>Cancel Reason</td>
                            <td> <?= Html::textarea('CancelReason', '', ['class' => 'form-control','style'=> 'width:400px;',"rows"=>2]) ?></td>
                        </tr>
                <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Cancel Billing', ['class' =>'btn btn-success','style' => 'display:'.$new]) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        
    </div>
    
    
    <?= $this->render('_index', ['INV' => $idInv ]) ?>
</div>
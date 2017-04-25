<?php

use yii\helpers\Html;

$idOFH = Yii::$app->request->get('OIDH','xxx');

$sql = 'select oh.OfferingIDH,
            oh.OfferingDate,
            oh.NoSurat,
            oh.IDJobDesc,
            oh.IsApprove,
            oh.SOIDH,
            mj.Description JobDesc,
            oh.Status,
            sh.Status StatusSO,
            oh.CustomerID,
            mc.CustomerName
        from OfferingH oh
        left join MasterJobDesc mj on oh.IDJobDesc=mj.IDJobDesc
        left join SOH sh on sh.SOIDH=oh.SOIDH
        left join MasterCustomer mc on mc.CustomerID = oh.CustomerID
        where oh.OfferingIDH=\''.$idOFH.'\'';
$modelOFH = app\operational\models\OfferingH::findBySql($sql)->one();

$this->title = 'View Offering Detail';

?>

<div class="offering-d-form">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID Offering Header</td>
                            <td>: <label><?= $idOFH ?> </label></td>
                        </tr>
                        <tr>
                            <td>Offering Date </td>
                            <td>: <?= $modelOFH->OfferingDate ?></td>
                        </tr>
                        <tr>
                            <td>Customer ID </td>
                            <td>: <?= $modelOFH->CustomerID ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= $modelOFH->CustomerName ?></td>
                        </tr>
                        <tr>
                            <td>No Surat</td>
                            <td>: <?= $modelOFH->NoSurat ?></td>
                        </tr>
                        <tr>
                            <td>Job Description </td>
                            <td>: <?= $modelOFH->JobDesc ?></td>
                        </tr>
                        <tr>
                            <td>Status Offering</td>
                            <td>: <?php switch ($modelOFH->Status){
                                case 'D' : echo 'Draft';
                                        break;
                                case 'RFA' : echo 'Request For Approval';
                                        break;
                                case 'C' : echo 'Correction';
                                        break;
                                case 'A' : echo 'Approve';
                                        break;
                                default : echo '-';
                            }

                            ?></td>
                        </tr>
                        <tr>
                            <td>ID SO Header</td>
                            <td>: <?= $modelOFH->SOIDH ?></td>
                        </tr>
                        <tr>
                            <td>Status SO</td>
                            <td>: <?php switch ($modelOFH->StatusSO){
                                case 'D' : echo 'Draft';
                                        break;
                                case 'RFA' : echo 'Request For Approval';
                                        break;
                                case 'C' : echo 'Correction';
                                        break;
                                case 'A' : echo 'Approve';
                                        break;
                                default : echo '-';
                            }

                            ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', ['offering-h/index'], ['class' =>'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Cost Calc') ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_indexview', ['ODH' => $idOFH,'status'=>$modelOFH->Status]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
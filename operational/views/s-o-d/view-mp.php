<?php

use yii\helpers\Html;
use app\operational\models\GoLiveProduct;
use app\operational\models\JadwalGolive;
$idSOH = $model->SOIDH;

$modelGoLive = new GoLiveProduct();
$modelJadwal = new JadwalGolive();

$this->title = 'Go Live ManPower';

$sql = "select
    mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,
    oh.IDJobDesc,ma.AreaID,sd.PeriodFrom,sd.PeriodTo,sd.StatusGoLive
    from SOD sd
    left join SOH sh on sh.SOIDH = sd.SOIDH
    left join OfferingD od on od.OfferingDID = sd.OfferingDID
    left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc = oh.IDJobDesc
    left join MasterArea ma on ma.AreaID = od.AreaID
where sd.SODID = '$model->SODID'  and sd.SOIDH = '$model->SOIDH'";

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

$statusGolive = GoLiveProduct::find()->select('Status')->where(['SODID' => $model->SODID])->one();

$countgl = GoLiveProduct::find()
            ->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama')
            ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
            ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()],'mp.ProductID=gl.ProductID ')
            ->where(['SODID' => $model->SODID])->all();
?>

<div class="sod-form">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>  
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID SO Header</td>
                            <td>: <?= $idSOH ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID SO Detail</td>
                            <td>: <?= $model->SODID ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID Offering Detail</td>
                            <td>: <?= $SODOutstanding[0]['OfferingDID'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Job Description</td>
                            <td>: <?= $SODOutstanding[0]['JobDescName'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Area Description</td>
                            <td>: <?= $SODOutstanding[0]['AreaName'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Jumlah</td>
                            <td>: <?= $SODOutstanding[0]['Qty'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Period From</td>
                            <td>: <?= $SODOutstanding[0]['PeriodFrom'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Period To</td>
                            <td>: <?= $SODOutstanding[0]['PeriodTo'] ?> </td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Status Go Live</td>
                            <td>: <?php switch ($SODOutstanding[0]['StatusGoLive']){
                            case 'D' : echo 'Draft';
                                    break;
                            case 'RFA' : echo 'Request For Approval';
                                    break;
                            case 'C' : echo 'Correction';
                                    break;
                            case 'A' : echo 'Approve';
                                    break;
                            default : echo 'xxx';
                        } ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', ['s-o-d/create','soidh' => $idSOH], ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode("List Man Power") ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_indexgolivemp', ['soidh' => $idSOH,'sodid'=>$model->SODID,'statusgolive' => $SODOutstanding[0]['StatusGoLive']]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
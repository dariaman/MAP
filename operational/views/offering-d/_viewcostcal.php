<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

$this->title = 'Costcal';

$sql = 'select oh.OfferingIDH,
            oh.OfferingDate,
            oh.NoSurat,
            oh.IDJobDesc,
            oh.IsApprove,
            oh.SOIDH,
            mj.Description JobDesc,
            oh.Status
        from OfferingH oh
        left join MasterJobDesc mj on oh.IDJobDesc=mj.IDJobDesc
        left join SOH sh on sh.SOIDH=oh.SOIDH
        where oh.OfferingIDH=\'' . $OFIH . '\'';
$modelOFH = app\operational\models\OfferingH::findBySql($sql)->one();
$modelCosCalc = new \app\operational\models\CosCalc();

$sqla = 'select Jumlah = Sum(Amount)
        from CosCalc
        where OfferingDID=\'' . $OFID . '\' and IsManagementFee=1';
$nilaiIsManagementFee = Yii::$app->db->createCommand($sqla)->queryAll();

$mfee = "SELECT Amount FROM dbo.CosCalc
WHERE OfferingDID = '$OFID'
AND BiayaID = 'M1000001'";
$nilaimfee = Yii::$app->db->createCommand($mfee)->queryScalar();

$mfeeot = "SELECT sum(Amount) FROM dbo.CosCalc
WHERE offeringdid = '$OFID'
AND SUBSTRING(BiayaID,1,3) = 'LMB'
AND BiayaID <> 'LMB00005'";
$nilaimfeeot = Yii::$app->db->createCommand($mfeeot)->queryScalar();

$nilaiMfeeOT = "SELECT SUM(Amount) FROM dbo.CosCalc
WHERE offeringdid = '$OFID'
AND SUBSTRING(BiayaID,1,3) = 'LMB'
AND BiayaID = 'LMB00005'";
$valnilaiMfeeOT = Yii::$app->db->createCommand($nilaiMfeeOT)->queryScalar();

$sql1 = 'select Amount from CosCalc where  OfferingDID=\'' . $OFID . '\' and BiayaID=\'UMP00001\'';
$ump = Yii::$app->db->createCommand($sql1)->queryAll();
$umpvalue = $ump[0]['Amount'];

$sqlaa = 'select Jumlah = (Sum(cc.Amount)-' . $umpvalue . ')
        from CosCalc cc
        left join MasterBiaya mb on cc.BiayaID = mb.BiayaID 
        where cc.OfferingDID=\'' . $OFID . '\' and 
		mb.SeqNo <= 600';
$nilaiTHP = Yii::$app->db->createCommand($sqlaa)->queryAll();

$sqlaaa = 'select Jumlah = (Sum(cc.Amount)-' . $umpvalue . ')
        from CosCalc cc
        left join MasterBiaya mb on cc.BiayaID = mb.BiayaID 
        where cc.OfferingDID=\'' . $OFID . '\' and 
		mb.SeqNo <= 1600';
$nilaiDPP = Yii::$app->db->createCommand($sqlaaa)->queryAll();

$sql2 = "select * from OfferingD where OfferingDID = '".$OFID."'";
$valsofd = Yii::$app->db->createCommand($sql2)->queryAll();

$thp = $valsofd[0]['TotalA'];
$dpp = $valsofd[0]['TotalDppHpp'];
$mfeeamt = $valsofd[0]['TotalMfee'];

?>


<div class="offering-d-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID Offering Header</td>
                            <td>: <label><?= $OFIH ?> </label></td>
                        </tr>
                        <tr>
                            <td>Offering Date </td>
                            <td>: <?= $modelOFH->OfferingDate ?></td>
                        </tr>
                        <tr>
                            <td>No Surat</td>
                            <td>: <?= $modelOFH->NoSurat ?></td>
                        </tr>
                        <tr>
                            <td style="width:200px;">ID Offering Detail</td>
                            <td>:<?= $OFID ?></td>
                        </tr>
                        <tr>
                            <td>Job Description </td>
                            <td>: <?= $modelOFH->JobDesc ?></td>
                        </tr>
                        <tr>
                            <td>Area</td>
                            <td>: <?= $area ?></td>
                        </tr>
                        <tr>
                            <td>Class</td>
                            <td>: <?= $class ?></td>
                        </tr>
                        <tr>
                            <td>THP</td>
                            <td>: Rp.<?= $nilaiTHP[0]['Jumlah'] ?></td>
                            <!-- <td>: Rp.<?// $thp ?></td> -->
                        </tr>
                        <tr>
                            <td>DPP (Rp)</td>
                            <td>: Rp.<?= $nilaiDPP[0]['Jumlah'] ?></td>
                        <!--    <td>: Rp.<?//$dpp ?></td> -->
                        </tr>
                        <tr>
                            <td>ManagementFee (Rp)</td>
                            <td>: Rp.<?= (($nilaiIsManagementFee[0]['Jumlah']*$nilaimfee)/100) ?></td>
                        <!--    <td>: Rp.<?//$mfeeamt ?></td>  -->
                        </tr>
                        <tr>
                            <td>ManagementFee OT(Rp)</td>
                            <td>: <?= $valnilaiMfeeOT ?> %</td>
                        </tr>
                   </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Cost Calc') ?></h1>
                </div>
                <div class="box-body">
                    <?php
                    $sql = new \yii\db\Query;
                    $sql->select('mb.Description,mb.BiayaID,cc.Amount,cc.Remark,cc.Time,cc.IsManagementFee,cc.TipeTagihan,cc.Percentage')
                            ->from(['cc' => app\operational\models\CosCalc::tableName()])
                            ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'cc.BiayaID = mb.BiayaID')
                            ->where('cc.OfferingDID=\'' . $OFID . '\'')
                            ->orderBy('mb.SeqNo');

                    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                    $dataProvider->pagination->pageSize = 50;

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}",
                        'pjax' => false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width: 30px;'],
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 200px;'],
                                'label' => 'Biaya Name',
                                'attribute' => 'Description',
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 160px;', 'style' => 'text-align:right'],
                                'headerOptions' => ['style' => 'text-align:center'],
                                'header' => 'Jumlah Amount',
                                'format' => 'raw',
                                'value' => function($data) use ($form, $modelCosCalc) {
                            if ($data['BiayaID'] == 'M1000001'
                                    OR $data['BiayaID'] == 'BPJS0001'
                                    OR $data['BiayaID'] == 'BPJS0002'
                                    OR $data['BiayaID'] == 'BPJS0003'
                                    OR $data['BiayaID'] == 'BPJS0004'
                                    OR $data['BiayaID'] == 'BPJS0005'
                                    OR $data['BiayaID'] == 'M5000001') {
                //                return $data['Amount'];
                                return ($data['Percentage'] == NULL)? 'Rp '.round($data['Amount'],2) : round($data['Percentage'],2).' %';
                            } else if ($data['BiayaID'] == 'LMB00005') {
                                return $data['Amount']. " Jam";
                            } else {
                                return 'Rp ' .round($data['Amount'],2);
                            }
                        }
                            ],
                            [
                                'class' => 'kartik\grid\BooleanColumn',
                                'format' => 'raw',
                                'attribute' => 'IsManagementFee',
                                'vAlign' => 'middle'
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'Time',
                                'attribute' => 'Time',
                            ],
                            [
                                'attribute' => 'TipeTagihan',
                                'format' => 'raw',
                                'value' => function($data) use ($form, $modelCosCalc) {

                                    if ($data['BiayaID'] == 'CMC00001'
                                            OR $data['BiayaID'] == 'SRG00001'
                                            OR $data['BiayaID'] == 'THR00001'
                                            OR $data['BiayaID'] == 'TRN00001'
                                            OR $data['BiayaID'] == '00000014'
                                            OR $data['BiayaID'] == '00000012') {
                                        if ($data['TipeTagihan'] == 'B') {
                                            return 'Bulanan';
                                        } else {
                                            return 'Tahunan';
                                        }
                                    } else {
                                        return '-';
                                    }
                                }
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'Remark',
                                'attribute' => 'Remark',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::a('Back', ['create','OIDH' => $OFIH], ['class' => 'btn btn-success']) ?>
                <?php //Html::a('Print Cost Calc', '', ['class' => 'btn btn-success']) ?>
            </div>    
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
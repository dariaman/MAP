<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

//$idSOH = Yii::$app->request->get('SOIDH', 'xxx');
//$idSOD = Yii::$app->request->get('SODID', 'xxx');
$this->title = 'View SO Costcal';
$sql = 'select sh.SOIDH,
        sh.SODate,
        sh.OfferingIDH,
        oh.IDJobDesc,
        mj.Description JobDesc,
        oh.CustomerID,
        mc.CustomerName,
        sh.PONo,
        sh.POdate,
        sh.TipeKontrak,
        sh.TipeBayar,
        sh.Status
    from SOH sh
    left join OfferingH oh on oh.OfferingIDH=sh.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc=oh.IDJobDesc
    left join MasterCustomer mc on mc.CustomerID=oh.CustomerID
    where sh.SOIDH=\'' . $SOIDH . '\'';
$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

$modelCosCalc = new \app\operational\models\CosCalc();

$ofd = Yii::$app->request->get('ofd');
//$sqla = 'select Jumlah = Sum(Amount)
//        from SOCostCalc
//        where SODID=\'' . $SODID . '\' and IsManagementFee=1';
//$nilaiIsManagementFee = Yii::$app->db->createCommand($sqla)->queryAll();
//
//$sql1 = 'select Amount from SOCostCalc where  SODID=\'' . $SODID . '\' and BiayaID=\'UMP00001\'';
//$ump = Yii::$app->db->createCommand($sql1)->queryAll();
//$umpvalue = $ump[0]['Amount'];
//
//$sqlaa = 'select Jumlah = (Sum(cc.Amount)-' . $umpvalue . ')
//        from SOCostCalc cc
//        left join MasterBiaya mb on cc.BiayaID = mb.BiayaID 
//        where cc.SODID=\'' . $SODID . '\' and 
//		mb.SeqNo <= 600';
//$nilaiTHP = Yii::$app->db->createCommand($sqlaa)->queryAll();
//
//$sqlaaa = 'select Jumlah = (Sum(cc.Amount)-' . $umpvalue . ')
//        from SOCostCalc cc
//        left join MasterBiaya mb on cc.BiayaID = mb.BiayaID 
//        where cc.SODID=\'' . $SODID . '\' and 
//		mb.SeqNo <= 1600';
//$nilaiDPP = Yii::$app->db->createCommand($sqlaaa)->queryAll();


$queryGetDPPTHP = "DECLARE @gp DECIMAL(18,2),
		@bpjs decimal(18,2),
		@thp DECIMAL(18,2),
		@dpp DECIMAL(18,2)
		
		SET @gp = (SELECT Amount AS Gapok FROM dbo.CosCalc WHERE OfferingDID = '$ofd' AND BiayaID = 'GP000001')		

		SET @bpjs =	(SELECT ISNULL(sum(((Amount*@gp)/100)),0) AS Amount
					FROM dbo.CosCalc
					LEFT JOIN dbo.MasterBiaya ON MasterBiaya.BiayaID = CosCalc.BiayaID
					WHERE OfferingDID = '$ofd' 
					AND SeqNo <= 1600 
					AND SUBSTRING(dbo.CosCalc.BiayaID,0,5) = 'BPJS' )

		SET @thp = (SELECT Jumlah = (Sum(cc.Amount)-(select Amount from CosCalc where  OfferingDID='$ofd' and BiayaID='UMP00001'))
					from CosCalc cc
					left join MasterBiaya mb on cc.BiayaID = mb.BiayaID 
					where cc.OfferingDID='$ofd' and 
					mb.SeqNo <= 600)

		SET @dpp = @thp + @bpjs

		SELECT @dpp AS DPP, @thp AS THP";
$nilaiDPPTHP = Yii::$app->db->createCommand($queryGetDPPTHP)->queryAll();
?>


<div class="offering-d-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr><td style="width:200px;">ID SO Header</td><td>: <?= $SODOutstanding[0]['SOIDH'] ?></td></tr>
                        <tr><td>Sales Order Date </td><td>: <?= $SODOutstanding[0]['SODate'] ?></td></tr>
                        <tr><td>CustumerID </td><td>: <?= $SODOutstanding[0]['CustomerID'] ?></td></tr>
                        <tr><td>Customer Name </td><td>: <?= $SODOutstanding[0]['CustomerName'] ?></td></tr>
                        <tr><td>Job Description </td><td>: <?= $SODOutstanding[0]['JobDesc'] ?></td></tr>
                        <tr><td>Tipe Kontrak </td><td>: <?= ($SODOutstanding[0]['TipeKontrak'] == 'LT' ? 'Long Term' : 'Short Term') ?></td></tr>
                        <tr><td>Tipe Bayar </td><td>: <?= ($SODOutstanding[0]['TipeBayar'] == 'ADV' ? 'Advanced' : 'Arrear') ?></td></tr>
                        <tr><td>ID Sales Order Detail</td><td>: <?= $SODID ?></td></tr>
                        <tr><td>Area Name </td><td>: <?= $area ?></td></tr>
                        <tr><td>Class </td><td>: <?= $class ?></td></tr>
                        <tr><td>Period From </td><td>: <?= $PeriodFrom ?></td></tr>
                        <tr><td>Period To </td><td>: <?= $PeriodTo ?></td></tr>
                        <tr>
                            <td>THP</td>
                            <td>: Rp.<?= $nilaiDPPTHP[0]['THP'] ?></td>
                        </tr>
                        <tr>
                            <td>DPP (Rp)</td>
                            <td>: Rp.<?= $nilaiDPPTHP[0]['DPP'] ?></td>
                        </tr>
                    <!--    <tr>
                            <td>ManagementFee (Rp)</td>
                            <td>: Rp.<?php //$nilaiIsManagementFee[0]['Jumlah'] ?></td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List SO Cost Calc Detail') ?></h1>
                </div>
                <div class="box-body">
                    <?php
                        $sql = new \yii\db\Query;
                        $sql->select('mb.Description,mb.BiayaID,cc.Amount,cc.Remark,cc.Time,cc.IsManagementFee,cc.TipeTagihan,')
                                ->from(['cc' => app\operational\models\CosCalc::tableName()])
                                ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'cc.BiayaID = mb.BiayaID')
                                ->where('cc.OfferingDID=\'' . $ofd . '\'')
                                ->orderBy('mb.SeqNo');

                        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                        $dataProvider->pagination->pageSize = 50;

                        echo
                        GridView::widget([
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
                                                return $data['Amount'] . ' %';
                                            } else {
                                                return 'Rp ' . $data['Amount'];
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
            <div class="box-body">
                <?= Html::a('Back', '', ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>
                <?= Html::a('Print Cost Calc', '', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

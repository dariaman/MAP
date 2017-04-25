<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$idSOH = Yii::$app->request->get('soidh', 'xxx');
$this->title = 'Sales Order Detail';
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
    where sh.SOIDH=\'' . $idSOH . '\'';
$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();
?>


<div class="sod-form">
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
                        <tr><td>ID Offering Header</td><td>: <?= $SODOutstanding[0]['OfferingIDH'] ?></td></tr>
                        <tr><td>Job Description </td><td>: <?= $SODOutstanding[0]['JobDesc'] ?></td></tr>
                        <tr><td>CustumerID </td><td>: <?= $SODOutstanding[0]['CustomerID'] ?></td></tr>
                        <tr><td>Customer Name </td><td>: <?= $SODOutstanding[0]['CustomerName'] ?></td></tr>
                        <tr><td>PO Number </td><td>: <?= $SODOutstanding[0]['PONo'] ?></td></tr>
                        <tr><td>PO Date </td><td>: <?= $SODOutstanding[0]['POdate'] ?></td></tr>
                        <tr><td>Tipe Kontrak </td><td>: <?= ($SODOutstanding[0]['TipeKontrak'] == 'LT' ? 'Long Term' : 'Short Term') ?></td></tr>
                        <tr><td>Tipe Bayar </td><td>: <?= ($SODOutstanding[0]['TipeBayar'] == 'ADV' ? 'Advanced' : 'Arrear') ?></td></tr>
                        <tr><td>Status</td><td>: <?php
                                switch ($SODOutstanding[0]['Status']) {
                                    case 'A' : echo 'Approve';
                                        break;
                                    case 'C' : echo 'Correction';
                                        break;
                                    case 'RFA' : echo 'Request For Approval';
                                        break;
                                    case 'D' : echo 'Draft';
                                        break;
                                }
                                ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', ['/operational/s-o-h'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List SO Detail') ?></h1>
                </div>
                <div class="box-body">
                    <?php
                        $sql = new \yii\db\Query;
                        $sql->select('sd.SODID,
                            sd.OfferingDID,
                            ma.Description AreaName,
                            od.Class,
                            sd.Qty,
                            od.OfferingIDH,
                            sd.PeriodFrom,
                            sd.PeriodTo,
                            sd.InstalmentDPP,
                            sd.PeriodUpdateCoscal,
                            sd.Status as StatusSO,
                            sd.StatusCoscal,
                            sd.MFee,
                            sd.MFeeOT, ')
                                ->from(['sd' => app\operational\models\SOD::tableName()])
                                ->leftJoin(['od' => app\operational\models\OfferingD::tableName()], 'od.OfferingDID=sd.OfferingDID')
                                ->leftJoin(['ma' => app\master\models\MasterArea::tableName()], 'ma.AreaID=od.AreaID ')
                                ->where('sd.SOIDH=\'' . $idSOH . '\'')
                                ->orderBy('od.Class');

                        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                        $dataProvider->pagination->pageSize = 50;

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'pjax' => false,
                            'layout' => "{items}",
                            'resizableColumns' => true,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'header' => 'ID SOD',
                                    'attribute' => 'SODID',
                                ],
                                [
                                    'header' => 'ID OfferingD',
                                    'attribute' => 'OfferingDID',
                                ],
                                'Class',
                                'Qty',
                                'AreaName',
                                'PeriodFrom',
                                'PeriodTo',
                                [
                                    'header' => 'Periode Update<br>Cost Calc',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) {
                                if ($data['PeriodUpdateCoscal'] == NULL) {
                                    $date = '-';
                                } else {
                                    $date = date('m Y', strtotime($data['PeriodUpdateCoscal']));
                                }
                                return $date;
                            }
                                ],
                                [
                                    'header' => 'Status SO<br>Detail',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) {
                                if ($data['StatusSO'] == 'D') {
                                    return '<span class="label label-warning">Draft</span>';
                                }else if ($data['StatusSO'] == 'A') {
                                    return '<span class="label label-success">Approved</span>';
                                }else if ($data['StatusSO'] == 'EC') {
                                    return '<span class="label label-default">END CONTRACT</span>';
                                }else if ($data['StatusSO'] == 'ET') {
                                    return '<span class="label label-danger">Early Termination</span>';
                                }else if ($data['StatusSO'] == 'RFA') {
                                    return '<span class="label label-primary">Request for Approval</span>';
                                }else if ($data['StatusSO'] == 'RET') {
                                    return '<span class="label label-warning">Request End Contract</span>';
                                }else if ($data['StatusSO'] == 'NM') {
                                    return '<span class="label label-primary">Normal</span>';
                                } else {
                                    return '-';
                                }
                            }
                                ],
                                [
                                    'header' => 'Status<br>Cost Calc',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) {
                                if ($data['StatusCoscal'] == 'NM') {
                                    return '<span class="label label-primary">Normal</span>';
                                } else if ($data['StatusCoscal'] == 'RFA') {
                                    return '<span class="label label-primary">Request for Approval</span>';
                                } else if ($data['StatusCoscal'] == 'C') {
                                    return '<span class="label label-warning">Correction</span>';
                                } else if ($data['StatusCoscal'] == 'CG') {
                                    return '<span class="label label-danger">Changed</span>';
                                } else if ($data['StatusCoscal'] == 'A') {
                                    return '<span class="label label-success">Approved</span>';
                                } else {
                                    return '-';
                                }
                            }
                                ],
                                [
                                    'label' => 'Hapus',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) use($SODOutstanding) {
                                if ($SODOutstanding[0]['Status'] == 'D' || $SODOutstanding[0]['Status'] == 'C') {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delcon', 'SODID' => $data['SODID'], 'SOIDH' => Yii::$app->request->get('soidh')], ['onclick' => 'return confirm("Apakah data akan dihapus ?")']);
                                } else {
                                    return '-';
                                }
                            },
                                ],
                                [
                                    'header' => 'View<br>Coscal',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) {
                                return Html::a('<span class="glyphicon glyphicon-file"></span>', ['s-o-d/view-coscal',
                                            'SODID' => $data['SODID'],
                                            'soidh' => Yii::$app->request->get('soidh', 'xxx'),
                                            'OFID' => $data['OfferingDID'],
                                            'area' => $data['AreaName'],
                                            'PeriodFrom' => $data['PeriodFrom'],
                                            'PeriodTo' => $data['PeriodTo'],
                                            'class' => $data['Class']]);
                            },
                                ],
                                [
                                    'header' => 'Go Live<br>ManPower',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) use ($idSOH, $SODOutstanding) {
                                if ($SODOutstanding[0]['Status'] == 'A') {
                                    if ($data['StatusSO'] == 'NM' AND $data['StatusCoscal'] == 'NM' or $data['StatusCoscal'] == 'A') {
                                        return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['s-o-d/view-mp', 'did' => $data['SODID'], 'soh' => $idSOH]);
                                    } else {
                                        return '-';
                                    }
                                } else {
                                    return '-';
                                }
                            },
                                ]
                            ],
                        ]);
                        ?>
                </div>
            </div>
        </div>
    </div
</div>
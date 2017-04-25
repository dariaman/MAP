<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$script = <<<SKRIPT
        
$('#btnlookupofferingd').click(function(){
    $('#modalofferingdidlookup').modal('show')
        .find('#modalofferingdidcontent')
        .load($(this).attr('value'));        
});    
SKRIPT;
$this->registerJs($script);


$idSOH = Yii::$app->request->get('soidh', 'xxx');

$this->title = 'SO Detail';
$sql = 'select sh.SOIDH,
        sh.SODate,
        sh.OfferingIDH,
        oh.IDJobDesc,
        mj.Description JobDesc,
        sh.CustomerID,
        mc.CustomerName,
        sh.PONo,
        sh.POdate,
        sh.TipeKontrak,
        sh.TipeBayar,
        sh.Status
    from SOH sh
    left join OfferingH oh on oh.OfferingIDH=sh.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc=oh.IDJobDesc
    left join MasterCustomer mc on mc.CustomerID=sh.CustomerID
    where sh.SOIDH=\'' . $idSOH . '\'';

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();
?>

<h1><center><?= Html::encode($this->title) ?></center></h1>
<div class="sod-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:200px;">ID SO Header</td>
            <td>: <?php echo $idSOH; ?> 
            </td>
        </tr>
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

    <div class="form-group">

        <?= Html::a('Back', ['/operational/s-o-h'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="sod_index">
        <br>
        <?php
        $sql = new \yii\db\Query;
        $sql->select('sd.SODID,
                    sd.OfferingDID,
                    od.CostcalIDH,
                    ma.Description AreaName,
                    od.Class,
                    sd.Qty,
                    mg.Amount GapokAmount,
                    sd.PeriodFrom,
                    sd.PeriodTo,
                    sd.FixAmount,
                    sd.InstalmentDPP,
                    sd.PeriodUpdateCoscal,
                    sd.Status as StatusSO,
                    sd.StatusCoscal,
                    sd.MFee,
                    sd.MFeeOT, ')
                ->from(['sd' => app\operational\models\SOD::tableName()])
                ->leftJoin(['od' => app\operational\models\OfferingD::tableName()], 'od.OfferingDID=sd.OfferingDID')
                ->leftJoin(['mg' => app\master\models\MasterGajiPokok::tableName()], 'mg.GapokID=od.GPID and mg.SeqID=od.GPSeqID')
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
                [
                    'header' => 'ID Costcal',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data['CostcalIDH'], ['cos-cal-d/create', 'CostcalIDH' => $data['CostcalIDH'], 'flag' => 'O']);
                    }
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
                            'header' => 'Gaji<br>Pokok',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'attribute' => 'GapokAmount',
                            'format' => 'Currency',
                            'contentOptions' => ['style' => 'text-align:right'],
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center'],
                            'header' => 'Fix<br>Amount',
                            'attribute' => 'FixAmount',
                            'format' => 'Currency',
                            'contentOptions' => ['style' => 'text-align:right'],
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center'],
                            'header' => 'Tambahan<br>Amount',
                            'attribute' => 'TambahanAmount',
                            'format' => 'Currency',
                            'contentOptions' => ['style' => 'text-align:right'],
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center'],
                            'header' => 'Total<br>Amount',
                            'attribute' => 'TotalAmount',
                            'format' => 'Currency',
                            'contentOptions' => ['style' => 'text-align:right'],
                        ],
                        'MFee',
                        'MFeeOT',
                        [
                            'header' => 'Status SO<br>Detail',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' => 'text-align:center'],
                            'value' => function($data) {
                        if ($data['StatusSO'] == 'NM') {
                            return '<span class="label label-primary">Normal</span>';
                        } else if ($data['StatusSO'] == 'RFA') {
                            return '<span class="label label-primary">Request for Approval</span>';
                        } else if ($data['StatusSO'] == 'C') {
                            return '<span class="label label-warning">Correction</span>';
                        } else if ($data['StatusSO'] == 'CG') {
                            return '<span class="label label-danger">Changed</span>';
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
                            'header' => 'Change<br>Cost Calc',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                            'contentOptions' => ['style' => 'text-align:center'],
                            'value' => function($data) use ($idSOH, $SODOutstanding) {
                        if ($SODOutstanding[0]['Status'] == 'A') {
                            if ($data['StatusCoscal'] == 'A' OR $data['StatusCoscal'] == 'NM') {
                                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['s-o-d/insert-delete', 'id' => $data['SODID'], 'idsoh' => $idSOH]);
                            } else if ($data['StatusCoscal'] == 'RFA') {
                                return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['s-o-d/viewreq', 'id' => $data['SODID'], 'idsoh' => $idSOH]);
                            } else {
                                return '-';
                            }
                        } else {
                            return '-';
                        }
                    },
                        ],
                        [
                            'header' => 'Action <br>Detail',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                            'contentOptions' => ['style' => 'text-align:center'],
                            'value' => function($data) use ($idSOH, $SODOutstanding) {
                        if ($SODOutstanding[0]['Status'] == 'A') {
                            if ($data['StatusSO'] == 'NM' AND $data['StatusCoscal'] == 'NM' or $data['StatusCoscal'] == 'A') {
                                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['s-o-d/detailsod', 'did' => $data['SODID'], 'soh' => $idSOH]);
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
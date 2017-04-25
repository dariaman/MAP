<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\grid\GridView;


$idSOH = Yii::$app->request->get('soidh', 'xxx');

$this->title = 'Tambah SO Detail';
$sql = 'select sh.SOIDH,
        sod.SODID,
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
        sh.Status,
        sh.note
    from SOH sh
    left join OfferingH oh on oh.OfferingIDH=sh.OfferingIDH
    left join MasterJobDesc mj on mj.IDJobDesc=oh.IDJobDesc
    LEFT JOIN dbo.SOD sod ON sod.SOIDH = sh.SOIDH
    left join MasterCustomer mc on mc.CustomerID=oh.CustomerID
    where sh.SOIDH=\'' . $idSOH . '\'';

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

$this->title = 'Sales Order';
$script = <<<SKRIPT
                
  $('#buttongofferingd').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600");
    });
 
SKRIPT;
$this->registerJs($script);
?>


<div class="sod-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">ID SO Header</td>
                            <td>: <label><?= $SODOutstanding[0]['SOIDH'] ?> </label></td>
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
                                    case 'EC' : echo 'END CONTRACT';
                                        break;
                                    case 'REC' : echo 'Request End Contract';
                                        break;
                                    case 'D' : echo 'Draft';
                                        break;
                                }
                                ?></td>
                        </tr>
                        <tr>
                                <td>Note</td>
                                <td>: <?= $SODOutstanding[0]['note'] ?>
                                </td>
                        </tr>
                        <?php if ($SODOutstanding[0]['Status'] == 'D' || $SODOutstanding[0]['Status'] == 'C') {?>
                            <tr> 
                                <td> Offering Detail</td>
                                <td>: <?= $form->field($model, 'OfferingDID')->textInput(['readonly' => true, 'style' => "width:260px", 'name' => 'off-id']) ?> 
                                    <?= Html::a('', ['/lookup/lookup-offering-d', 'offeringH' => $SODOutstanding[0]['OfferingIDH'], 'soh' => $idSOH], ['class' => 'glyphicon glyphicon-search', 'id' => 'buttongofferingd']) ?>
                                </td> 
                            </tr>  
                            <tr>
                                <td>Area Name</td>
                                <td>: <?= $form->field($model, 'areaname')->textInput(['readonly' => true, 'style' => "width:260px", 'name' => 'off-areaname']) ?> </td>
                            </tr>
                            <tr>
                                <td>Class</td>
                                <td>: <?= $form->field($model, 'class')->textInput(['readonly' => true, 'style' => "width:260px", 'name' => 'off-class']) ?> </td>
                            </tr>
                            <tr><td>Qty </td><td>: <?= $form->field($model, 'Qty')->textInput() ?></td></tr>
                            <tr><td>Period From </td><td>: <?=
                                    $form->field($model, 'PeriodFrom')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Enter Date ...'],
                                        'pluginOptions' => ['autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true]
                                    ]);
                                    ?></td></tr>
                            <tr><td>Period To </td><td>: <?=
                                    $form->field($model, 'PeriodTo')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Enter Date ...'],
                                        'pluginOptions' => ['autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true]
                                    ]);
                                    ?></td></tr>
                        </table> <?php } else { echo '</table>'; }?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php if ($SODOutstanding[0]['Status'] == 'D' || $SODOutstanding[0]['Status'] == 'C') { ?>
                <div class="form-group">
                                <?= Html::a('Request For Approval', ['/operational/s-o-h/rfa', 'soid' => $idSOH], ['class' => 'btn btn-success']) ?>
                                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php } else if ($SODOutstanding[0]['Status'] == 'RFA') { ?>
                <div class="form-group">
                    <?= Html::a('Cancel RFA', ['/operational/s-o-h/cancel-rfa', 'soid' => $idSOH], ['class' => 'btn btn-success']) ?>
                </div>
                <?php } else { ?> 
                <div class="form-group">
                    <?= Html::a('Back', ['/operational/s-o-h'], ['class' => 'btn btn-success']) ?>
                </div>
                <?php } ?>
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
                                        sd.StatusGoLive,
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
                                [
                                    'header' => 'View<br>Coscal',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) use ($SODOutstanding) {
                                    return Html::a('<span class="glyphicon glyphicon-file"></span>', ['offering-d/view-coscal',
                                    'OFIH' => $SODOutstanding[0]['OfferingIDH'],
                                    'OFID' => $data['OfferingDID'],
                                    'area' => $data['AreaName'],
                                    'class' => $data['Class']
                                                ]);
                                    },
                                ],
                                [
                                    'label' => 'Class',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if($data['Class'] == 'A')
                                        {
                                           return "<span class='label label-danger'>A</span>"; 
                                        } else if($data['Class'] == 'B') 
                                        {
                                           return "<span class='label label-primary'>B</span>";  
                                        } else {
                                            return '';
                                        }
                                    }
                                ],
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
                                    return '-';
                                } else {
                                    $year = substr($data['PeriodUpdateCoscal'],0,4);
                                    $month = substr($data['PeriodUpdateCoscal'],4,6);
                                    return $month." ".$year;
                                }
                                
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
                                }else if ($data['StatusSO'] == 'REC') {
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
                                } else if ($data['StatusCoscal'] == 'REC') {
                                    return '<span class="label label-warning">Request End Contract</span>';
                                } else if ($data['StatusCoscal'] == 'EC') {
                                    return '<span class="label label-default">END CONTRACT</span>';
                                } else if ($data['StatusCoscal'] == 'C') {
                                    return '<span class="label label-warning">Correction</span>';
                                } else if ($data['StatusCoscal'] == 'CG') {
                                    return '<span class="label label-warning">Changed</span>';
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
                                    if ($data['StatusSO'] == 'D') {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delcon', 'SODID' => $data['SODID'], 'SOIDH' => Yii::$app->request->get('soidh'),'OFD' => $data['OfferingDID']], ['onclick' => 'return confirm("Apakah data akan dihapus ?")']);
                                    }
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
                                    if ($SODOutstanding[0]['Status'] == 'A' or $SODOutstanding[0]['Status'] == 'REC' or $SODOutstanding[0]['Status'] == 'EC') {
                                            if ($data['StatusCoscal'] == 'A' && $data['StatusGoLive'] == 'A' ) {
                                                 return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['offering-d/create', 'OIDH' => $SODOutstanding[0]['OfferingIDH'],'IsSO'=>1,'SODID' => $data['SODID'],'SOIDH' => $idSOH,'ofd' => $data['OfferingDID']]);
                                            } else if ($data['StatusCoscal'] == 'RFA') {
                                                return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['offering-d/view-coscal', 'id' => $data['SODID'], 'idsoh' => $idSOH]);
                                            }else if ($data['StatusCoscal'] == 'EC' or $data['StatusCoscal'] == 'REC') {
                                                return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['offering-d/view-coscal',
                                                'OFIH' => $SODOutstanding[0]['OfferingIDH'],
                                                'OFID' => $data['OfferingDID'],
                                                'area' => $data['AreaName'],
                                                'class' => $data['Class']
                                                ]);
                                            } else  {
                                                return '-';
                                            }
                                        } else {
                                            return '-';
                                        }
                                    },
                                ],
                                [
                                    'header' => 'Go Live<br>Product',
                                    'format' => 'raw',
                                    'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                                    'contentOptions' => ['style' => 'text-align:center'],
                                    'value' => function($data) use ($idSOH, $SODOutstanding) {
                                    if ($SODOutstanding[0]['Status'] == 'A' or $SODOutstanding[0]['Status'] == 'REC' or $SODOutstanding[0]['Status'] == 'EC') {
                                            if($data['StatusSO'] == 'EC' or $data['StatusCoscal'] == 'REC'){
                                                return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['s-o-d/detailsod', 'did' => $data['SODID'], 'soh' => $idSOH]);
                                            }
                                            if ($data['StatusSO'] == 'NM' AND $data['StatusCoscal'] == 'NM') {
                                                return '-';
                                            } else {
                                                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['s-o-d/detailsod', 'did' => $data['SODID'], 'soh' => $idSOH]);
                                            }
                                        } else {
                                            return '-';
                                        }
                                    },
                                ]
//                                [
//                                    'header' => 'End<br>Contract',
//                                    'format' => 'raw',
//                                    'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
//                                    'contentOptions' => ['style' => 'text-align:center'],
//                                    'value' => function($data) use($SODOutstanding,$idSOH){
//                                    if ($SODOutstanding[0]['Status'] == 'A') {
//                                        if ($data['StatusSO'] == 'RET' or $data['StatusSO'] == 'EC'){
//                                            return '-';
//                                        }
//                                        if ($data['StatusSO'] ==  'A') {
//                                            return Html::a('<span class="glyphicon glyphicon-send"></span>',['s-o-d/request-end-contract-sod', 'sodid' => $data['SODID'],'soidh'=> $idSOH],
//                                                    ['data-confirm' => 'Are you sure you want to End Contract ?','title' => 'End Contract']);
//                                        }else {
//                                            return '-';
//                                        }
//                                        } 
//                                    }
//                                ]
                            ],
                        ]);
                        ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

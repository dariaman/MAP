<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'SO Header';
?>
<div class="soh-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]) ?>
                <div class="box-body">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'SOIDH',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Html::a($data['SOIDH'], ['s-o-d/view-detail-so', 'soidh' => $data['SOIDH']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'SO Detail']);
                                    }
                            ],
                            'SODate',
                            [
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'OfferingIDH',
                                'format' => 'raw',
                                'value' => function($data) {
                                        return Html::a($data['OfferingIDH'], ['offering-d/viewofdet',
                                                    'OIDH' => $data['OfferingIDH']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Check Offering Detail']);
                                        }
                            ],
                            [
                                'label' => 'Job Description',
                                'value' => 'Description'
                            ],
                            [
                                'label' => 'Customer Id',
                                'value' => 'CustomerID'
                            ],
                            'CustomerName',
                            [
                                'label' => 'PO Number',
                                'value' => 'PONo'
                            ],
                            'POdate',
                            [
                              'header' => 'Tipe<br>Kontrak',
                              'format' => 'raw',
                              'value' => function($data)
                                {
                                    if($data['TipeKontrak'] == 'LT')
                                    {
                                        return '<span class="label label-primary">LT</span>';
                                    } else {
                                        return '<span class="label label-danger">ST</span>';
                                    }
                                }
                            ],
                            [
                                'header' => 'Sub Customer ID',
                                'value' => 'SubCustomerID'
                            ],
                            [
                              'header' => 'Tipe<br>Bayar',
                              'format' => 'raw',
                              'value' => function($data)
                                {
                                       if($data['TipeBayar'] == 'ADV')
                                       {
                                           return '<span class="label label-primary">Advance</span>';
                                       } else if ($data['TipeBayar'] == 'ARR')
                                       {
                                           return '<span class="label label-danger">Arrear</span>';
                                       } else {
                                           return $data['TipeBayar'];
                                       }
                                }
                            ],
                            [
                                'header' => 'Status',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    if($data['Status'] == 'A')
                                    {
                                        return '<span class="label label-success">Approved</span>';
                                    } 
                                        else if ($data['Status'] == 'D')
                                    {
                                        return '<span class="label label-warning">Draft</span>';
                                    } 
                                        else if ($data['Status'] == 'RFA')
                                    {
                                        return '<span class="label label-primary">Pending</span>';
                                    }
                                        else if ($data['Status'] == 'EC')
                                    {
                                        return '<span class="label label-default">END CONTRACT</span>';
                                    }
                                        else if ($data['Status'] == 'REC')
                                    {
                                        return '<span class="label label-warning">REQUEST END CONTRACT</span>';
                                    }
                                        else if ($data['Status'] == 'C')
                                    {
                                        return '<span class="label label-warning">Correction</span>';
                                    }else {
                                        return $data['Status'];
                                    }
                                }
                            ],
                            [
                                'header' => 'Delete',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'value' => function($data) {
                                    if($data['Status'] != 'D')
                                    {
                                        return '-';
                                    } else {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['s-o-h/delete-soh', 'SOH' => $data['SOIDH'],'OFH' => $data['OfferingIDH']],['data-confirm' => 'Are you sure you want to delete this SO ?']);
                                    }
                                },
                            ],
                            [
                                'header' => 'Detail',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'value' => function($data) {
                            return Html::a('<span class="glyphicon glyphicon-file"></span>', ['s-o-d/create', 'soidh' => $data['SOIDH']]);
                        },
                        ]
//                            ,
//                            [
//                            'header' => 'End<br>Contract',
//                            'format' => 'raw',
//                            'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
//                            'contentOptions' => ['style' => 'text-align:center'],
//                            'value' => function($data){
//                            if($data['Status'] == 'A')
//                                    {
//                                        return Html::a('<span class="glyphicon glyphicon-send"></span>',['s-o-h/request-end-contract-soh','soidh'=> $data['SOIDH']],
//                                ['data-confirm' => 'Are you sure you want to End Contract SOH?','title' => 'End Contract']);
//                                    } else {
//                                        return '-';
//                                    }
//                                
//                            }
//                        ]
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('ADD', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>

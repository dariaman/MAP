<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$script = <<<SKRIPT
        
    $('.aaa').click(function(a){
        alert('Product Harus status Terminated');
        return false;
    });
        
    $(".buttongs").click(function(e)
        {
            e.preventDefault();
            var url=$(this).attr('href');
            window.open(url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=50, left=350, width=1020, height=700");
    });
    
        
     $(function() {
       $('.popupModal').click(function(e) {
         e.preventDefault();
         $('#modal').modal('show').find('.modal-content')
         .load($(this).attr('href'));
       });
    });
        
SKRIPT;
$this->registerJs($script);

?>
<div class="sod_index">
    <br>
    <?php
    yii\bootstrap\Modal::begin(['id' =>'modal']);
    yii\bootstrap\Modal::end();
    $sql = new \yii\db\Query;
    $sql->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama,mp.ProductID,gl.PeriodFrom,gl.PeriodTo')
            ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
            ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID=gl.ProductID ')
            ->leftJoin('SOD sd', 'sd.SODID = gl.SODID')
            ->where(['gl.SODID' => $sodid,'gl.IsActive' => 1]);
    

    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
    $dataProvider->pagination->pageSize = $qty;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
//        'pjax' => false,
        'layout' => "{items}",
        'resizableColumns' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'GoLiveID',
//            'SeqProduct',
            'ProductID',
            [
                'header' => 'Sequence<br>Product',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'format' => 'raw',
                'value' => function($data) use ($sodid) 
                {
                    return Html::a($data['SeqProduct'], 
                            ['/lookup/lookuppseq','seqid' => $data['SeqProduct'],'sodid' => $sodid],
                            [ 'class'=>'popupModal']);
                }
            ],
            'Nama',
            'AreaDetailDesc',
            'LicensePlate',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'IsShift',
                'vAlign' => 'middle'
            ],
            [
                'header' => 'Period From',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data){
                    if($data['ProductID'] ==  NULL)
                    {
                        return '';
                    } else {
                        return $data['PeriodFrom'];
                    }
                    
                }
            ],
            [
                'header' => 'Period To',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data){
                    if($data['ProductID'] ==  NULL)
                    {
                        return '';
                    } else {
                        return $data['PeriodTo'];
                    }
                    
                }
            ],
            [
                'header' => 'Status',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
                    if ($data['Status'] == 'RFA') {
                        return '<span class="label label-primary">Request for Approval</span>';
                    } else if ($data['Status'] == 'D') {
                        return '<span class="label label-warning">Draft</span>';
                    } else if ($data['Status'] == 'A') {
                        return '<span class="label label-success">Approved</span>';
                    } else if ($data['Status'] == 'EC') {
                        return '<span class="label label-default">END CONTRACT</span>';
                    } else if ($data['Status'] == 'REC') {
                        return '<span class="label label-warning">Request End Contract</span>';
                    } else if ($data['Status'] == 'ET') {
                        return '<span class="label label-danger">Terminated</span>';
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'header' => 'Change',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($sodid, $soidh, $statusgolive) {
            if ($statusgolive == 'A') {
                if ($data['Status'] == 'ET' OR $data['Status'] == 'REC' OR $data['Status'] == 'D' OR $data['Status'] == 'EC' or $data['Status'] == 'C' OR $data['Status'] == 'RFA' or $data['ProductID'] == NULL) {
                    return '-';
                } else {
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', ['s-o-d/change-product', 'id' => $data['GoLiveID']]);
//                    return Html::a('<span class="glyphicon glyphicon-user"></span>', ['s-o-d/change-product', 'id' => $data['GoLiveID'], 'sodid' => $sodid, 'seqid' => $data['SeqProduct'], 'soidh' => $soidh]);
                }
            } else {
                return '-';
            }
        },
            ],
            [
                'header' => 'ET',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($sodid, $soidh, $statusgolive) {
            if ($statusgolive == 'A') {
                    $statusprod = \app\operational\models\GoLiveProduct::find()->select('Status')->where(['SODID' => $sodid,'SeqProduct' => $data['SeqProduct'], 'ProductID' => $data['ProductID']])->one();
                    if ($data['Status'] == '0') {
                        return '-';
                    } else {
                        if ($statusprod['Status'] == 'ET' OR $statusprod['Status'] == 'RFA' OR $data['Status'] == 'REC' OR $data['Status'] == 'EC' OR $data['ProductID'] == NULL) {
                            return '-';
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['s-o-d/request-et', 'id' => $data['GoLiveID'], 'sohid' => $soidh, 'seqid' => $data['SeqProduct'], 'sodid' => $sodid], ['title' => 'Early Termination']);
                        }
                    }
            } else {
                return '-';
            }
        },
            ],
            [
                'header' => 'Add<br>Manpower',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($sodid, $statusgolive) {
           
            if ($statusgolive == 'A') {
                $statusprod = \app\operational\models\GoLiveProduct::find()->select('Status')->where(['SODID' => $sodid,'SeqProduct' => $data['SeqProduct'], 'ProductID' => $data['ProductID']])->one();
                if ($data['Status'] == 'D') {
                    return '-';
                } else {
                    if ($statusprod['Status'] == 'ET') {
                        return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['s-o-d/add-producttt',
                                    'seqid' => $data['SeqProduct'],
                                    'sodid' => $sodid], ['title' => 'Add Manpower']);
                    } else if ($statusprod['Status'] == 'RFA') {
                        return '-';
                    } else if ($data['ProductID'] == NULL) {
                        return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['s-o-d/add-producttt',
                                    'seqid' => $data['SeqProduct'],
                                    'sodid' => $sodid], ['title' => 'Add Manpower']);
                    } else {
                        return '-';
                    }
                }
            } else {
                return '-';
            }
        },
            ],
            [
                'header' => 'Delete Slot',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($statusgolive,$soidh,$sodid) {
                
                    if ($statusgolive == 'A' ) {
                        if($data['ProductID'] == NULL )
                        {
                            
                            if($data['Status'] == 'RFA' )
                            {
                                return '-';
                            } else {
                                return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', ['s-o-d/del-slot',
                                            'seqid' => $data['SeqProduct'],
                                            'sodid' => $sodid,
                                            'soidh' => $soidh],
                                            ['data-confirm' => 'Are you sure you want to delete this slot ?','title' => 'Delete Slot']
                                            );
                            }
                            
                        } else {
                            if($data['Status'] == 'RFA' OR $data['Status'] == 'REC' OR $data['Status'] == 'EC')
                            {
                                return '-';
                            } else if($data['Status'] == 'ET') {
                                
                                return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', ['s-o-d/del-slot',
                                            'seqid' => $data['SeqProduct'],
                                            'sodid' => $sodid,
                                            'soidh' => $soidh],
                                            ['data-confirm' => 'Are you sure you want to delete this slot ?','title' => 'Delete Slot']
                                            );
                            } else { 
                                                                
                                return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', ['#'],
                                            ['title' => 'Delete Slot','class' => 'aaa']);
                            }
                        }
                    } else {
                        return '-';
                    }
                }
            ]
        ],
    ]);
    ?>
</div>

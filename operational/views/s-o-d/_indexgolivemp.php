<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<div class="sod_index">
    <br>
    <?php
    $sql = new \yii\db\Query;
    $sql->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama,mp.ProductID')
            ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
            ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID=gl.ProductID ')
            ->where(['SODID' => $sodid]);

    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
    $dataProvider->pagination->pageSize = 50;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => false,
        'layout' => "{items}",
        'resizableColumns' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ProductID',
            'Nama',
            'AreaDetailDesc',
            'LicensePlate',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'IsShift',
                'vAlign' => 'middle'
            ],
            [
                'header' => 'Status',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
            if ($data['Status'] == 'RFA') {
                return 'Request for Approval';
            } else if ($data['Status'] == 'D') {
                return 'Draft';
            } else if ($data['Status'] == 'A') {
                return 'Approve';
            } else if ($data['Status'] == 'ET') {
                return 'Terminated';
            } else {
                return '-';
            }
        }
            ],
            [
                'header' => 'View Jadwal',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center', 'width:50px;'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($sodid, $soidh, $statusgolive) {
            if ($statusgolive == 'A') {
                if ($data['Status'] == 'ET' OR $data['Status'] == 'D' OR $data['Status'] == 'C' OR $data['Status'] == 'RFA' or $data['ProductID'] == NULL) {
                    return '-';
                } else {
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', 
                        ['s-o-d/view-jadwal', 
                            'SODID' => $sodid, 
                            'SeqProduct' => $data['SeqProduct']]);
                }
            } else {
                return '-';
            }
        },
            ],
        ],
    ]);
    ?>
</div>

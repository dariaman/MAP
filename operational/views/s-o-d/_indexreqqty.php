<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$script = <<<SKRIPT
        
$('.aaa').click(function(a){
    alert('You must terminate the product first');
    return false;
});
        
SKRIPT;
$this->registerJs($script);

?>
<div class="sod_index">
    <br>
    <?php
    $sql = new \yii\db\Query;
    $sql->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama,mp.ProductID')
            ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
            ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID=gl.ProductID ')
            ->where(['SODID' => $sodid,'SeqProduct' => $seqid]);
    
    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
//    $dataProvider->pagination->pageSize = $qty;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => false,
        'layout' => "{items}",
        'resizableColumns' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'GoLiveID',
//            'SeqProduct',
            'ProductID',
            'Nama',
            'AreaDetailDesc',
//            'LicensePlate',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'IsShift',
                'vAlign' => 'middle'
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
                    } else if ($data['Status'] == 'ET') {
                        return '<span class="label label-danger">Terminated</span>';
                    } else {
                        return '-';
                    }
                }
            ]
        ],
    ]);
    ?>
</div>

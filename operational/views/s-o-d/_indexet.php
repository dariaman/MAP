<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;

?>
<div class="sod_index">
    <br>
    <?php 
    $sql = new \yii\db\Query;
        $sql->select('GoLiveID,SeqProduct,gl.ProductID,AreaDetailDesc,LicensePlate,IsShift,gl.Status,mp.Nama')
            ->from(['gl' => app\operational\models\GoLiveProduct::tableName()])
            ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()],'mp.ProductID=gl.ProductID ')
            ->where(['GoLiveID' => $goliveid]);
        
        $dataProvider = new \yii\data\ActiveDataProvider (['query' => $sql ]);
        $dataProvider->pagination->pageSize=50;
        
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>false,
        'layout'=>"{items}",
        'resizableColumns'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'GoLiveID',
            'SeqProduct',
            'Nama',
            'AreaDetailDesc',
            'LicensePlate',
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'IsShift', 
                'vAlign'=>'middle'
            ],
            [
                'header' => 'Status',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data)
                {
                    if($data['Status'] == 'RFA')
                    {
                        return 'Request for Approval';
                    } else if ($data['Status'] == 'D')
                    {
                        return 'Draft';
                    } else if($data['Status'] == 'A') {
                        return 'Approve';
                    } else {
                        return '-';
                    }
                }
            ],
        ],
    ]); 
    ?>
</div>

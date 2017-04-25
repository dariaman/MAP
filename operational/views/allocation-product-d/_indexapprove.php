<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\AllocationProductDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Product';
?>
<div class="allocation-product-d-index">

    <?php 
    $sql = new \yii\db\Query;
        $sql->select('*, '
                . 'mc.CustomerName as CusName,'
                .'sh.TipeKontrak as TipeKontrak,'
                .'sh.TipeBayar as TipeBayar,'
                .'aph.Status as StatusAPH,'
                .'sh.PONo asPONo,'
                .'sh.PODate as PODate,'
                . 'sh.Status as StatusSO')
            ->from(['aph' => app\operational\models\AllocationProductH::tableName()])
            ->leftJoin(['sh' => app\operational\models\SOH::tableName()],'sh.SOIDH=aph.SOIDH')
            ->leftJoin(['mc' => app\master\models\MasterCustomer::tableName()],
                        'mc.CustomerID=sh.CustomerID')
//            ->leftJoin(['ma' => app\master\models\MasterArea::tableName()],'ma.AreaID=od.AreaID ')
            ->where(['aph.AllocationProductIDH' => $SD])
            ->orderBy('aph.AllocationProductIDH');
        
        $dataProvider = new \yii\data\ActiveDataProvider (['query' => $sql ]);
        $dataProvider->pagination->pageSize=50;
        
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>false,
        'layout'=>"{items}",
        'resizableColumns'=>true,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
            'AllocationProductIDH',
            'PONo',
            'SOIDH',
            'CusName',
            'Description',
            'PicCustomer',
            'TanggalSurat',
            'TipeKontrak',
            'TipeBayar',
            'PODate',
            [
                'header' => 'Status SO',
                'value' => function($data)
                {
                    if($data['StatusSO'] == 'A')
                    {
                        return 'Approve';
                    } else if ($data['StatusSO'] == 'RFA')
                    {
                        return 'Request for Approval';
                    } else if ($data['StatusSO'] == 'D')
                    {
                        return 'Draft';
                    }
                }
            ]
        ],
    ]); 
    ?>

</div>

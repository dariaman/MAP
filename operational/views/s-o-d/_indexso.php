<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;

if(substr($SD, 0,3) == 'SOH') {
    $where = 'sd.SOIDH=\''.$SD.'\'' ;
} else {
    $where = 'sd.SODID=\''.$SD.'\'' ;
}
?>
<div class="sod_index">
    <br>
    <?php 
    $sql = new \yii\db\Query;
        $sql->select('
                sd.SODID,
                sh.SOIDH,
                sd.OfferingDID,
                ma.Description AreaName,
                od.Class,
                sd.Qty,
                sd.PeriodFrom,
                sd.PeriodTo,
                sh.Status,
                sd.InstalmentDPP,
                sd.PeriodUpdateCoscal,
                sd.Status as StatusSO,
                sd.StatusCoscal')
            ->from(['sd' => app\operational\models\SOD::tableName()])
            ->innerJoin(['sh' => app\operational\models\SOH::tableName()],'sh.SOIDH=sd.SOIDH')
            ->leftJoin(['od' => app\operational\models\OfferingD::tableName()],'od.OfferingDID=sd.OfferingDID')
            ->leftJoin(['ma' => app\master\models\MasterArea::tableName()],'ma.AreaID=od.AreaID ')
            ->where($where)
            ->orderBy('od.Class');
        
        $dataProvider = new \yii\data\ActiveDataProvider (['query' => $sql ]);
        $dataProvider->pagination->pageSize=50;
        
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>false,
        'layout'=>"{items}",
        'resizableColumns'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'SODID',
            'OfferingDID',
            'Class',
            'Qty',
            'AreaName',
            'PeriodFrom',
            'PeriodTo',
        ],
    ]); 
    ?>
</div>

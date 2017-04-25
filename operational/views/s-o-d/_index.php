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
            [
                'header' => 'Periode Update<br>Cost Calc',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data)
                {
                    if($data['PeriodUpdateCoscal'] == NULL){
                        return '-';
                    } else {
                        $year = substr($data['PeriodUpdateCoscal'],0,4);
                        $month = substr($data['PeriodUpdateCoscal'],4,6);
                        return $month." ".$year;
                    }                    
                    
                }
            ],
            [
                'header' => 'Status',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data)
                {
                   if($data['StatusSO'] == 'NM') {
                       return 'Normal';
                   } else if ($data['StatusSO'] == 'RFA') {
                       return 'Request for Approval';
                   } else if($data['StatusSO'] == 'C') {
                       return 'Correction';
                   } else if ($data['StatusSO'] == 'CG') {
                       return 'Changed';
                   } else {
                       return '-';
                   }
                }
            ],
            [
                'header' => 'Status Cost Calc',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data)
                {
                   if($data['StatusCoscal'] == 'NM') {
                       return 'Normal';
                   } else if ($data['StatusCoscal'] == 'RFA') {
                       return 'Request for Approval';
                   } else if($data['StatusCoscal'] == 'C') {
                       return 'Correction';
                   } else if ($data['StatusCoscal'] == 'CG') {
                       return 'Changed';
                   } else {
                       return '-';
                   }
                }
            ],
            [
                'label'=>'Hapus',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data){
                    if($data['Status'] == 'D' || $data['Status'] == 'C')
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['delcon','SODID' => $data['SODID'],'SOIDH' => $data['SOIDH'] ],
                            ['onclick'=>'return confirm("Apakah data akan dihapus ?")'
                                ]);
                    } else {
                        return '-';
                    }
                },
            ],
            [
                'header'=>'Change<br>Cost Calc',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center','width:50px;'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data){
                   if ($data['StatusSO'] != 'A') {
                            if($data['StatusCoscal'] == 'RFA') {
                                return '-';
                            } else {
                               return Html::a('<span class="glyphicon glyphicon-list-alt"></span>',
                                ['s-o-d/change-so','id' => $data['SODID'],'idsoh' => $data['SOIDH']]); 
                            }
                        }else {
                     return '-';
                 }
                },
            ]
        ],
    ]); 
    ?>
</div>

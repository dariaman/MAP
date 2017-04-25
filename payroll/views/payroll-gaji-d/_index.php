<?php

use yii\helpers\Html;

?>
<div class="cos-cal-d-index">
    <br>
    <?php 
    $sql = new \yii\db\Query;
        $sql->select('mb.Description as BiayaName,mb.TipeBiaya as Tipe,*')
            ->from(['pgd' => app\payroll\models\PayrollGajiD::tableName()])
            ->leftJoin(['mb' => app\master\models\MasterBiaya::tableName()],'mb.BiayaID = pgd.ItemID')
            ->where(['pgd.PayrollGajiIDH' => $SD])
            ->orderBy('mb.TipeBiaya')
            ->all();
        
        $dataProvider = new \yii\data\ActiveDataProvider (['query' => $sql ]);
        $dataProvider->pagination->pageSize=50;
        
    echo yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => 'Item Name',
                'value' => 'BiayaName'
            ],
            [
                'header' => 'Amount',
                'value' => 'Amount'
            ]
        ],
    ]); 
    ?>
</div>

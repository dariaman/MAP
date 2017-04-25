<div class="billing-d-index">
    <br>
    <?php 
    $sql = new \yii\db\Query;
        $sql->select('ma.Description as AreaName,bd.TipeBilling as TipeBilling,bd.BillingNo,inv.InvoiceNo,bd.SODID,gl.ProductID,bd.Periode,bd.DPP,bd.MgmFee,bd.PPN,bd.PPH23,bd.Total')
            ->from(['bd' => app\finance\models\BillingD::tableName()])                
            ->leftJoin(['ma' => app\master\models\MasterArea::tableName()],'ma.AreaID=bd.AreaID')
            ->leftJoin(['bh' => app\finance\models\BillingH::tableName()],'bh.BillingIDH=bd.BillingIDH')
            ->leftJoin(['inv' => app\finance\models\Invoice::tableName()],'inv.InvoiceNo = bh.InvoiceNo')
            ->leftJoin(['gl' => app\operational\models\GoLiveProduct::tableName()],'gl.SODID = bd.SODID and gl.SeqProduct = bd.SeqProduct')
            ->where('bh.InvoiceNo=\''.$INV.'\'' )
            ->orderBy('bd.BillingNo');
        
        $dataProvider = new \yii\data\ActiveDataProvider ([
            'query' => $sql
        ]);
        $dataProvider->pagination->pageSize=10; 
    echo kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}",
        'pjax'=>false,
        'columns' => [
            'BillingNo',
            'InvoiceNo',
            'TipeBilling',
            'AreaName',
            [
                'label' => 'SO Detail',
                'attribute' => 'SODID'
            ],
            'ProductID',
            'Periode',
            [
                'label' => 'DPP',
                'attribute' => 'DPP',
                'format' => 'Currency',
                'contentOptions'=>['style'=>'text-align:right;'],
            ],
            [
                'label' => 'Management Fee',
                'attribute' => 'MgmFee',
                'format' => 'Currency',
                'contentOptions'=>['style'=>'text-align:right;'],
            ],
            [
                'label' => 'PPN',
                'attribute' => 'PPN',
                'format' => 'Currency',
                'contentOptions'=>['style'=>'text-align:right;'],
            ],
            [
                'label' => 'PPH23',
                'attribute' => 'PPH23',
                'format' => 'Currency',
                'contentOptions'=>['style'=>'text-align:right;'],
            ],
            [
                'label' => 'Total',
                'attribute' => 'Total',
                'format' => 'Currency',
                'contentOptions'=>['style'=>'text-align:right;'],
            ],
        ],
    ]); 
    ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\GoodsReceiveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Receive';
?>
<div class="goods-receive-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'GRID',
            'ItemID',
            'Qty',
            'HargaSatuan',
            'NoPV',
             'ReferenceNo',
             'SupplierName',
//             'NoFakturPajak',
             'ReceiveDate',
        ],
    ]); ?>
    
    <p>
        <?= Html::a('Create Goods Receive', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

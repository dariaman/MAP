<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\StockCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Card';
?>
<div class="stock-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'ItemID',
            'Qty',
            'TanggalTransaksi',
        ],
    ]); ?>
    
    
    <p>
        <?php Html::a('Create Stock Card', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

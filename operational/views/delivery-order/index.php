<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\DeliveryOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Order';
?>
<div class="delivery-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'DONo',
            'Qty',
            'SODID',
            'GRID',
            'DODate',
        ],
    ]); ?>
    
    <p>
        <?= Html::a('Create Delivery Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
